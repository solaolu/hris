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
  $updateSQL = sprintf("UPDATE scorecard_tbl SET initiative=%s, rating=%s, max=%s, weight=%s WHERE ID=%s",
                       GetSQLValueString($_POST['initiative'], "text"),
                       GetSQLValueString($_POST['rating'], "text"),
					   GetSQLValueString($_POST['rating'], "text"),
					   GetSQLValueString($_POST['weight'], "text"),
                       GetSQLValueString($_POST['ID'], "int"));

  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $updateSQL) or die(mysqli_error($cn));

  $updateGoTo = "viewScorecard.php?msg=Initiative updated&code=".$_POST['sc'];
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
$query_Recordset1 = sprintf("SELECT * FROM scorecard_tbl WHERE ID = %s", GetSQLValueString($colname_Recordset1, "int"));
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
    <td valign="top"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <input type="hidden" name="sc" value="<?php echo $row_Recordset1['sc']; ?>" />
      <table align="center" cellpadding="5">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Perspective:</td>
          <td><?php echo htmlentities($row_Recordset1['perspective'], ENT_COMPAT, 'utf-8'); ?></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Sc:</td>
          <td><?php echo htmlentities($row_Recordset1['sc'], ENT_COMPAT, 'utf-8'); ?></td>
        </tr>
        <tr valign="baseline">
          <td align="right" valign="top" nowrap="nowrap">Initiative:</td>
          <td valign="top"><textarea name="initiative" cols="32" rows="5"><?php echo htmlentities($row_Recordset1['initiative'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Rating:</td>
          <td><input type="text" name="rating" value="<?php echo htmlentities($row_Recordset1['rating'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Weight:</td>
          <td><input name="weight" type="text" id="weight" value="<?php echo htmlentities($row_Recordset1['weight'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
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
