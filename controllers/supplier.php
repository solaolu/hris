<?php

session_start();

require_once('../models/supplier.php');
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
    
    public function register(){
        $json = json_decode(file_get_contents('php://input'), false);
        $this->model->register($json);
    }
    
    public function submitBrief(){
        $json = json_decode(file_get_contents('php://input'), false);
        $brief=$_GET['brief'];
        $json->owner = $this->user;
        $this->model->submitBrief($json, $brief);
    }
    
    public function getbriefs(){
        $this->model->getNotificationBrief($this->user);
    }
    
    public function quote(){
        $data = json_decode(file_get_contents('php://input'), false);
        $this->model->submitQuote($data);
    }
    
}


$model = new Supplier();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>