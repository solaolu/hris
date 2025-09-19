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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE 360_tbl SET title=%s WHERE ID=%s",
					   GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $updateSQL) or die(mysqli_error($cn));

  $updateGoTo = "view360.php?msg=Key area updated&code=".$_POST['level'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysqli_select_db($database_cn);
$query_Recordset1 = sprintf("SELECT * FROM 360_tbl WHERE ID = %s", GetSQLValueString($colname_Recordset1, "int"));
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

<body>
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top" bgcolor="#CCCCCC"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <input type="hidden" name="level" value="<?php echo $row_Recordset1['level']; ?>" />
      <table align="center" cellpadding="5">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Section Title:</td>
          <td><?php echo htmlentities($row_Recordset1['section'], ENT_COMPAT, 'utf-8'); ?></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Level:</td>
          <td><?php echo htmlentities($row_Recordset1['level'], ENT_COMPAT, 'utf-8'); ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap">Key Area:</td>
          <td valign="top"><textarea name="title" cols="32" rows="5"><?php echo htmlentities($row_Recordset1['title'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Update record" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="ID" value="<?php echo $row_Recordset1['ID']; ?>" />
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>

</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
