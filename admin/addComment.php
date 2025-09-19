<?php //include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
if ($_POST['MM_Post']=="Post") {
	$query = "insert into comments_tbl (tblID, rowID, comment, datePosted) values ";
	
    $insertValues = "(".$_POST['tblID'].",".$_POST['rowID'].",'".$_POST['comment']."',CURDATE())"; 
	
    $query .= $insertValues;
	$Result = mysqli_query($cn, $query) or die(mysqli_error($cn));
	
	}
	
	echo "<div style='background-color: #efefef; padding: 8px; margin-bottom:2px'>".$_POST['comment']."</div>";
?>