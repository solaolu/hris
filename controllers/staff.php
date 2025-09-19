<?php
session_start();

require_once('../models/staff.php');
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

    public function getAll() {
        $this->model->getAll();
    }
    
    public function subordinates(){
        $this->model->subordinates($this->user);
    }
    
    public function profile(){
        $this->model->profile($this->user, true);
    }
    
    public function saveprofile(){
        $profile = json_decode(file_get_contents('php://input'), false);
        $profile->email = $this->user;
        $this->model->save($profile);
    }
    
    public function editprofile(){
        $this->model->editProfile($this->user);
    }
    
    public function updateprofile()
    {
        $profile = json_decode(file_get_contents('php://input'), false);
        $profile->email = $this->user;
        $this->model->update($profile);
    }
    
    public function updatedependent()
    {
        $profile = json_decode(file_get_contents('php://input'), false);
        $this->model->updateDependent($profile);
    }
    
    public function detachdependent(){
        $ID=$_GET['id'];
        $this->model->detachDependent($ID, $this->user);
    }
}


$model = new Staff();
$controller = new Controller($model);
$view = new View($controller, $model);

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>