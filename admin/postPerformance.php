<?php require_once('../Connections/cn.php'); ?>
<?php
session_start();
mysqli_select_db($database_cn);
$period=$_SESSION['period'];
if ($_POST['MM_Post']=="Post") {
$query = sprintf("insert into performance_tbl (owner, period, key_area, target, rating) values ('%s', '%s', '%s', '%s', '%s')",
				 $_POST['owner'],$_SESSION['period'], $_POST['key_area'], $_POST['target'], $_POST['rating']);
mysqli_query($cn, $query) or die(mysqli_error($cn));
}
if ($_POST['period']!='') { 
$period=$_POST['period']; 
}
else {
if ($period=='') $period=$_GET['period']; 
}
$rs=mysqli_query($cn, "select * from performance_tbl WHERE owner ='".$_POST['owner']."' and period='".$period."'");
$row_rs = mysqli_fetch_assoc($rs);
?>
<table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
<tr><tD bgcolor="#ebebeb">KEY RESULT AREAS</tD><tD bgcolor="#ebebeb">TARGET (Completion Date)</tD><td bgcolor="#ebebeb">RATING (Obtainable)</td></tr>
<?php do { ?>
<tr><td bgcolor="#ebebeb"><?php echo $row_rs['key_area']; ?></td><td bgcolor="#ebebeb"><?php echo $row_rs['target']; ?></td><td bgcolor="#ebebeb"><?php echo $row_rs['rating']; ?></td></tr>
<?php } while($row_rs=mysqli_fetch_assoc($rs));?>
</table>