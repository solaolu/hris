<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); 
$db->connectPublic();
$cn2=$db->connect();
?>
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

$batch = time();
if ((isset($_POST["MM_insert"]))) {
    if (($_POST["MM_insert"] == "form1")){
        $code="V-".strtoupper(randomPassword());
        $insertSQL = sprintf("INSERT INTO vacancy_tbl (vacancyCode, jobTitle, jobDescription, endBy) VALUES (%s, %s, %s, %s)",
                           GetSQLValueString($code, "text"),  
                           GetSQLValueString($_POST['jobTitle'], "text"),
                           GetSQLValueString($_POST['jobDescription'], "text"),
                           GetSQLValueString($_POST['endBy'], "text"));

        mysqli_select_db($cn2, $database_cn);
        $Result1 = mysqli_query($cn2, $insertSQL) or die(mysqli_error($cn2));      
    }
   

  $insertGoTo = "listvacancies.php?msg=New vacancy has been added&c=".$code;
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
  <h3>Add a New Job Vacancy</h3>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Job Title:</td>
          <td><input type="text" name="jobTitle" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Description:</td>
            <td><textarea name="jobDescription" cols=40 rows="10"></textarea></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Application Deadline:<br />('YYYY-MM-DD')</td>
          <td><label>
            <input type="text" name="endBy" />
          </label></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Add Vacancy" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
  </td>
</tr>
</table>
</body>
</html>