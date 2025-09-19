<?php

include("classes/dao.php");

$db = new DAO();
$sql = "select * from Company";

$json = $db->executeJSON($sql);
print_r($json);

?>