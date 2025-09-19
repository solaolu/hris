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


$uploaded=false;
if(isset($_POST['MM_post'])) {
    
if (isset($_FILES['payslip']) && (!is_null($_POST['payslipDate']) && ($_POST['payslipDate']!=""))) {
    
    $file=time()."_".$_FILES['leave']['name'];
    move_uploaded_file($_FILES['payslip']['tmp_name'], "../uploads/leave/".$file);
    
    include '../PHPExcel/IOFactory.php';

$inputFileName = "../uploads/leave/$file";

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
    
$cols = [];
$sql = "insert into leaveSchedule_tbl (email,year,leaveDays) values ";    
for ($row = 1; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
    
    
    //get schedule
    
            if (!is_null($rowData[0][0]) && !is_null($val)){
            $sql .= "('".$rowData[0][0]."', '".$rowData[0][1]."','".rowData[0][2]."'), ";
                
            }
    
   // mysqli_query($conn, $sql);
}
    if ($row>=1){
    trim($sql,", ");
        echo $sql;
    $db->execute($sql);
    
    $uploaded=true;
    $msg = "<strong>Leave schedule for ".($highestRow - 1)." staff members successfully uploaded.</strong>";
    }
    else {
        $msg="No record inserted, empty file detected.";
    }
} else {
    $msg = "Please make sure you have provided a valid leave schedule document (XLS or XLSX).";
}
}

                                        ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body style="margin-top:50px;">
 
 <table border="0" cellspacing="1" cellpadding="5" align=center bgcolor="#333">
  <tr><td valign=top bgcolor="#efefef">
  <h3>Upload new annual leave schedule</h3>
   <?php 
        if ($uploaded) {
            echo $msg;
        }   
   ?>
    <form action="uploadleaveschedule.php"  enctype="multipart/form-data" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Leave Schedule:</td>
              <td><input type="file" name="leave" /></td>
            </tr>
            <tr>
                <td><input type="submit" value="SUBMIT" /></td>
            </tr>
          </table>
      <input type="hidden" name="MM_post" value="form1" />
    </form>

  </td>
</tr></table>
</body>
</html>
<?php
//mysqli_free_result($Recordset1);
?>
