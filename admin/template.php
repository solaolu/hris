<?php
require_once('checkAdmin.php');
require_once('../Connections/cn.php');

include('paginate.php');

$limit = 15;	
$page = isset($_GET['page']) ? mysqli_escape_string($cn, $_GET['page']):null;
if($page){
    $start = ($page - 1) * $limit; 
} else{
    $start = 0;	
}

$sql = "select * from supplier_tbl where status=0 ID limit $start, $limit";


//var_dump($_POST);

$rows = $db->getData($sql);
$stages=3;
$targetpage="procurementapplications.php";
$total_pages=count($rows);

$paginate=paginate($total_pages, $stages, $page, $limit, $targetpage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>
<body>
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
</body>
</html>