<?php require_once('../Connections/cn.php');
mysqli_select_db($database_cn);
$id = $_GET['id'];
$tbl = $_GET['tag'];
$href = $_GET['ref']."?msg=".$_GET['msg'];
if (isset($_GET['extra'])) $href .= "&".$_GET['extra'];


$query="update $tbl  set isDeleted=1 where ID=$id";
mysqli_query($cn, $query) or die(mysqli_error($cn));	
	
header("location: $href");	
?>