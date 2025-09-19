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
  $attendees=$_POST['attendees'];
  
  for ($i=0; $i<count($attendees); $i++){
    $attendees_list.="|".$attendees[$i]."|";
  }
  //echo  $attendees_list;
  $insertSQL = sprintf("INSERT INTO trainingAttendance_tbl (trainingTitle, trainingDuration, trainingDate, attendees) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['trainingTitle'], "text"),
                       GetSQLValueString($_POST['trainingDuration'], "text"),
					   GetSQLValueString($_POST['trainingDate'], "text"),
					   GetSQLValueString($attendees_list, "text"));

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
$query_Recordset1 = "SELECT * FROM trainingAttendance_tbl";
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
<script type="text/javascript" src="../jquery.min.js"></script>
<link href="../datePicker.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../date.js"></script>
    <script type="text/javascript" src="../jquery.datePicker.js"></script>
</head>

<body>
  <h2>Internal Training Attendance</h2>
  <table border="0" cellspacing="0" cellpadding="10">
  <tr>
<td valign="top" bgcolor="#ebebeb" width=300>
<p><?php if ($Result1) echo "New training attendance filled successfully!"; ?></p>
<strong><?php
$msg=$_GET['msg'];
echo $msg; ?></strong>
<table border="1" cellpadding="4" cellspacing="0">
  <tr>
    <td>Training Title</td>
    <td>Duration</td>
    <td>Date</td>
    <td></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['trainingTitle']; ?></td>
      <td><?php echo $row_Recordset1['trainingDuration']; ?></td>
      <td><?php echo $row_Recordset1['trainingDate']; ?></td>
      <td><a href="delete.php?id=<?php echo $row_Recordset1['ID'];?>&ref=attendance.php&msg=attendance information deleted&tag=trainingAttendance_tbl">Delete</a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</table>  
  <p>&nbsp;</p>
</td><td valign=top>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Training Name:</td>
      <td><input type="text" name="trainingTitle" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Duration:</td>
      <td><select name="trainingDuration" >
      <option value=""></option>
      <option value="1">1 HOUR</option>
      <?php for ($i=2; $i<=10; $i++){ ?>
      <option value="<?php echo $i; ?>"><?php echo $i; ?> HOURS</option>
      <?php } ?>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Training Date:</td>
      <td valign="middle"><input type="text" name="trainingDate" class='date-pick' /></td>
    </tr>
    <tr>
      <td align=right valign=top>Attendees:</td>
      <td>(select names of attendees)
      <p>
	<?php $Rs=mysqli_query($cn, "select * from staff_tbl order by fullname asc");
	while ($Row=mysqli_fetch_assoc($Rs)){
	  ?>
	  <div class="namebox"><label><input type=checkbox value="<?php echo $Row['email']; ?>" name="attendees[]" /><?php echo $Row['fullname']; ?></label></div>
	  <?php
	}
	?></p>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Complete Attendance" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</td>
</tr></table>
  
        <script>
            $(function()
            {
		Date.format='d/m/yyyy';
                $('.date-pick').datePicker({clickInput:true, createButton:false,  startDate:'01/01/1910'});
            });
    </script>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
