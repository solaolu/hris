<?php
namespace Entity;
    
class Result {

    public $isSuccessful;
    public $object;
    public $code;
    public $message;
    
    public function __construct(){
        $this->isSuccessful = false;
        //$this->message = "An error occured while performing the action failed to complete successfully";
    }
    
}