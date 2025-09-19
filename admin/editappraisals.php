<?php require_once('../Connections/cn.php');?>
<?php 
mysqli_select_db($cn,$database_cn);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$ID=$_GET['id'];

if ($_POST['MM_Post']=="update"){
$query = sprintf("update time_tbl set start='%s', end='%s' where ID=$ID",$_POST['startDate'],$_POST['endDate']);

mysqli_query($cn, $query) or die(mysqli_error($cn));
$msg = "Appraisal period updated!";

  $insertGoTo = "createappraisals.php?msg=$msg";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  
}

$Rs=mysqli_query($cn, "select * from time_tbl where ID=$ID") or die(mysqli_error($cn));
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
<table border="0" cellspacing="0" cellpadding="5" width=100%>
  <tr>
    <td valign=top align=left>
	<h3>Edit Appraisal Period</h3>
	<form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
      <table border="0" cellspacing="0" cellpadding="5" bgcolor="#cccccc" >
        <tr>
          <td align="right"><strong>PERIOD</strong></td>
          <td><strong><?php echo $Row_Rs['period']; ?></strong></td>
        </tr>
        <tr>
          <td align="right"><strong>START DATE</strong></td>
          <td><input type="text" name="startDate" id="startDate" class="date-pick" value="<?php echo $Row_Rs['start']; ?>" /></td>
        </tr>
        <tr>
          <td align="right"><strong>END DATE</strong></td>
          <td><input type="text" name="endDate" id="endDate" class="date-pick" value="<?php echo $Row_Rs['end']; ?>" /></td>
        </tr>
        <tr>
          <td><input name="MM_Post" type="hidden" id="MM_Post" value="update" /></td>
          <td><input type="submit" name="button" id="button" value="Update Period" /></td>
        </tr>
      </table>
    </form>
    <strong><?php echo $msg; ?></strong></td>
  </tr>
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