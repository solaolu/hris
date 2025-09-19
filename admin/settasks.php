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
  $attendees=$_POST['assignees'];
  
  for ($i=0; $i<count($attendees); $i++){
    $attendees_list.="|".$attendees[$i]."|";
  }
  //echo  $attendees_list;
  $insertSQL = sprintf("INSERT INTO tasks_tbl (toDo, remarks, week, startDate, endDate, assignees) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['toDo'], "text"),
                       GetSQLValueString($_POST['remarks'], "text"),
		       GetSQLValueString($_POST['week'], "text"),
					   GetSQLValueString($_POST['startDate'], "text"),
					   GetSQLValueString($_POST['endDate'], "text"),
					   GetSQLValueString($attendees_list, "text"));

  //mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));

  //$insertGoTo = "savedJob.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
}


//mysqli_select_db($database_cn);
$query_Recordset1 = "SELECT * FROM tasks_tbl order by ID desc";
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
  <h2>Set Weekly Task</h2>
  <table border="0" cellspacing="0" cellpadding="10">
  <tr>
<td valign="top" bgcolor="#ebebeb" width=300>
<p><?php if ($Result1) echo "New training attendance filled successfully!"; ?></p>
<strong><?php echo $msg; ?></strong>
<table border="1" cellpadding="4" cellspacing="0">
  <tr>
    <td>Task</td>
    <td>Week</td>
    <td></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['toDo']; ?></td>
      <td><?php echo $row_Recordset1['week']; ?></td>
      <td><a href="delete.php?id=<?php echo $row_Recordset1['ID'];?>&ref=settasks.php&msg=task has been deleted&tag=tasks_tbl">Delete</a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</table>  
  <p>&nbsp;</p>
</td><td valign=top>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Task Title:</td>
      <td><input type="text" name="toDo" value="" size="32" /></td>
    </tr>
    <tr>
      <td valign=top align=right>Remarks:</td>
      <td><textarea name="remarks" rows=5 cols=35 ></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Week in Year:</td>
      <td><select name="week" >
      <option value=""></option>
      <?php
      $week=date('W');
      for ($i=1; $i<=52; $i++){ ?>
      <option value="<?php echo $i; ?>" <?php if ($week==$i) echo "selected"; ?> >WEEK <?php echo $i; ?></option>
      <?php } ?>
      </select>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Start Date:</td>
      <td valign="middle"><input type="text" name="startDate" class='date-pick' /></td>
      <td align="right" valign="middle" nowrap="nowrap">End Date:</td>
      <td valign="middle"><input type="text" name="endDate" class='date-pick' /></td>      
    </tr>
    <tr>
      <td align=right valign=top>Assignees:</td>
      <td colspan=3>(select names of staff to work on this task)
      <p>
	<?php $Rs=mysqli_query($cn, "select * from staff_tbl order by fullname asc");
	while ($Row=mysqli_fetch_assoc($Rs)){
	  ?>
	  <div class="namebox"><label><input type=checkbox value="<?php echo $Row['email']; ?>" name="assignees[]" /><?php echo $Row['fullname']; ?></label></div>
	  <?php
	}
	?></p>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Save Task" /></td>
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
