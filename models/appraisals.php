<?php

require_once('../models/models.php');
require_once('../models/staff.php');
require_once('../classes/workflow.php');

class Appraisals extends Models
{
    public function start($user){
        $res=array();
        $period = $this->activeAppraisalPeriod();
        if ($period!=null) $period = $period[0]["period"];
        
        $sql="select * from kpi_summary_tbl where owner='$user' and period='$period'";
        $res=$this->db->getData($sql);
        
        if (count($res)){
            $this->result->code = $res[0]["ID"];
            $this->result->message = $res[0]['period'];
            $this->result->locked=$res[0]['completed'];
            $this->result->score=$res[0]['score_summary'];
            $this->result->summary=$res[0];
            $this->result->owner=$res[0]['owner'];
            $this->getScoreCard($user);
            //print_r($this->result);
        } else {
            $this->getGPEQuestions($user);
        }
    }
    
    
    public function getGPEQuestions($owner){
        $staff =  new Staff();
        $staff->scCode($owner);
        $sc = $staff->result->code;
        $sql="select * from gpe_tbl where scorecard='$sc' order by ID asc";
        $res=$this->db->getData($sql);
        
        if (count($res)){
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        } else {
            $this->result->isSuccessful = false;
            $this->result->message = "Unable to fetch GPE questions. Please retry.";
        }
    }
    
    public function getScoreCard($user){
        $staff = new Staff();
        $staff->jobInfo($user);
        $jobInfo = $staff->result->object;
        $period=$this->activeAppraisalPeriod();
        if ($jobInfo!=null) {
            $sql = "select distinct a.*, b.score, c.score as mgr_score from scorecard_tbl as a left join (SELECT score, kpiID from mykpi_details_tbl where owner='$user' and period='".$period[0]['period']."') as b on a.ID=b.kpiID left join (SELECT score, kpiID from kpi_details_tbl where owner='$user' and period='".$period[0]['period']."') as c on a.ID=c.kpiID where sc='".$jobInfo[0]['sc_code']."'";
            $res = $this->db->getData($sql);
            if (count($res)){
                $this->result->isSuccessful = true;
                //error_log("Got a result - Issuccessful moving on to grouping");
                $this->result->object = _group_by($res, "perspective");
                //error_log("Completed grouping");
            } else {
                $this->result->isSuccessful = false;
                $this->result->message = "Unable to fetch score card. Please retry.";
            }
        }
        
    }
    
    public function saveNewAppraisalDetails($info, $savemode=null){
        $info->appraisal_date=date("d M, Y");
        $period = $this->activeAppraisalPeriod(); //get the period from the drop down of active periods
        if ($period!=null) $info->period = $period[0]["period"];
        $res=$this->db->insert("kpi_summary_tbl", $info);

        if ($res){
            $this->getScoreCard($info->owner);
            $this->result->code=$res;
            $this->result->message=$info->period;
        } else {
            $this->result->message = "Unable to start appraisal";
        }
    }
    
    public function activeAppraisalPeriod(){
        //configure for active appraisals
        $sql = "select period, start, end from time_tbl where isActive=1 and isDeleted=0 order by ID desc";
        return $this->db->getData($sql); 
    }
    
    public function saveKPI($kpis, $send=null){
        $staff = new Staff();
        $staff->jobInfo($kpis->owner);
        $jobInfo = $staff->result->object;
        
        if ($jobInfo!=null) {
            $sql = "select ID, weight from scorecard_tbl where sc='".$jobInfo[0]['sc_code']."'";
            $res = $this->db->getData($sql);
            error_log("Update!");
            $this->db->execute("update mykpi_details_tbl set isDeleted=1  where kpiSummaryID=$kpis->kpiSummaryID ");
            error_log("Updated?");
            $insertValues='';
            error_log("Generating values!");
            for ($i=0;$i<count($res);$i++){
                $key = "kpiRating".$res[$i]["ID"];
                $score = $res[$i]["weight"] * $kpis->{$key};
                $insertValues .= "('".$kpis->owner."', '".$kpis->kpiSummaryID."','".$kpis->period."',".$res[$i]["ID"].",".$score."),"; 
            }
            error_log("Completed values generation");
            $insertQuery="insert into mykpi_details_tbl (owner, kpiSummaryID, period, kpiID, score) values ";
            $insertQuery .= trim($insertValues, ",");
            
            error_log($insertQuery);
            $res = $this->db->execute($insertQuery);
            if ($res){
                $this->result->isSuccessful = true;
                $this->result->message = "KPI ratings saved successfully.";
                
                if ($send!=null) {
                    //send to line manager
                    
                    //update kpi_summary to set as complete
                    $sql="update kpi_summary_tbl set completed=1, score_summary=$kpis->score_summary where ID = ".$kpis->kpiSummaryID;
                    
                    $res = $this->db->execute($sql);
                    $this->result->message = "KPI ratings saved successfully, now awaiting Line Manager's action.";

                    $wf =  new Workflow();
                    $wf->start(0,0,"Appraisal", $kpis->owner, -1, $kpis);

                }
            }
            
        }
        
    }
    
    //LM rejects/disapproves appraisal for adjustment
    public function returnForAdjustment($id){
        $sql="update kpi_summary_tbl set completed=0 where ID = ".$id;
                    
        $res = $this->db->execute($sql);
        if ($res){
        $this->result->isSuccessful=true;
        $this->result->message = "Appraisal has been returned to owner for adjustment";
        
        //notify owner about return
        $wf = new Workflow();
        $kpi = $this->db->getData("select * from kpi_summary_tbl where ID=$id");
        $wf->start(0, 1, "Appraisal", $kpi[0]['owner'], 0, (Object) $kpi);

        }
    }
    
    public function readyLineAppraisals($user){
        $period=$this->activeAppraisalPeriod();
        $sql="select a.fullname, b.owner as email from (select fullname, email from staff_tbl where linemgremail='$user') as a left join kpi_summary_tbl as b on a.email=b.owner where b.completed=1 and b.period='".$period[0]['period']."'";
        
        $res = $this->db->getData($sql);
        if (count($res)){
            $this->result->isSuccessful=true;
            $this->result->object = $res;
        }
        
    }
    
    public function loadLineAppraisal($user){
        //$appraisal=new Appraisals();
        $this->start($user);
    }
    
    //LM rates and submits
    public function saveApproval($data, $jobCode=null){
        $staff = new Staff();
        $staff->jobInfo($data->owner);
        $jobInfo = $staff->result->object;
        
        if ($jobInfo!=null) {
            $sql = "select ID, weight from scorecard_tbl where sc='".$jobInfo[0]['sc_code']."'";
            $res = $this->db->getData($sql);
            
            $this->db->execute("update kpi_details_tbl set isDeleted=1  where kpiSummaryID=$data->kpiSummaryID ");
            
            $insertValues='';
            for ($i=0;$i<count($res);$i++){
                $key = "kpiRating".$res[$i]["ID"];
                $score = $res[$i]["weight"] * $data->{$key};
                $insertValues .= "('".$data->owner."', '".$data->kpiSummaryID."','".$data->period."',".$res[$i]["ID"].",".$score."),"; 
            }
            
            $insertQuery="insert into kpi_details_tbl (owner, kpiSummaryID, period, kpiID, score) values ";
            $insertQuery .= trim($insertValues, ",");
            
            $res = $this->db->execute($insertQuery);
            
            if ($res){
                    //send to owner

                    if ($jobCode!=null) { 
                        $query = sprintf("insert into recommendation_tbl (recommendation, comments, owner, period, madeBy, kpiSummaryID) values ('%s','%s','%s','%s', '%s')",
                        $data->recommendation, $data->comment2, $data->owner, $data->period, $data->jobcode, $data-kpiSummaryID);
                    } 
                    else {
                        $query = sprintf("update kpi_summary_tbl set approval='approved', completed=2, strengthDemonstrated='%s', improveOn='%s', comment='%s' where ID = ".$data->kpiSummaryID,
                        $data->strengthDemonstrated, $data->improveOn, $data->comment);
                    }
                
                    $res = $this->db->execute($query);
                    
                    $this->result->isSuccessful = true;
                    $this->result->message = "Your assessment and comments have been saved and processed accordingly.";

                    //notify owner of the appraisal
                    $wf = new Workflow();
                    $wf->start(0, 1, "Appraisal", $data->owner, 1, $data);

            }
            
        }
        

    }
    
    //owner of appraisal responds to LM ratings
    public function saveResponse($response){
        $sql = "update kpi_summary_tbl set completed=3, myResponse='".addslashes($response->myResponse)."', myComment='".addslashes($response->myComment)."' where ID=$response->kpiSummaryID";
        //echo $sql;
        $res = $this->db->execute($sql);
        if ($res){
            $this->result->isSuccessful=true;
            $this->result->message = "Your response has been saved and your appraisal moved on to the next stage. You will no longer be able to view your appraisal for the current period but you can view your contract by using the option in the menu.";
            
            //notify MD/ED but include HR (configured in DB?)
            $wf = new Workflow();
            $wf->start(1, 0, "Appraisal", $response->owner, 1, $response);
        }
        else {
            $this->result->message = "An error occured, we are currently unable to process your response. Please retry.";
        }
    }

    
}

function _group_by($array, $key) {
    $return = array();
    $rows = array();
    foreach($array as $val) {
        //$row["row"][]=;
        $return[$val[$key]][] = $val;
    }
    
    //convert grouped cols to array
    $i=0;
    foreach ($return as $key => $value){
        $rows[$i]["id"] = $i;
        $rows[$i]["section"] = $key;
        $rows[$i]["detail"] = $value;
        $i++;
    }
    
    return $rows;
}


?>