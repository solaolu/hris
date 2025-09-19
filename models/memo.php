<?php
use Entity\Memos as Memos;
use Entity\Result as Result;

require_once("../classes/dao.php");
require_once("../entities/Memos.php");
require_once("../entities/Result.php");
require_once("../classes/workflow.php");

class Memo {
    
    private $db;
    private $result;
    
        public function __construct(){
            $this->db = new DAO();
            $this->result = new Result;
        }
    
        public function create(){
            //new form
        }
    
        public function getByOwner($owner){
            $sql = "select * from memos_tbl where owner='$owner'";
            $this->db->getData($sql);
        }
    
        public function getByID($ID){
            $sql = "select * from memos_tbl where ID=$ID";
            $this->db->getData($sql);
        }
    
        public function getInbox($me){
            $sql  = "select a.ID, owner, SUBSTR(a.message, 1, 50) as mini_message, subject, SUBSTR(recipients, 1, 30) as recipients, b.fullname as sender, DATE_FORMAT(a.dateSent,'%b %d %Y %h:%i %p') as memo_date, (SELECT COUNT(*) FROM memoApprovals_tbl where approverName='$me' and memoID=a.ID) as pcount from memos_tbl as a left join staff_tbl as b on a.owner=b.email where recipients like '%$me%' or cc like '%$me%' order by id desc";
            $result = $this->db->getData($sql);
            
            if ($result) {
                $this->result->isSuccessful = true;
                $this->result->object = $result;
            }
        }
    
        public function getOutbox($me){
            $sql  = "select a.ID, SUBSTR(a.message, 1, 50) as mini_message, subject, SUBSTR(recipients, 1, 100) as recipients, DATE_FORMAT(a.dateSent,'%b %d %Y %h:%i %p') as memo_date from memos_tbl as a left join staff_tbl as b on a.owner=b.email where owner = '%$me%' order by id desc";
            $result = $this->db->getData($sql);
            
            if ($result) {
                $this->result->isSuccessful = true;
                $this->result->object = $result;
            }
        }
    
        public function send($memo){
            //to
            //cc
            
            //insert
            $sql="insert into memos_tbl (owner, recipients, cc, subject, attachments, message, dateSent) values ('".$memo->getOwner()."', '".$memo->getRecipients()."', '".$memo->getCc()."', '".$memo->getSubject()."', '".$memo->getAttachments()."', '".$memo->getMessage()."', NOW())";
            
            $this->result->code = $this->db->execute($sql);

            if ($this->result->code){

                $this->result->isSuccessful = true;
                $this->result->message = "Added successfully!";

                //push to workflow
                $wf = new Workflow();
                $wf->start(0,0,"Memo",$memo->getOwner(),-1, $memo, $memo->getRecipients());

            }
            
            //email
        }
    
        public function open($ID, $reader){
            $sql="select a.*, b.fullname as sender, '' as status from memos_tbl as a left join staff_tbl as b on a.owner=b.email where a.ID=$ID";
            $result = $this->db->getData($sql);
            if ($result) {
                $this->result->isSuccessful = true;
                $result[0]["status"] = $this->getStatus($result[0]["ID"]);
                $this->result->object = $result;
                //check if user is required to approve
                if (!(strpos($result[0]['recipients'], $reader)===false)) $this->result->code = 1;
            }
            //return data
        }
    
        public function getStatus($id){
            $sql="select *, b.fullname as staffname from memoApprovals_tbl as a left join staff_tbl as b on a.approverName=b.email where memoID=$id";
            $result = $this->db->getData($sql);
            return $result;            
        }
    
        public function process($memoApproval){
            if ($this->changeStatus($memoApproval)){
                $this->getInbox($memoApproval->approver);
                $this->result->message = "Your approval status has been set as indicated, you will now be redirected to your Memo inbox.";

                //notify owner
                $owner=$this->db->getData("select owner from memos_tbl where ID=".$memoApproval->memoID);
                $wf = new Workflow();
                $wf->start(0,5,"Memo", $owner[0]['owner'], $memoApproval->status=="APPROVED"?1:0, $memoApproval);
                $this->result->code = $wf->work->message;
            }
            
            //send mail
        }
    
        public function changeStatus($memoApproval){
            $sql="insert into memoApprovals_tbl (memoID, approverName, approval, remark, `date`) values ($memoApproval->memoID,'$memoApproval->approver','$memoApproval->status', '$memoApproval->remark', NOW())";
            return $this->db->execute($sql);
        }
    
        public function getResult(){
            return $this->result;
        }
}

?>