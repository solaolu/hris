<?php

session_start();
//$_SESSION["user"]="sola.olukoya@crm.online.com";

require_once('../models/payroll.php');
require_once('../views/view.php'); 


class Controller
{
    private $model;
    private $user;

    public function __construct($model){
        $this->model = $model;
        $this->user = $_SESSION["user"];
    }
    
    public function payslip(){
        $date = $_GET['paydate'];
        $this->model->getPayslip($this->user, $date);
    }

    public function archives(){
        $this->model->archives($this->user);
    }
    
    public function request(){
        $requestData = json_decode(file_get_contents('php://input'), false);
        $this->model->requestPayslip($this->user, $requestData);
    }
    
}


$model = new Payroll();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

session_unset();

?>