<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
require_once('../models/models.php');
require_once('../models/staff.php');
require_once('../models/leave.php');
require_once('../models/payroll.php');
require_once('../models/journal.php');

class Dashboard extends Models
{
    private $user;
    
    public function __construct($user){
            $this->db = new DAO();
        $this->user=$user;
    }
    
    private function getLeaveDays(){
        $leave = new Leave();
        $leave->daysToNextLeave($this->user);
        $res = $leave->getResult();
        return $res;
    }
    
    private function notifications(){
        $sql = "select a.*, DATE_FORMAT(a.dateadded, '%b %d, %Y') as postdate, b.fullname as SentBy from notifications_tbl as a left join staff_tbl as b on a.owner=b.email where owner='".$this->user."' limit 5";
        $result = (Object) ["object"=>null, "isSuccessful"=>false, "message"=>""];
        $res=$this->db->getData($sql);
        if (count($res)) {
            $result->isSuccessful=true;
            $result->object = $res;
        } else {
            $result->message="No notification found.";
        }
        return $result;
    }
    
    private function workTasks(){
        $journal = new Journal();
        $journal->weekTasks($this->user, null, true, "limit 5");
        $res = $journal->getResult();
        return $res;
    }
    
    public function load()
    {
     $tasks = $this->workTasks();
     $leave = $this->getLeaveDays();
     $requests = $this->notifications();
    
     $object = ["task"=>$tasks, "leave"=>$leave, "request"=>$requests];
       //var_dump($object); 
     $this->result->object=$object;
     $this->result->isSuccessful=true;
    }
}
?>