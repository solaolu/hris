<?php require_once('../Connections/cn.php'); ?>
<?php
session_start();
mysqli_select_db($database_cn);
$period=$_SESSION['period'];
if ($_POST['MM_Post']=="Post") {
$query = sprintf("insert into development_tbl (owner, period, competencies, action, proposed_date) values ('%s', '%s', '%s', '%s', '%s')",
				 $_POST['owner'],$_SESSION['period'], $_POST['competencies'], $_POST['action'], $_POST['proposed_date']);
//echo $query;
mysqli_query($cn, $query) or die(mysqli_error($cn));
}

if ($_POST['period']!='') { 
$period=$_POST['period']; 
}
else {
if ($period=='') $period=$_GET['period']; 
}

$rs=mysqli_query($cn, "select * from development_tbl where owner='".$_POST['owner']."' and period='".$period."'");
$row_rs = mysqli_fetch_assoc($rs);
?>
<table cellpadding="5" cellspacing="1" bgcolor="#ffffff">
<tr><tD bgcolor="#ebebeb">Competencies, Knowledge or Skill required for Improvement</tD><tD bgcolor="#ebebeb">Action to be Taken</tD><td bgcolor="#ebebeb">Proposed Date</td></tr>
<?php do { ?>
<tr><td bgcolor="#ebebeb"><?php echo $row_rs['competencies']; ?></td><td bgcolor="#ebebeb"><?php echo $row_rs['action']; ?></td><td bgcolor="#ebebeb"><?php echo $row_rs['proposed_date']; ?></td></tr>
<?php } while($row_rs=mysqli_fetch_assoc($rs));?>
</table>