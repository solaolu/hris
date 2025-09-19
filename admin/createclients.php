<?php include('checkAdmin.php');?>
<?php require_once('Connections/cn.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO client_tbl (clientname, clientemail, password) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['clientname'], "text"),
                       GetSQLValueString($_POST['clientemail'], "text"),
					   GetSQLValueString($_POST['password'], "text"));

  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));

  //$insertGoTo = "savedJob.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}

mysqli_select_db($database_cn);
$query_Recordset1 = "SELECT * FROM client_tbl";
$Recordset1 = mysqli_query($cn, $query_Recordset1) or die(mysqli_error($cn));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body><table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top">
<?php require_once('admin_sideLinks.php'); ?>
</td>
<td valign="top" bgcolor="#ebebeb">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Client Name:</td>
      <td><input type="text" name="clientname" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Client Email:</td>
      <td><input type="text" name="clientemail" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Password: </td>
      <td valign="middle"><input type="password" name="password" id="password" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Add Client" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p><?php if ($Result1) echo "New client added successfully!"; ?></p>
<strong><?php echo $msg; ?></strong>
<table border="1" cellpadding="4" cellspacing="0">
  <tr>
    <td>Client Name</td>
    <td>Client Email</td>
    <td>Password</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['clientname']; ?></td>
      <td><?php echo $row_Recordset1['clientemail']; ?></td>
      <td><?php echo $row_Recordset1['password']; ?></td>
      <td><a href="delete.php?id=<?php echo $row_Recordset1['ID'];?>&ref=createclients.php&msg=Client information deleted&tag=client_tbl">Delete</a></td>
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
