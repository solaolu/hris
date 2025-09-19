<?php
require_once('email.php');
require_once('../models/models.php');
require_once('../models/staff.php');

class WorkflowObj {
    public $owner;
    public $workflow;
    public $previousState;
    public $currentState;
    public $response;
    public $recipients; //for miscellaneous and direct recipients
}

class Workflow extends Models
{
    
    public $mailbody;
    public $work;

    public function getWorkflow($name){
        $sql = "select ID from workflows_tbl where name='$name' and isDeleted=0";
        $res = $this->db->getData($sql);
        return $res[0]['ID'];
    }
    
    public function process(WorkflowObj $wf){
        $sql = "select a.*, b.nextState, b.mail_template, c.wfStateCode, '' as message, (case 
                    when c.wfStateCode = 0 then '$wf->owner'
                    when c.wfStateCode = 1 then (select linemgremail from staff_tbl where email='$wf->owner' limit 1)
                    when c.wfStateCode = 3 then (select email from staff_tbl where jobcode='MD' limit 1)
                    when c.wfStateCode = 4 then (select email from staff_tbl where jobcode='ED' limit 1)
                    when c.wfStateCode = 5 then '$wf->recipients'
                    else c.wfStateRecipient
                end) as recipient
                from workflows_tbl as a
                left join workflowStates_tbl as b on a.ID=b.workflowID
                left join workflowApprovers_tbl as c on b.nextState=c.wfStateCode
                where a.name='$wf->workflow' and b.previousState=$wf->previousState and b.currentState=$wf->currentState and b.status=$wf->response and b.isDeleted=0";
        $res = $this->db->getData($sql);
        
        if($res){
            $this->result->isSuccessful=true;
            $this->result->object=$res[0];
        }
    }

    public function start(int $previousState, int $currentState, string $workflow, string $owner, int $status, $data, $recipients=null){
        //get appropriate emails and other details to be used in notifying the appropriate parties
        $wf = new WorkflowObj();
        
        $wf->previousState = $previousState;
        $wf->currentState=$currentState;
        $wf->workflow = $workflow;
        $wf->owner = $owner;
        $wf->response = $status;
        $wf->recipients = $recipients;

        //replace owner email with name
        if (!is_null($owner)) $data->owner = (new Staff())->fullname($wf->owner);

        $this->process($wf);

        if ($this->result->isSuccessful) {
            $this->work = (Object) $this->result->object;
        }

        $data = (array) $data;

        foreach($data as $key=>$value) {
            $input['{' . $key .'}'] = $value;
        }


        //edit the message
        $this->work->message = strtr($this->work->mail_template, $input); //use ->template ?
        $this->push();

        
    }

    public function push(){

        //construct mail content and others
        $this->mailbody =  new Mailbody();

        $this->mailbody->from = "noreply@connectmarketingonline.com";
        $this->mailbody->to = $this->work->recipient;
        $this->cc = $this->work->cc;
        $this->mailbody->message = $this->work->message; //will be edited by the client

        $email  =  new Email();
        $this->result->isSuccessful = $email->send($this->mailbody);

    }
    
    public function setApproval($response){
        $response->workflowID = $this->getWorkflow($response->workflow);
        $response->approvalDate = date('Y-m-d');
        $res = $this->db->insert("workflowApprovals_tbl",$response);
    }
        
        
    
}

?>