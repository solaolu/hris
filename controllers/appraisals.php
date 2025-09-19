<?php

session_start();
//$_SESSION["user"]="sola.olukoya@crm.online.com";

require_once('../models/appraisals.php');
require_once('../views/view.php'); 
require_once("../classes/cast.php");


class Controller
{
    private $model;
    private $user;

    public function __construct($model){
        $this->model = $model;
        $this->user = $_SESSION["user"];
    }
    
    public function start(){
        $this->model->start($this->user);
    }
    
    
    public function contract(){
        $this->model->getScoreCard($this->user);
    }
    
    public function save1(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->owner = $this->user;
        $this->model->saveNewAppraisalDetails($json);
    }
    
    public function savekpi(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->owner = $this->user;
        $this->model->saveKPI($json, isset($_GET['notify'])?$_GET['notify']:null);
    }
    
    public function readylines(){
        $this->model->readyLineAppraisals($this->user);
    }
    
    public function loadappraisal(){
        $user=$_GET['email'];
        $this->model->loadLineAppraisal($user);
    }
    
    public function unlock(){
        $id=$_GET['c'];
        $this->model->returnForAdjustment($id);
    }
    
    public function approve(){
        $json = json_decode(file_get_contents('php://input'), false);
        $jobcode = ($_SESSION['jobcode']=="ED" || $_SESSION['jobcode']=="EDG")?$_SESSION['jobcode']:null; //check for advanced approval
        $this->model->saveApproval($json, $jobcode);
    }
    
    public function respond(){
        $json = json_decode(file_get_contents('php://input'), false);
        $this->model->saveResponse($json);
    }

}


$model = new Appraisals();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>