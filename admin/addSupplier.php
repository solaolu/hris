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
  $insertSQL = sprintf("INSERT INTO suppliers_tbl (supplierName,category,class,services,contactPerson,officeAddress,companyEmail,companyPhoneNumber,contactPersonPhoneNumber,contactPersonEmail) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['supplierName'], "text"),
                       GetSQLValueString($_POST['category'], "text"),
		       GetSQLValueString($_POST['class'], "text"),
		       GetSQLValueString($_POST['services'], "text"),
		       GetSQLValueString($_POST['contactPerson'], "text"),
		       GetSQLValueString($_POST['officeAddress'], "text"),
		       GetSQLValueString($_POST['companyEmail'], "text"),
		       GetSQLValueString($_POST['companyPhoneNumber'], "text"),
		       GetSQLValueString($_POST['contactPersonPhoneNumber'], "text"),
		       GetSQLValueString($_POST['contactPersonEmail'], "text"));

  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));

  $insertGoTo = "supplierslist.php?msg=New supplier has been added";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
  <h3>Add a New Supplier</h3>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Supplier Name:</td>
      <td><input type="text" name="supplierName" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Category:</td>
      <td>
	<select name="category">
	  <?php
	  $rs=mysqli_query($cn, "select distinct category from suppliers_tbl");
	  while ($row=mysqli_fetch_assoc($rs)){
	  ?>
	  <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
	  <?php } ?>
	</select>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Class:</td>
      <td><label>
        <select name="class">
	  <option value="CAT A">CATEGORY A</option>
	  <option value="CAT A">CATEGORY B</option>
	  <option value="CAT A">CATEGORY C</option>
	</select>
      </label></td>
    </tr>
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Services rendered:</td>
      <td><label>
        <input type="text" name="services" />
      </label></td>
    </tr>
	    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Contact Person:</td>
      <td><label>
        <input type="text" name="contactPerson" />
      </label></td>
    </tr>
	        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Office Address:</td>
      <td><label>
        <input type="text" name="officeAddress" />
      </label></td>
    </tr>
<tr valign="baseline">
      <td nowrap="nowrap" align="right">Company Email Address:</td>
      <td><label>
        <input type="text" name="companyEmail" />
      </label></td>
    </tr>
<tr valign="baseline">
      <td nowrap="nowrap" align="right">Company Phone Number:</td>
      <td><label>
        <input type="text" name="companyPhoneNumber" />
      </label></td>
    </tr>
<tr valign="baseline">
      <td nowrap="nowrap" align="right">Contact Phone Number:</td>
      <td><label>
        <input type="text" name="contactPersonPhoneNumber" />
      </label></td>
    </tr>
<tr valign="baseline">
      <td nowrap="nowrap" align="right">Contact Person Email:</td>
      <td><label>
        <input type="text" name="contactPersonEmail" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Add Supplier" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
  </td>
</tr></table>
</body>
</html>