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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO payslip_tbl (paycode, basic, payee, pension, loan, others) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['paycode'], "text"),
                       GetSQLValueString($_POST['basic'], "text"),
		       GetSQLValueString($_POST['payee'], "text"),
		       GetSQLValueString($_POST['pension'], "text"),
		       GetSQLValueString($_POST['loan'], "text"),
		       GetSQLValueString($_POST['others'], "text"));

  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));

  $insertGoTo = "savedJob.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}
mysqli_select_db($database_cn);
$query_Recordset1 = "SELECT id, paycode, basic FROM payslip_tbl";
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
  <h3>Create a new pay grade</h3>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Pay code:</td>
      <td><input type="text" name="paycode" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Basic Salary:</td>
      <td><input type="text" name="basic" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Payee:</td>
      <td><label>
        <input type="text" name="payee" size=32 />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Pension:</td>
      <td><label>
        <input type="text" name="pension" size=32>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Loan:</td>
      <td><label>
        <input type="text" name="loan" />
      </label></td>
    </tr>
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Other deductions:</td>
      <td><label>
        <input type="text" name="others" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Add Salary Grade" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

  </td>
<td valign="top" bgcolor="#ebebeb">
<p><?php if ($Result1) echo "New salary grade created successfully!"; ?></p>
<p><?php echo $_GET['msg']; ?></p>
<h3>Existing Salary Grades</h3>
<table border="1" cellpadding="4" cellspacing="0">
  <tr>
    <td>paycode</td>
    <td>basic</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['paycode']; ?></td>
      <td><?php echo $row_Recordset1['basic']; ?></td>
      <td><a href="editsalarygrade.php?id=<?php echo $row_Recordset1['id']; ?>">Edit</a></td>
      <td><a href="delete.php?id=<?php echo $row_Recordset1['id']; ?>&tag=payslip_tbl&ref=salary.php&msg=Salary grade deleted!">Delete</a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</table>
</td>
</tr></table>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
