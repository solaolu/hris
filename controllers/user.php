<?php

session_start();

require_once('../models/user.php');
require_once('../views/view.php'); 


class Controller
{
    private $model;
    private $user;

    public function __construct($model){
        $this->model = $model;
        $this->user = isset($_SESSION["user"])?$_SESSION["user"]:null;
    }

    
    public function readhandbook(){
        $this->model->readHandbook($this->user);
    }
    
    public function passwordreset(){
        $email = $_GET['email'];
        $this->model->passwordReset($email);
    }
    
    public function changepassword(){
        $data = json_decode(file_get_contents('php://input'), false);
        $data->username=$this->user;
        $this->model->changePassword($data);
    }
    
    public function login(){
        $data = json_decode(file_get_contents('php://input'), false);
        $this->model->login($data);
    }
    
    public function clock(){
        $data=$_GET['data'];
        $dir=$_GET['dir'];
        $userData = (Object) ['username'=>$this->user, 'more_info'=>$data];
        $this->model->{'clock'.$dir}($userData);
    }


}


$model = new User();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>