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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

  mysqli_select_db($cn, $database_cn);
  $qk = mysqli_query($cn, "select fullname from staff_tbl where email='".$_POST['linemgremail']."'");
  $rsqk = mysqli_fetch_assoc($qk);
  $linemgr = $rsqk['fullname'];
  $team = implode(", ", $_POST['team']);
  $ext = implode(", ", $_POST['external']);
$updateSQL = sprintf("UPDATE staff_tbl SET fullname=%s, department=%s, linemgr=%s, linemgremail=%s, team=%s, jobcode=%s, password=%s, email=%s, clientAppraiser=%s, type_of_360=%s WHERE ID=%s",
                       GetSQLValueString($_POST['fullname'], "text"),
                       GetSQLValueString($_POST['department'], "text"),
					   GetSQLValueString($linemgr, "text"),
                       GetSQLValueString($_POST['linemgremail'], "text"),
                       GetSQLValueString($team, "text"),
                       GetSQLValueString($_POST['jobcode'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString($ext, "text"),
					   GetSQLValueString($_POST['type_of_360'], "text"),
					   GetSQLValueString($_POST['ID'], "int"));

  $Result1 = mysqli_query($cn, $updateSQL) or die(mysqli_error($cn));
  
}

mysqli_select_db($database_cn);
$query_Recordset1 = "SELECT fullname, email FROM staff_tbl";
$Recordset1 = mysqli_query($cn, $query_Recordset1) or die(mysqli_error($cn));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

mysqli_select_db($database_cn);
$query_Recordset2 = "SELECT jobcode, jobtitle FROM jobs_tbl";
$Recordset2 = mysqli_query($cn, $query_Recordset2) or die(mysqli_error($cn));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

mysqli_select_db($database_cn);
$query_Recordset3 = "SELECT fullname, email FROM staff_tbl";
$Recordset3 = mysqli_query($cn, $query_Recordset3) or die(mysqli_error($cn));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$colname_Recordset4 = "-1";
if (isset($_GET['un'])) {
  $colname_Recordset4 = $_GET['un'];
}
mysqli_select_db($database_cn);
$query_Recordset4 = sprintf("SELECT ID, fullname, email, department, linemgr, linemgremail, team, jobcode, type_of_360, password, clientAppraiser FROM staff_tbl WHERE email = %s", GetSQLValueString($colname_Recordset4, "text"));
$Recordset4 = mysqli_query($cn, $query_Recordset4) or die(mysqli_error($cn));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$query_Recordset5 = "SELECT * FROM client_tbl";
$Recordset5 = mysqli_query($cn, $query_Recordset5) or die(mysqli_error($cn));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0" cellspacing="0" cellpadding="5" width="100%">
  <tr>
    <td valign="middle" bgcolor="#ebebeb">
    <?php if (!$Result1) {?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center" cellpadding="4">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fullname:</td>
      <td><input type="text" name="fullname" value="<?php echo htmlentities($row_Recordset4['fullname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo $row_Recordset4['email']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Department:</td>
      <td><input type="text" name="department" value="<?php echo htmlentities($row_Recordset4['department'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Line Manager:</td>
      <td><select name="linemgremail">
        <?php 
do {  
?>
        <option value="<?php echo $row_Recordset1['email']?>" <?php if (!(strcmp($row_Recordset1['email'], htmlentities($row_Recordset4['linemgremail'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['fullname']?></option>
        <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">360 Appraisers:</td>
      <td><select name="team[]" size="10" multiple="multiple" >
        <?php 
do {  
?>
        <option value="<?php echo $row_Recordset3['email']?>" <?php if (substr_count($row_Recordset4['team'], $row_Recordset3['email'])
) {echo "SELECTED";} ?>><?php echo $row_Recordset3['fullname']?></option>
        <?php
} while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">Client Appraiser:</td>
      <td><select name="external[]" size="10" multiple="multiple" id="external[]" >
        <?php 
do {  
?>
        <option value="<?php echo $row_Recordset5['clientemail']?>" <?php if (substr_count($row_Recordset4['clientAppraiser'], $row_Recordset5['clientemail'])
) {echo "SELECTED";} ?>><?php echo $row_Recordset5['clientname']?></option>
        <?php
} while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));
?>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">360 Mode:</td>
      <td><select name="type_of_360" id="type_of_360">
        <option value="JNR" <?php if (!(strcmp($row_Recordset4['type_of_360'], "JNR"))) {echo "SELECTED";} ?>>Junior</option>
        <option value="SNR" <?php if (!(strcmp($row_Recordset4['type_of_360'], "SNR"))) {echo "SELECTED";} ?>>Senior</option>
        <option value="JNR-DEMO" <?php if (!(strcmp($row_Recordset4['type_of_360'], "JNR-DEMO"))) {echo "SELECTED";} ?>>Junior-DEMO</option>
        <option value="SNR-DEMO" <?php if (!(strcmp($row_Recordset4['type_of_360'], "SNR-DEMO"))) {echo "SELECTED";} ?>>Senior-DEMO</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Job Position:</td>
      <td><select name="jobcode">
        <?php 
do {  
?>
        <option value="<?php echo $row_Recordset2['jobcode']?>" <?php if (!(strcmp($row_Recordset2['jobcode'], htmlentities($row_Recordset4['jobcode'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['jobtitle']?></option>
        <?php
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
?>
        </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline" style="visible:false">
      <td nowrap="nowrap" align="right">Password:</td>
      <td><input type="password" disabled name="password" value="<?php echo htmlentities($row_Recordset4['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ID" value="<?php echo $row_Recordset4['ID']; ?>" />
</form>
<?php } else { ?>
Details for <strong><?php echo $_POST['fullname']?></strong> has been updated.
<?php } ?>
</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);

mysqli_free_result($Recordset3);

mysqli_free_result($Recordset4);
?>
