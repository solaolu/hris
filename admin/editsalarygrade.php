<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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
  $insertSQL = sprintf("update payslip_tbl set basic=%s, payee=%s, pension=%s, loan=%s, others=%s where ID=$ID",
                       GetSQLValueString($_POST['basic'], "text"),
                       GetSQLValueString($_POST['payee'], "text"),
		       GetSQLValueString($_POST['pension'], "text"),
		       GetSQLValueString($_POST['loan'], "text"),
		       GetSQLValueString($_POST['others'], "text"));

  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));

  $insertGoTo = "salaries.php?msg=Salary grade edited successfully!";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


mysqli_select_db($database_cn);
$query_Recordset1 = "SELECT * FROM payslip_tbl where ID=$ID";
$Recordset1 = mysqli_query($cn, $query_Recordset1) or die(mysqli_error($cn));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

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
  <h3>Edit job position -  <?php echo $row_Recordset1['paycode'];?> </h3>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Basic Salary:</td>
      <td><input type="text" name="basic" value="<?php echo $row_Recordset1['basic']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Payee:</td>
      <td><input type="text" name="payee" value="<?php echo $row_Recordset1['payee']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Pension:</td>
      <td><label>
        <input type="text" name="pension" value="<?php echo $row_Recordset1['pension']; ?>" size="32" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Loan:</td>
      <td><input type="text" name="loan" value="<?php echo $row_Recordset1['loan']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Other Deductions:</td>
      <td><label>
        <input type="text" name="others" value="<?php echo $row_Recordset1['others']; ?>" />
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
