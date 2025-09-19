<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');?>
<?php 
mysqli_select_db($cn,$database_cn);
$msg = $_GET['msg'];
if ($_POST['MM_Post']=="Insert"){
$query = sprintf("insert into time_tbl (period, start, end, companyID) values ('%s','%s','%s', %s)",
				$_POST['period'],$_POST['startDate'],$_POST['endDate'], $admin_companyID);

mysqli_query($cn, $query) or die(mysqli_error($cn));
$msg = "New appraisal period created!";
}

$Rs=mysqli_query($cn, "select * from time_tbl where companyID=$admin_companyID order by ID desc") or die(mysqli_error($cn));
$Row_Rs = mysqli_fetch_assoc($Rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="../datePicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../jquery.min.js"></script>
    <script type="text/javascript" src="../date.js"></script>
    <script type="text/javascript" src="../jquery.datePicker.js"></script>
</head>

<body>
	<p><strong><?php echo $msg; ?></strong></p>
<table border="0" cellspacing="0" cellpadding="5" width=100%>
  <tr>
    <td valign="top" align=left bgcolor="#ebebeb" width=70%>
	<h3>Appraisal Periods</h3>
    <table border="1" cellspacing="0" cellpadding="5" width=70%>
  <tr>
    <td><strong>PERIOD</strong></td>
    <td><strong>START DATE</strong></td>
    <td><strong>END DATE</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do {?>
  <tr>
    <td><?php echo $Row_Rs['period'];?></td>
    <td><?php echo $Row_Rs['start'];?></td>
    <td><?php echo $Row_Rs['end'];?></td>
    <td><a href="editappraisals.php?id=<?php echo $Row_Rs['ID'];?>">Edit</a></td>
    <td><a href="delete.php?id=<?php echo $Row_Rs['ID'];?>&ref=createappraisals.php&msg=period deleted&tag=time_tbl">delete</a></td>
  </tr>
  <?php } while ($Row_Rs=mysqli_fetch_assoc($Rs));?>
</table>

    </td>
    <td valign=top align=left>
	<h3>Create New Appraisal Period</h3>
	<form id="form1" name="form1" method="post" action="">
      <table border="0" cellspacing="0" cellpadding="5" bgcolor="#cccccc" >
        <tr>
          <td align="right"><strong>PERIOD</strong></td>
          <td><input type="text" name="period" id="period" /></td>
        </tr>
        <tr>
          <td align="right"><strong>START DATE</strong></td>
          <td><input type="text" name="startDate" id="startDate" class="date-pick" /></td>
        </tr>
        <tr>
          <td align="right"><strong>END DATE</strong></td>
          <td><input type="text" name="endDate" id="endDate" class="date-pick" /></td>
        </tr>
        <tr>
          <td><input name="MM_Post" type="hidden" id="MM_Post" value="Insert" /></td>
          <td><input type="submit" name="button" id="button" value="Submit" /></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
  <tr><td colspan=2>
	<table border="0" cellspacing="0" cellpadding="5" width=100%>
  <tr>
    <td valign="top" align=left bgcolor="#ebebeb">
	<h3>Viewable Appraisal Data</h3>
    <table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td><strong>PERIOD</strong></td>
    <td>&nbsp;</td>
  </tr>
  <?php
  mysqli_free_result($Rs);
  $Rs=mysqli_query($cn, "select distinct period from kpi_summary_tbl as a
  left join staff_tbl as b on a.owner = b.email
  where b.companyID=$admin_companyID
  order by a.ID desc") or die(mysqli_error($cn));
  $Row_Rs = mysqli_fetch_assoc($Rs);
  do {?>
  <tr>
    <td><?php echo $Row_Rs['period'];?></td>
    <td><a href="showAppraisals.php?p=<?php echo urlencode($Row_Rs['period']); ?>">View Appraisals</a></td>
  </tr>
  <?php } while ($Row_Rs=mysqli_fetch_assoc($Rs));?>
</table>
  </td></tr>
</table>
        <script>
            $(function()
            {
		Date.format='yyyy-mm-dd';
                    $('.date-pick').datePicker({clickInput:true, createButton:false,  startDate:'01/01/1910'});
            });
    </script>
</body>
</html>