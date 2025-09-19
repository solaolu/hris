<?php

use Entity\Memos as Memos;

session_start();
//$_SESSION["user"]="sola.olukoya@crm.online.com";

require_once('../models/memo.php');
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

    public function send() {
        
        $json = json_decode(file_get_contents('php://input'), false);
        $memo = cast('Entity\Memos', $json);
        
        $memo->setOwner($this->user);
        $this->model->send($memo);
    }
    
    public function inbox(){
        $this->model->getInbox($this->user);
    }
    
    public function outbox(){
        $this->model->getInbox($this->user);
    }
    
    public function process(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->approver = $this->user;
        $this->model->process($json);
    }
    
    public function open(){
        $json = json_decode(file_get_contents('php://input'), false);
        $this->model->open($json->id, $this->user);
    }
}


$model = new Memo();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>