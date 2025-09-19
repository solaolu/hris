<?php

session_start();
//$_SESSION["user"]="sola.olukoya@crm.online.com";

require_once('../models/journal.php');
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
        $this->model->myTasks($this->user);
    }
    
    public function add(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->addedBy = $this->user;
        $this->model->addTask($json);
    }
    
    public function delete(){
        $id = $_GET['id'];
        $this->model->deleteTask($id);
    }
    
    public function update(){
        $json = json_decode(file_get_contents('php://input'), false);
        $this->model->updateTask($json);
    }
    
    public function week(){
        $this->model->weekTasks($this->user);
    }
    
    public function report(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->owner = $this->user;
        $this->model->saveReport($json);
    }
    
    public function getreport(){
        $this->model->fetchLatestReport($_GET['f']);
    }
    
    public function line(){
        $this->model->lineTasks($this->user);
    }

}


$model = new Journal();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>