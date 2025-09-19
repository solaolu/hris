<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php

$query_Recordset4 = "SELECT a.*, b.name as companyname FROM staff_tbl as a left join company_tbl as b on a.companyID=b.ID";
$Recordset4 = mysqli_query($cn, $query_Recordset4) or die(mysqli_error($cn));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="1" cellpadding="4" cellspacing="0" width=100%>
  <tr>
    <td>fullname</td>
    <td>Email</td>
    <td>Company Name</td>
    <td>Department</td>
    <td>line Manager</td>
    <td>line Manager Email</td>
    <td>360 Appraisers</td>
    <td>Job Code</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset4['fullname']; ?></td>
      <td><?php echo $row_Recordset4['email']; ?></td>
      <td><?php echo $row_Recordset4['companyname']; ?></td>
      <td><?php echo $row_Recordset4['department']; ?></td>
      <td><?php echo $row_Recordset4['linemgr']; ?></td>
      <td><?php echo $row_Recordset4['linemgremail']; ?></td>
      <td><?php echo $row_Recordset4['team']; ?></td>
      <td><?php echo $row_Recordset4['jobcode']; ?></td>
    </tr>
    <?php } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4)); ?>
</table>
</body></html>