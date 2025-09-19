<?php

session_start();
//$_SESSION["user"]="sola.olukoya@crm.online.com";

require_once('../models/leave.php');
require_once('../views/view.php'); 


class Controller
{
    private $model;
    private $user;

    public function __construct($model){
        $this->model = $model;
        $this->user = $_SESSION["user"];
    }
    
    public function getdays(){
        $this->model->getDays($this->user);
    }
    
    public function submit(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->owner = $this->user;
        $this->model->submitRequest($json);
    }
    
    public function nextdays(){
        $this->model->allocateNextLeaveDays($this->user, true);
    }

    public function list(){
        $this->model->lineRequests($this->user);
    }

    public function process(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->owner = $this->user;
        $this->model->processRequest($json);
    }

}


$model = new Leave();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>