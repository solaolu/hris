<?php
use Entity\TrainingRequests as TrainingRequests;


session_start();
//$_SESSION["user"]="detola@connectmarketingonline.com";//"sola.olukoya@crm.online.com";

require_once('../models/training.php');
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
    
    public function requests(){
        $this->model->getMyRequests($this->user);
    }
    
    public function lineRequests(){
        $this->model->getLineRequests($this->user);
    }
    
    public function add() {
        
        $json = json_decode(file_get_contents('php://input'), false);
        $request = cast('Entity\TrainingRequests', $json);
        
        $request->setOwner($this->user);
        $this->model->add($request);
    }
    
    public function open(){
        $json = json_decode(file_get_contents('php://input'), false);
        $this->model->open($json->id, $this->user);
    }
    
    public function process(){
        $json = json_decode(file_get_contents('php://input'), false);
        $json->approver = $this->user;
        $this->model->process($json);
    }

}


$model = new Training();
$controller = new Controller($model);
$view = new View($controller, $model);


if (isset($_GET['action']) && !empty($_GET['action'])) {
    $controller->{$_GET['action']}(); //
}

header("Content-Type: application/json; charset=UTF-8");
echo $view->output();

?>