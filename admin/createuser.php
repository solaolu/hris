<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php require_once('../classes/email.php'); ?>
<?php
$admin_companyID=$_SESSION["user__info"]['companyID'];
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
    global $cn;
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($cn, $theValue) : mysqli_escape_string($cn, $theValue);

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
$Result1=null; $insertValues=null; $insertValues2=null;
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  //mysqli_select_db($cn, $database_cn);
  $qk = mysqli_query($cn, "select fullname from staff_tbl where email='".$_POST['linemgr']."'");
  $rsqk = mysqli_fetch_assoc($qk);
  $linemgr = $rsqk['fullname'];
  
	$team = $_POST['team'];
	for ($i=0; $i < count($team); $i++) {
		if ($i!=0) $insertValues .= ", ";
		$insertValues .= $team[$i]; 
	}
	
	$extAppraisers = $_POST['external'];
    if (!is_null($extAppraisers))	$insertValues2 .= implode(", ", $extAppraisers);
  
  $insertSQL = sprintf("INSERT INTO staff_tbl (fullname, email, department, linemgr, linemgremail, team, jobcode, companyID) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fullname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['department'], "text"),
                       GetSQLValueString($linemgr, "text"),
                       GetSQLValueString($_POST['linemgr'], "text"),
                       GetSQLValueString($insertValues, "text"),
                       GetSQLValueString($_POST['jobcode'], "text"),
					   GetSQLValueString($_POST['company'], "text"));

  $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));
    $password=randomPassword();
    $user = (Object)["email"=>$_POST['email'],"password"=>md5($password),"role"=>1];
    $db->insert("users_tbl",$user);
    
    //notify user via email with password
    $mail = new Email();
    $mailbody = new MailBody();
    
    $mailbody->from = "noreply@connectmarketingonline.com";
    $mailbody->to = $_POST['email'];
    $mailbody->message = "<p>Hello ".$_POST['fullname']."!</p><p>Your profile for the HRIS platform has been successfully created. You can now access the portal using your email and the temporary password below. Upon your first login, you are expected to change your password to one that is secure and you can easily remember.</p><blockquote>
    <strong>Temporary Password: </strong>$password</blockquote><p>If you have problems acccessing your account, please contact the Portal Administrator or HR department for assistance.</p>";
    
    $mail->send($mailbody);
    
}

//mysqli_select_db($database_cn);
$query_Recordset1 = "SELECT fullname, email FROM staff_tbl";
$Recordset1 = mysqli_query($cn, $query_Recordset1) or die(mysqli_error($cn));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

//mysqli_select_db($database_cn);
$query_Recordset2 = "SELECT jobcode, jobtitle FROM jobs_tbl";
$Recordset2 = mysqli_query($cn, $query_Recordset2) or die(mysqli_error($cn));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

//mysqli_select_db($database_cn);
$query_Recordset3 = "SELECT email, fullname FROM staff_tbl";
$Recordset3 = mysqli_query($cn, $query_Recordset3) or die(mysqli_error($cn));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

//mysqli_select_db($database_cn);
$query_Recordset4 = "SELECT * FROM staff_tbl";
$Recordset4 = mysqli_query($cn, $query_Recordset4) or die(mysqli_error($cn));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$query_Recordset5 = "SELECT * FROM client_tbl";
$Recordset5 = mysqli_query($cn, $query_Recordset5) or die(mysqli_error($cn));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);

//companies
$query_rs6 = "select ID, name from company_tbl where id<>7";
$rs6=mysqli_query($cn, $query_rs6) or die(mysqli_error($cn));
//$row_rs5=mysqli_fetch_assoc($rs6);
$totalRows_rs6=mysqli_num_rows($rs6);

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
    <td valign="top">
      <p><?php if ($Result1) echo "New staff profile created!"; ?></p>
      <a href="crmprofilelist.php">View current users list</a>
</td>
<td valign="top" bgcolor="#ebebeb">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center" cellpadding="4">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Full name:</td>
      <td><input type="text" name="fullname" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Department:</td>
      <td><input type="text" name="department" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Line Manager:</td>
      <td><select name="linemgr">
      <option value=""></option>
        <?php 
do {  
?>
        <option value="<?php echo $row_Recordset1['email']?>" ><?php echo $row_Recordset1['fullname']?></option>
        <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap">360 Appraisers:</td>
      <td><select name="team[]" size="10" multiple="multiple"  >
        <?php 
            do {  
            ?>
                    <option value="<?php echo $row_Recordset3['email']?>" ><?php echo $row_Recordset3['fullname']?></option>
                    <?php
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
        ?>    
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">360 Mode:</td>
      <td><label>
        <select name="type_of_360" id="type_of_360">
          <option value="JNR">Junior</option>
          <option value="SNR">Senior</option>
        </select>
      </label></td>
    </tr>
  <?php if ($admin_companyID==1) { ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Company:</td>
      <td><select name="company" >
        <?php 
            do {  
            ?>
                    <option value="<?php echo $row_rs6['ID']?>" ><?php echo $row_rs6['name']?></option>
                    <?php
            } while ($row_rs6 = mysqli_fetch_assoc($rs6));
        ?>    
      </select></td>
    </tr>
  <?php } else {?>
  <input type="hidden" name="company" value="<?php echo $admin_companyID ?>" />  
  <?php } ?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Job Position:</td>
      <td><select name="jobcode"><option value=""></option>
        <?php 
do {  
?>
        <option value="<?php echo $row_Recordset2['jobcode']?>" ><?php echo $row_Recordset2['jobtitle']?></option>
        <?php
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <!--<tr valign="baseline">
      <td nowrap="nowrap" align="right">Password:</td>
      <td><input type="text" name="password" value="" size="32" /></td>
    </tr>-->
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Create Staff Profile" /></td>
    </tr>
  </table>
  <input type="hidden" name="linemgremail" value="" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
      </td>
    </tr>
    </table>
<p><a href="crmprofilelist.php">View current users list</a></p>
</body>
</html>
<?php
mysqli_free_result($Recordset1);

mysqli_free_result($Recordset2);

mysqli_free_result($Recordset3);

mysqli_free_result($Recordset4);
?>
