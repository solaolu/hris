<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$ID=$_GET['id'];

if ((isset($_POST["MM_edit"])) && ($_POST["MM_edit"] == "form1")) {
  $insertSQL = sprintf("update jobs_tbl set jobcode=%s, jobtitle=%s, sc_code=%s, paycode=%s, leaveDays=%s where ID=$ID",
                       GetSQLValueString($_POST['jobcode'], "text"),
                       GetSQLValueString($_POST['jobtitle'], "text"),
		       GetSQLValueString($_POST['scorecard'], "text"),
		       GetSQLValueString($_POST['paycode'], "text"),
		       GetSQLValueString($_POST['leaveDays'], "text"));

  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));

  $insertGoTo = "createjobs.php?msg=Job position edited successfully!";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


mysqli_select_db($database_cn);
$query_Recordset1 = "SELECT * FROM jobs_tbl where ID=$ID";
$Recordset1 = mysqli_query($cn, $query_Recordset1) or die(mysqli_error($cn));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_rs = "Select distinct sc from scorecard_tbl";
$rs = mysqli_query($cn, $query_rs);
$row_rs = mysqli_fetch_assoc($rs);

$query_rs2 = "Select distinct paycode from payslip_tbl";
$rs2 = mysqli_query($cn, $query_rs2) or die(mysqli_error($cn));
$row_rs2 = mysqli_fetch_assoc($rs2);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body><table border="0" cellspacing="0" cellpadding="5">
  <tr><td valign=top>
  <h3>Edit job position -  <?php echo $row_Recordset1['jobtitle'];?> </h3>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jobcode:</td>
      <td><input type="text" name="jobcode" value="<?php echo $row_Recordset1['jobcode']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jobtitle:</td>
      <td><input type="text" name="jobtitle" value="<?php echo $row_Recordset1['jobtitle']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Score card:</td>
      <td><label>
        <select name="scorecard" id="select">
        <?php do {?>
        <option value="<?php echo $row_rs['sc']; ?>" <?php if ($row_rs['sc']==$row_Recordset1['sc_code']) echo "selected";?> ><?php echo $row_rs['sc']; ?></option>
        <?php } while ($row_rs=mysqli_fetch_assoc($rs)); ?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Salary code:</td>
      <td><label>
        <select name="paycode" id="select">
	  <option></option>
        <?php do {?>
        <option value="<?php echo $row_rs2['paycode']; ?>" <?php if ($row_rs2['paycode']==$row_Recordset1['paycode']) echo "selected";?> ><?php echo $row_rs2['paycode']; ?></option>
        <?php } while ($row_rs2=mysqli_fetch_assoc($rs2)); ?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Leave days:</td>
      <td><label>
        <input type="text" name="leaveDays" value="<?php echo $row_Recordset1['leaveDays']; ?>" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Save Changes" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_edit" value="form1" />
</form>

  </td>

</tr></table>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
