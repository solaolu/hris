<?php

use Entity\Result as Result;

require_once("../classes/dao.php");
require_once("../entities/Result.php");

class Models
{
    protected $db;
    protected $result;
    
    public function __construct(){
            $this->db = new DAO();
            $this->result = new Result;
    }
    
    public function getResult(){
            return $this->result;
    }

}

?>