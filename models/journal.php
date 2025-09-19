<?php

require_once("models.php");
require_once("../models/staff.php");

class Journal extends Models
{

    public function myTasks($user){
        $sql = "select ID as id, toDo as title, remarks as description, startDate as start, endDate as end,  'true' as allDay, '$user' as owner, addedBy from newtasks_tbl where assignees like '%$user%' or (assignees='' and addedBy='$user') and isActive=1";
        //CONCAT(YEAR(startDate), ',', MONTH(startDate), ',',DAY(startDate)) as start, CONCAT(YEAR(endDate), ',', MONTH(endDate), ',',DAY(endDate)) as end,
        $res = $this->db->getData($sql);
        
        if (count($res)) {
            $this->result->isSuccessful = true;
            $this->result->object = $res;
            
            //$user="tunji@connectmarketingonline.com";
            
                $staff = new Staff();
                $staff->subordinates($user);
            
                $this->result->code = $staff->result->object==null?[]:$staff->result->object;
        }
    }
    
    
    public function weekTasks($user, $week=null, $ignoreReport=null, $limit=null){
        if ($week==null) $week=date("W");
        $sql = "select a.*, '' as progress from newtasks_tbl as a where ((assignees like '%$user%') or (assignees='' and addedBy='$user')) and (isActive=1 and week=$week) $limit";
        $res = $this->db->getData($sql);
        
        if (count($res)){
            for ($i=0; $i<count($res); $i++){
                $sql2 = "select a.comments, a.status, a.date, b.class, b.percentage from taskProgress_tbl as a left join progressRep_tbl as b on a.status=b.status where taskID=".$res[$i]["ID"]." order by id asc";
                $res2 = $this->db->getData($sql2);
                if ($ignoreReport==null||$ignoreReport==false){
                    $res[$i]["progress"] = $res2;
                } else {
                    $res[$i]["status"] = count($res2)?$res2[count($res2)-1]:null;
                }
            }
            $this->result->isSuccessful = true;
            $this->result->object = $res;
            $this->result->code = $week;
            //if requried check if report already exists if not compile draft
            //should do this only if required
            if ($ignoreReport==null||$ignoreReport==false){
                $rep = $this->fetchReport($user, $week);
                if (count($rep)){
                    $this->result->message = $rep[0]["report"];
                    $this->result->ID = $rep[0]["ID"];
                } else {
                    $this->result->message = $this->compileReport($res);
                }
            }
            
        } else {
            $this->result->message = "Unable to retrieve your weekly tasks";
        }
    }
    
    public function addTask($task){
       $task->week = date("W", strtotime($task->startDate));
       $task->isActive = 1;
        
       $res = $this->db->insert("newtasks_tbl", $task);
        if ($res) {
            $this->result->isSuccessful = true;
            if ($task->assignees!="" && $task->assignees!=null) {
                $this->result->message = "The new task has been added and will now show up on the assignes(s) task calendar";
            } else {
                $this->result->code = $res;
            }
            
        } else {
            $this->result->isSuccessful=false;
            $this->result->message = "Unable to save task! Please retry.";
        }
    }
    
    public function updateTask($taskProgress){
        $taskProgress->date = date("Y-m-d");
        
        $res = $this->db->insert("taskProgress_tbl", $taskProgress);
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->message = "Task progress has been saved!";
        }
    }
    
    public function deleteTask($ID){
        $sql = "update newtasks_tbl set isActive='0' where ID=$ID";
        $res = $this->db->execute($sql);
        
        if ($res) {
            $this->result->isSuccessful = true;
            $this->result->message = "Task deleted successfully! It will no longer show on your task sheet.";
        }
    }
    
    public function weekReport($user, $week=null){
        
        if ($week==null) $week=date("W");
        $res = fetchReport($user, $week);
        
        if (count($res)){
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        }
    }
    
     public function fetchLatestReport($user){
        $sql = "select * from weeklyReport_tbl where owner='$user' order by week desc limit 1";
        $res = $this->db->getData($sql);
        if (count($res)){
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        } else {
            $this->result->message = "No report found!";
        } 
    }   
    
    
    public function fetchReport($user, $week){
        $sql = "select * from weeklyReport_tbl where owner='$user' and week=$week";
        return $this->db->getData($sql);
        
    }
    
    public function compileReport($data){
        $html="";
        for ($i=0; $i<count($data); $i++){
            $html.="<p><u><strong>".$data[$i]["startDate"].":&nbsp;".$data[$i]["toDo"]."</strong></u></p><p>".$data[$i]["remarks"]."</p>";
            $html.="<ul>";
            
            $timeline = $data[$i]["progress"];
                for ($j=0; $j<count($timeline); $j++){
                    $html.="<li><strong>".$timeline[$j]["date"].": ".$timeline[$j]["status"]."</strong><br />".$timeline[$j]["comments"]."</li>";
                }
            
            $html.="</ul>";
            $html.="<hr size=1 /><p>&nbsp;</p>";
        }
        
        return $html;
    }
    
    public function saveReport($report){
        $date = date("Y-m-d");
        
        $sql = "insert into weeklyReport_tbl (ID, owner, report, week, date) values ('$report->ID','$report->owner','".addslashes($report->report)."','$report->week', '$date') on duplicate key update report='".addslashes($report->report)."', date='".$date."' ";
        
        $res = $this->db->execute($sql);
        
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->message = "Week $report->week Report saved!";
        }
    }
    
    public function lineTasks($user, $week=null){
        $user="tunji@connectmarketingonline.com";
        $staff = new Staff();
        $staff->subordinates($user);
        
        $subordinates = $staff->result->object;
        if (count($subordinates)>0) {
        foreach($subordinates as &$subordinate){
            $journal=new Journal();
            $journal->weekTasks($subordinate['email'], $week, true);
            $subordinate['tasks']=$journal->result->object;
        }
        
        $this->result->isSuccessful=true;
        $this->result->object=$subordinates;
        $this->result->code=date("W");
        }
        else {
            $this->result->isSuccessful=false;
            $this->result->message = "You have no subordinates in your line, therefore you cannot view Unit tasks.";
        }
    }
    
}
?>