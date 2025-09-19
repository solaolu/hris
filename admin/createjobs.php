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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jobs_tbl (jobcode, jobtitle, sc_code, paycode, leaveDays, companyID) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['jobcode'], "text"),
                       GetSQLValueString($_POST['jobtitle'], "text"),
		       GetSQLValueString($_POST['scorecard'], "text"),
		       GetSQLValueString($_POST['paycode'], "text"),
		       GetSQLValueString($_POST['leaveDays'], "text"), $admin_companyID);

  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));

  $insertGoTo = "savedJob.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}
//mysqli_select_db($database_cn);
$query_Recordset1 = "SELECT id, jobcode, jobtitle FROM jobs_tbl where companyID=$admin_companyID";
$Recordset1 = mysqli_query($cn, $query_Recordset1) or die(mysqli_error($cn));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_rs = "Select distinct sc from scorecard_tbl";
$rs = mysqli_query($cn, $query_rs);
$row_rs = mysqli_fetch_assoc($rs);

$query_rs2 = "Select distinct paycode from payslip_tbl";
$rs2 = mysqli_query($cn, $query_rs2) or die(mysqli_error($cn));
$row_rs2 = mysqli_fetch_assoc($rs2);

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
  <h3>Create a new job position</h3>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jobcode:</td>
      <td><input type="text" name="jobcode" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jobtitle:</td>
      <td><input type="text" name="jobtitle" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Score card:</td>
      <td><label>
        <select name="scorecard" id="select">
        <?php do {?>
        <option value="<?php echo $row_rs['sc']; ?>"><?php echo $row_rs['sc']; ?></option>
        <?php } while ($row_rs=mysqli_fetch_assoc($rs)); ?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Salary code:</td>
      <td><label>
        <select name="paycode" id="select">
	  <option></option>
        <?php do {?>
        <option value="<?php echo $row_rs2['paycode']; ?>"><?php echo $row_rs2['paycode']; ?></option>
        <?php } while ($row_rs2=mysqli_fetch_assoc($rs2)); ?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Leave days:</td>
      <td><label>
        <input type="text" name="leaveDays" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Add Job" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

  </td>
<td valign="top" bgcolor="#ebebeb">
<p><?php if ($Result1) echo "New job created successfully!"; ?></p>
<p><?php echo $_GET['msg']; ?></p>
<h3>Existing Job Positions</h3>
<table border="1" cellpadding="4" cellspacing="0">
  <tr>
    <td>jobcode</td>
    <td>jobtitle</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['jobcode']; ?></td>
      <td><?php echo $row_Recordset1['jobtitle']; ?></td>
      <td><a href="editjob.php?id=<?php echo $row_Recordset1['id']; ?>">Edit</a></td>
      <td><a href="delete.php?id=<?php echo $row_Recordset1['id']; ?>&tag=jobs_tbl&ref=createjobs.php&msg=Job deleted!">Delete</a></td>
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
