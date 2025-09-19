<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');
mysqli_select_db($database_cn);
	$query="select distinct a.owner, b.fullname from kpi_summary_tbl as a left join staff_tbl as b on a.owner=b.email where a.period='".urldecode($_GET['p'])."' and a.approval=''";
	$recordset = mysqli_query($cn, $query) or die(mysqli_error($cn));
	$row_recordset = mysqli_fetch_assoc($recordset);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script>
function notify(){
	ans = confirm("Are you sure you want to delete all appraisal information relating to this period for this user?");	
	if (ans) event.returnValue = true; else event.returnValue = false;
	}
</script>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
<td valign="top" bgcolor="#ebebeb">
<h3><?php
$period=urldecode($_GET['p']);
echo $period;?> (IN PROGRESS)</h3>
<p><a href="showAppraisals.php?p=<?php echo $_GET['p']; ?>">Click here to view treated Appraisals</a></p>
<?php 
	echo "<table cellpadding=5>";
	if (mysqli_num_rows($recordset)) {
	do {
		?>
        <tr>
    <tD><?php echo $row_recordset['fullname'];?></tD>    
	<td><a href="staffAppraisalData.php?period=<?php echo urlencode($period);?>&un=<?php echo $row_recordset['owner'];?>" >View Appraisal Details</a> | </td>
    <td><a href="360Report.php?period=<?php echo urlencode($period);?>&un=<?php echo $row_recordset['owner'];?>" >View 360 Report</a> | </td>
    <td><a href="purge.php?period=<?php echo urlencode($period); ?>&user=<?php echo $row_recordset['owner'];?>" onclick="notify()" >Purge Appraisal</a></td>	
    </tr>
		<?php
		} while ($row_recordset = mysqli_fetch_assoc($recordset));
	}
	else {
		echo "<tr><td>No appraisals listed</td></tr>";
	}
	echo "</table>";
?>
</td></tr></table>
</body>
</html>