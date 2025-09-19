<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');
mysqli_select_db($database_cn);
$user = $_GET['un'];

/*
$query[0]="delete from staff_tbl where email='$user'";
$query[1]="delete from appraisal360_tbl where owner='$user'";
$query[2]="delete from kpi_details_tbl where owner='$user'";
$query[3]="delete from kpi_summary_tbl where owner='$user'";
$query[4]="delete from my360_tbl where owner='$user'";
*/

$query[0]="update staff_tbl set isDeleted=1 where email='$user'";
$query[1]="update appraisal360_tbl set isDeleted=1  where owner='$user'";
$query[2]="update kpi_details_tbl set isDeleted=1  where owner='$user'";
$query[3]="update kpi_summary_tbl set isDeleted=1  where owner='$user'";
$query[4]="update my360_tbl set isDeleted=1  where owner='$user'";

for ($i=0; $i<5; $i++) {
mysqli_query($cn, $query[$i]);	
	}
	
header("location: userMgt.php");	
?>