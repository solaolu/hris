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
$rs=mysqli_query($cn, "select a.*, b.fullname, c.supplierName from briefTemplate_tbl as a left join staff_tbl as b on a.filledBy=b.email left join suppliers_tbl as c on a.preferredSupplier=c.ID where a.ID=$id") or die(mysqli_error($cn));

$row=mysqli_fetch_assoc($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body><table border="0" cellspacing="0" cellpadding="5" width=80%>
  <tr><td valign=top>
  <h3>SUPPLIER BRIEFING</h3>
  <DIV style="padding: 20px;">
    Request by: <strong><?php echo  $row['fullname']; ?></strong>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table cellpadding="4" width="100%" cellspacing="0"><tbody>
      <tr>
        <td val="" ign="top"><Strong>Client:</Strong></td>
        <td val="" ign="top"><strong>Project Name:</strong></td>
      </tr>
      <tr bgcolor="#FFFFFF"><td val="" ign="top"><?php echo $row['client']; ?></td>
    <td val="" ign="top"><?php echo $row['projectName']; ?></td></tr>
    <tr>
      <td val="" ign="top" colspan="3"><strong>Department:</strong> <?php echo $row['department']; ?>
    </td></tr>
    <tr><td val="" ign="top"><strong>Event Date:</strong>
    </td><td val="" ign="top"><strong>Event Location:</strong>
    </td></tr>
    <tr bgcolor="#FFFFFF">
      <td val="" ign="top"><?php echo $row['eventDate']; ?></td>
      <td val="" ign="top"><?php echo $row['eventLocation']; ?></td>
    </tr>
    <tr>
      <td val="" ign="top"><strong>Delivery Time:</strong></td>
      <td val="" ign="top"><strong>Delivery Date:</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF"><td val="" ign="top"><?php echo $row['deliveryTime']; ?></td>
    <td val="" ign="top"><?php echo $row['deliveryDate']; ?></td></tr>
    <tr><td colspan="3"><h4>Project deliverables</h4><hr size="1"></td></tr>
    <tr>
      <th val="" ign="top" style="border:1px solid #000000;">Description</th>
      <th val="" ign="top" style="border:1px solid #000000;">Brief On Deliverable</th>
      <th val="" ign="top" style="border:1px solid #000000;">Comment</th>
    </tr>
    <?php
    $desc=explode("||", $row['description']);
    $brief=explode("||", $row['briefOnDeliverable']);
    $comment=explode("||", $row['comment']);
    for ($i=0; $i<count($desc); $i++) {
    ?>
    <tr bgcolor="#FFFFFF"><td val="" ign="top" style="border:1px solid #000000;"><?php echo $desc[$i]; ?></td><td val="" ign="top" style="border:1px solid #000000;"><?php echo $brief[$i]; ?></td><td val="" ign="top" style="border:1px solid #000000;"><?php echo $comment[$i]; ?></td></tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Supplier Name</td>
    </tr>    
    <tr bgcolor="#FFFFFF">
      <td val="" ign="top"><?php echo $row['supplierName']; ?>
    </td></tr>
    <tr><td val="" ign="top" colspan="3"><p><strong>Project Summary</strong><br></p>
    <p><?php echo $row['projectSummary']; ?></p>
    </td></tr>
    <tr>
      <td><strong>Project Manager:</strong><?php echo $row['projectManager']; ?></td>
      <td><strong>Project Sign Date:</strong><?php echo $row['projectManagerSignDate']; ?></td>
    </tr>
</tbody>
    </table>
  <input type=hidden name="ID" value="<?php echo $id; ?>" />
  <input type="hidden" name="MM_edit" value="form1" />
</form></DIV>
  </td>
</tr></table>
</body>
</html>