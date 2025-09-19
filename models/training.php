<?php
use Entity\Result as Result;
use Entity\TrainingRequests as TrainingRequests;

require_once("../classes/dao.php");
require_once("../entities/Result.php");
require_once("../entities/TrainingRequests.php");
require_once("../classes/workflow.php");

class Training
{
    private $db;
    private $result;
    
    public function __construct(){
            $this->db = new DAO();
            $this->result = new Result;
    }
    
    public function getMyRequests($owner){
        $sql = "select ID, proposedTraining, trainingDate, trainingHours, trainingLocation, totalCost, unitHeadApproval, fundingApproval from trainingRequests_tbl where owner='$owner'";
        $res = $this->db->getData($sql);
        if (count($res)) {
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        } else {
            $this->result->code = 0;
            $this->result->isSuccessful = true;
            $this->result->message = "No training request found!";
        }
    }
    
    public function getLineRequests($user){
        $sql = "select a.ID, a.proposedTraining, a.trainingDate, a.trainingHours, a.trainingLocation, a.totalCost, b.fullname as requesterName from trainingRequests_tbl as a left join staff_tbl as b on a.owner = b.email where a.owner IN (SELECT email from staff_tbl where linemgremail='$user') and unitHeadApproval=''";
        $res = $this->db->getData($sql);
        if (count($res)) {
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        } else {
            $this->result->code = 0;
            $this->result->isSuccessful = true;
            $this->result->message = "No training request found!";
        }
    }
    
    public function add($trainingRequest){
        $res = $this->db->insert("trainingRequests_tbl", $trainingRequest);
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->message = "New request successfully added!";
            $wf = new Workflow();
            $wf->start(0,0,"Training",$trainingRequest->owner,-1, $trainingRequest);
        }
    }
    
    public function open($id, $user){
        //need to block other users from viewing?
        $sql = "select a.*, b.fullname as requesterName, b.linemgremail from trainingRequests_tbl as a left join staff_tbl as b on b.email=a.owner where a.ID=$id";
        $res = $this->db->getData($sql);
        
        if (count($res)) {
            $this->result->isSuccessful = true;
            $this->result->object = $res;
            if ($res[0]["linemgremail"]==$user) {
                $this->result->code = 1;
            }
        } else {
            $this->result->isSuccessful = false;
            $this->result->message = "Invalid training request!";
        }
    }
    
    public function process($training){
        $sql = "update trainingRequests_tbl set ";
        if ($training->mode == "LM") {
            $sql.="unitHeadApproval";
        } else {
            $sql.="fundingApproval";
        }
        $sql.="='".$training->status."' where ID=".$training->ID;
        
        $res = $this->db->execute($sql);
        if ($res) {
            $this->getLineRequests($training->by);
            if ($this->result->isSuccessful==true && $this->result->message==null) $this->result->message = "The request has been ".$training->status." as specified. You will now be redirected to your incoming requests list.";
        
            //send notifications
            $wf =  new Workflow();
            $owner = $this->db->getData("select owner from trainingRequests_tbl where ID=$training->ID");
            $wf->start(0,1, "Training", $owner[0]['owner'],  $training->status=="APPROVED"?1:0, $training);
        }
    }
    
    public function getResult(){
            return $this->result;
    }
}

?>