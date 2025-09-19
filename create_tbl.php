<?php

include('classes/dao.php');

$db = new DAO();
$tbl = $_GET['t'];

$sql = "CREATE TABLE $tbl (
ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";

foreach($_POST as $key=>$val){
    $sql.= "`$key` VARCHAR(255) NOT NULL, ";
}

$sql .= "requestDate TIMESTAMP)";

$db->execute($sql);

?>