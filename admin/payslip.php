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
    
    $file=time()."_".$_FILES['payslip']['name'];
    move_uploaded_file($_FILES['payslip']['tmp_name'], "../uploads/payslips/".$file);
    
    include '../PHPExcel/IOFactory.php';

$inputFileName = "../uploads/payslips/$file";

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
for ($row = 1; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
    
    
    //get allowances and deductions
    if ($row==1){
        foreach(array_slice($rowData[0],1) as $col){
            $colinfo=[];
            if (substr($col,0,1)=="_"){
                $col=ltrim($col,"_");
                $tbl = "payroll_deductions_tbl";
                $tblcol="deductionName";
                array_push($colinfo, 2);
            } else {
                $tbl = "payroll_incomes_tbl";
                $tblcol="incomeName";
                array_push($colinfo, 1);
            }
            
            
            $sql = "insert into $tbl (deductionName) select '$col' from DUAL where not exists (select deductionName from $tbl where LOWER($tblcol)='".strtolower($col)."' )";
            
            $db->execute($sql);
            $colid = $db->getLastInsertID();
            
            if ($colid==0) {
                //get the id of already existing column
                $sql = "select ID from $tbl where LOWER($tblcol)='".strtolower($col)."'";
                $res = $db->getData($sql);
                $colid = $res[0]['ID'];
            }
            array_push($colinfo, $colid);
            array_push($cols, $colinfo);
        }
        
    } 
    //get breakdown
    else {
    
        foreach(array_slice($rowData[0],1) as $index=>$val){
            $coldata=""; 
            $coldata .= "'$val',";
            
            //check/ignore null jobcode and null amount
            if (!is_null($rowData[0][0]) && !is_null($val)){
            $sql = "insert into payroll_tbl (jobCode,payType,payTypeID,amount,payslipDate) values ('".$rowData[0][0]."', '".$cols[$index][0]."','".$cols[$index][1]."','".$val."','".$_POST['payslipDate']."')";
            $db->execute($sql);
                
            }
        }
        
    }
    
    
    
   // mysqli_query($conn, $sql);
}

    $uploaded=true;
    $msg = "<strong>Payroll schedule for ".($highestRow - 1)." staff members successfully uploaded for .</strong>";
} else {
    $msg = "Please make sure you have provided a valid date and schedule document (XLS or XLSX) for the payroll schedule";
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
  <h3>Upload new payroll schedule</h3>
   <?php 
        if ($uploaded) {
            echo $msg;
        }   
   ?>
    <form action="payslip.php"  enctype="multipart/form-data" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Pay Slip:</td>
              <td><input type="file" name="payslip" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Date</td>
              <td><input type="text" name="payslipDate" value="" size="32" /></td>
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
