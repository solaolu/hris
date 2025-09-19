<?php

require_once("models.php");
require_once("../models/staff.php");
require_once("../classes/workflow.php");

class Leave extends Models
{
    public function getDays($user){
        $year = date("Y");
        $sql = "select leaveDays as days from leaveDays_tbl where email='$user' and year=$year and isDeleted=0 order by id desc limit 1";
        $res = $this->db->getData($sql);
        
        if (count($res)) {
            $this->result->isSuccessful=true;
            $this->result->object=$res;
            $this->result->code=$this->split_days($res[0]);
        }
        else {
            $this->result->message = "No leave days found!";
        }
    }
    
    public function split_days($days){
        $array = explode(",", $days["days"]);
        $id_array = preg_filter('/^/', '#D-', $array);
        return $id_array;
    }
    
    public function submitRequest($request){
        $diff = strtotime($request->fromDate) - strtotime(date("Y-m-d"));
        if ($diff < (60 * 60 * 24 * 7)){
            $this->result->isSuccessful = false;
            $this->result->message = "Unable to complete your leave request! Please contact HR, You cannot make a request less than 1 week ($diff)to your leave start date";
            return 0;
        }
        
        $res = $this->db->insert("leaveRequests_tbl", $request);
        
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->message = "Your request has been successfully submitted and sent to your Line Manager for action.";

            $workflow=new Workflow();
            $workflow->start(0, 0, "Leave", $request->owner, -1, $request);

        } else {
            $this->result->message = "Request submission failed!";
            $this->result->object  = $request;
        }
    }

    public function lineRequests($user){
        //and (a.LMApproval IS NULL or a.LMApproval='' or a.LMApproval='pending')
        $sql = "select a.*, b.fullname from leaveRequests_tbl as a left join staff_tbl as b on a.owner=b.email where b.linemgremail='$user'  and a.isDeleted=0 and b.isDeleted=0";
        $res=$this->db->getData($sql);

        if (count($res)){
            $this->result->isSuccessful=true;
            $this->result->object = $res;

        } else {
            $this->result->message="You have no pending leave requests to approve!";
        }
    
    }

    public function processRequest($response){
        $approver = $response->app."Approval";
        $approverDate = $response->app."ApprovalDate";
        $sql = "update leaveRequests_tbl set $approver='".$response->status."', $approverDate='".date("d-m-Y  h:i:sa")."' where ID=".$response->ID;
        
        if ($this->db->execute($sql)) {
            //send status mail to HR and Staff using workflow
            //construct workflow object and pass parameters

            $owner=$this->db->getData("select owner from leaveRequests_tbl where ID=".$response->ID);

            $workflow = new Workflow();
            $workflow->start(0, 1, "Leave", $owner[0]['owner'], $response->status=="approved"?1:0, $response);

            $this->result->code = $workflow->work->message; //$workflow->result->isSuccessful;

            $this->result->isSuccessful=true;
            $this->result->message = "The leave request has now been $response->status";
        } else {
            $this->result->message = "Unable to process leave request, please retry.";
        }


    }
    
    public function allocateNextLeaveDays($user, $withProfile=null){
        $this->getDays($user);
        
        if ($this->result->isSuccessful){
            $res = $this->result->object;
            $days = $res[0]["days"];
            $days_arr = explode(",", $days);
            
            usort($days_arr, "date_sort");
            //var_dump($days_arr);
            $nextdays = $this->getConsecutiveDays($days_arr);
            $this->result->object = $nextdays[0];
            $this->result->code = count($nextdays[0]);
            $this->result->start = reset($nextdays[0]);
            $this->result->finish = end($nextdays[0]);
            
            if ($withProfile){
                $staff = new Staff();
                $staff->profile($user);
                $this->result->profile = $staff->result->object;
            }
            
        }
    }
    
    public function daysToNextLeave($user){
        $this->getDays($user);
        $datediff=0;
        $nextday=null;
        if ($this->result->isSuccessful){
            $res = $this->result->object;
            $days = $res[0]["days"];
            $days_arr = explode(",", $days);
            
            usort($days_arr, "date_sort");
            
            foreach($days_arr as $day){
                $datediff= strtotime($day."-".date("Y")) - time();
                if ($datediff>0){
                    $nextday=date("M, d Y", strtotime($day."-".date("Y")));
                    break;
                }
            }
            
        }
        
        $ddays = (int) ($datediff / (60 * 60 * 24));
        $ddays = ($ddays < 1) ? 0: $ddays;
        
        $this->result->object = ["daysLeft"=>$ddays, "day"=>$nextday];
    }
     
    
    public function getConsecutiveDays($dates){
        $conseq = array(); 
        $ii = 0;
        $max = count($dates);
        
        //var_dump($dates);

        for($i = 0; $i < count($dates); $i++) {
            $conseq[$ii][] = date('Y-m-d',strtotime($dates[$i]."-".date("Y")));
            $btwWeekend=false;
            
            if($i + 1 < $max) {
                $dif = strtotime($dates[$i + 1]."-".date("Y")) - strtotime($dates[$i]."-".date("Y"));
                
                $curr_day_of_week = date('D',strtotime($dates[$i]."-".date("Y")));
                $next_day_of_week = date('D',strtotime($dates[$i+1]."-".date("Y")));
                
                if ($curr_day_of_week=="Fri" && $next_day_of_week=="Mon" && $dif == 259200 ){
                    $btwWeekend=true;
                }
                
                
                if($dif >= 90000 && !$btwWeekend) {
                    $ii++;
                }   
            }
        }
        
        return $conseq;
    }
}


    function date_sort($a, $b) {
            return strtotime($a."-".date("Y")) - strtotime($b."-".date("Y"));
    }

?>