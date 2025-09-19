<?php require_once('../Connections/cn.php');
mysqli_select_db($database_cn);

$sc = $_GET['code'];

$href = "listScorecards.php?msg=The scorecard $sc has been deleted!";

$sc = urldecode($_GET['code']);
$query="update scorecard_tbl set isDeleted=1  where sc='$sc'";
mysqli_query($cn, $query) or die(mysqli_error($cn));	
	
header("location: $href");	
?>