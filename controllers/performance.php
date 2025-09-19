<?php

session_start();
//$_SESSION["user"]="sola.olukoya@crm.online.com";
require_once('../models/performance.php');
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

    public function tasks(){
        $mth=$_GET['m'];
        $yr=$_GET['y'];
        $user=$_GET['e'];
        $this->model->getPerformanceTasks($user,$mth, $yr, ($user==$this->user));
    }

    public function myperformance(){
        $mth=$_GET['m'];
        $yr=$_GET['y'];
        $user=$this->user;
        $this->model->getPerformanceTasks($user,$mth, $yr, ($user==$this->user));
    }
    
    public function savePerformance(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->owner = $this->user;
        $this->model->saveKPI($json, isset($_GET['notify'])?$_GET['notify']:null);
    }
    
    
    public function unlock(){
        $id=$_GET['c'];
        $this->model->returnForAdjustment($id);
    }

    public function evaluate(){
        $json = json_decode(file_get_contents('php://input'), false);
        $this->model->evaluate($json);
    }
    
    public function respond(){
        $json = json_decode(file_get_contents('php://input'), false);
        $this->model->saveResponse($json);
    }

}


$model = new Performance();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>