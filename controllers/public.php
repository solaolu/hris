<?php

session_start();
//$_SESSION["user"]="sola.olukoya@crm.online.com";

require_once('../models/public.model.php');
require_once('../views/view.php'); 


class Controller
{
    private $model;
    private $user;

    public function __construct($model){
        $this->model = $model;
        //$user="public";
    }
    
    public function apply(){
        $data = json_decode(file_get_contents('php://input'), false);
        $this->model->apply($data);
    }
    
}

$model = new JobApplication();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>