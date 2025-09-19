<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
    global $cn;
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($cn, $theValue) : mysqli_escape_string($theValue);

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

if ((isset($_POST["MM_edit"])) && ($_POST["MM_edit"] == "form1")) {
  $updateSQL = sprintf("update inventory_tbl set itemName=%s, itemTotal=%s, itemInStore=itemInStore + %s where ID=%s",
		       GetSQLValueString($_POST['itemName'], "text"),
               GetSQLValueString($_POST['qtyAvailable'], "text"),
		       GetSQLValueString($_POST['qtyAvailable'], "text"),
		       GetSQLValueString($_POST['ID'], "int"));

//echo "Query: ".$updateSQL;		      
    
    
  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $updateSQL) or die(mysqli_error($cn));

  $updateGoTo = "listinventoryitems.php?msg=Item details have been updated";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$id=$_GET['id'];
$rs=mysqli_query($cn, "select * from inventory_tbl where ID=$id") or die(mysqli_error($cn));

$row=mysqli_fetch_assoc($rs);
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
  <h3>Update Inventory Item Details</h3>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Item Name:</td>
      <td><input type="text" name="itemName" value="<?php echo $row['itemName']; ?>" size="40" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Quantity Available:</td>
      <td><input type="text" name="qtyAvailable" value="<?php echo $row['itemTotal']; ?>" /></td>
    </tr>
    <!--<tr valign="baseline">
      <td nowrap="nowrap" align="right">Material Owner:</td>
      <td><label>
        <input type="text" name="materialOwner" value="<?php echo $row['materialOwner']; ?>" />
      </label></td>
    </tr>-->
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update Item" /></td>
    </tr>
  </table>
  <input type=hidden name="ID" value="<?php echo $id; ?>" />
  <input type="hidden" name="MM_edit" value="form1" />
</form>
  </td>
</tr></table>
</body>
</html>