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

if ((isset($_POST["MM_edit"])) && ($_POST["MM_edit"] == "form1")) {
  $fcomment= ($_POST['flagged']==0)?"":$_POST['flagComment'];
  
  $updateSQL = sprintf("update suppliers_tbl set flagged=%s,flagComment=%s where ID=%s",
                       GetSQLValueString($_POST['flagged'], "text"),
		       GetSQLValueString($fcomment, "text"),
		       GetSQLValueString($_POST['ID'], "int"));

//echo "Query: ".$updateSQL;		       
		       
  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $updateSQL) or die(mysqli_error($cn));

  $updateGoTo = "supplierslist.php?msg=Flag has been set as specified";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$id=$_GET['id'];
$rs=mysqli_query($cn, "select a.*, b.fullname, c.supplierName from jobCompletion_tbl as a left join staff_tbl as b on a.filledBy=b.email left join suppliers_tbl as c on a.Supplier=c.ID where a.ID=$id") or die(mysqli_error($cn));

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
  <h3>JOB COMPLETION REPORT</h3>
  <DIV style="padding: 20px;">
    As completed by: <strong><?php echo  $row['fullname']; ?></strong>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<table cellspacing="0" cellpadding="5">
  <tr>
    <td><strong>Department</strong></td>
    <td>&nbsp;</td>
    <td><strong>Filled On:</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $row['department'];?></td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?php echo $row['filledDate']; ?></td>
  </tr>
  <tr>
    <td><strong>Client</strong></td>
    <td>&nbsp;</td>
    <td><strong>Project Name</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $row['client'];?></td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?php echo $row['projectName'];?></td>
  </tr>
  <tr>
    <td><strong>User Department</strong></td>
    <td>&nbsp;</td>
    <td><strong>Activation Date</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $row['userDepartment'];?></td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?php echo $row['activationDate'];?></td>
  </tr>
  <tr>
    <td><strong>Venue</strong></td>
    <td>&nbsp;</td>
    <td><strong>Supplier</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $row['Venue'];?></td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF"><?php echo $row['supplierName'];?></td>
  </tr>
  <tr>
    <td><strong>Job Competion Status</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $row['JobCompletionStatus'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Invoice Amount</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $row['InvoiceAmount']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Comments by User Department/Project Manager</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <tD colspan=3><?php echo $row['comments']; ?></tD>
  </tr>
  <tr><td colspan=2></td></tr>
</table>
  <input type=hidden name="ID" value="<?php echo $id; ?>" />
  <input type="hidden" name="MM_edit" value="form1" />
</form></DIV>
  </td>
</tr></table>
</body>
</html>