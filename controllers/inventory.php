<?php

session_start();
//$_SESSION["user"]="sola.olukoya@crm.online.com";

require_once('../models/inventory.php');
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
    
    public function items(){
        $this->model->getItems();
    }
    
    public function requestItem(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->owner = $this->user;
        $json->requestDate = date("Y-m-d H:i:s");
        $this->model->newRequest($json);
    }
    
}


$model = new Inventory();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>