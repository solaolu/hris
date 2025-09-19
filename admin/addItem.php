<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
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
        $insertSQL = sprintf("INSERT INTO inventory_tbl (itemName,itemTotal,itemInStore, batchID, lastUpdated) VALUES (%s, %s, $batch, CURDATE())",
                           GetSQLValueString($_POST['itemName'], "text"),
                           GetSQLValueString($_POST['qtyAvailable'], "text"),
                           GetSQLValueString($_POST['qtyAvailable'], "text"));

        mysqli_select_db($cn, $database_cn);
        $Result1 = mysqli_query($cn, $insertSQL) or die(mysqli_error($cn));      
    }
    elseif(($_POST["MM_insert"] == "form2")){
        //upload and process excel sheet here
        if (isset($_FILES['inventoryBatch'])) {
            $file=$batch."_".$_FILES['inventoryBatch']['name'];
            
            move_uploaded_file($_FILES['inventoryBatch']['tmp_name'], "../uploads/inventory/".$file);

            include '../PHPExcel/IOFactory.php';

            $inputFileName = "../uploads/inventory/$file";

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
            
            $cols = [];
            $sql="insert into inventory_tbl (itemName, itemTotal, itemInStore, lastUpdated, batchID) values ";
            for ($row = 1; $row <= $highestRow; $row++){ 
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                
                
                
                    if (!is_null($rowData[0][0])){
                    $sql .= "('".$rowData[0][0]."', ".$rowData[0][1].", ".$rowData[0][1].",CURDATE(),".$batch."), ";  

                    }
            
            }
            $sql=rtrim($sql, ", ");
            //echo $sql;
            $db->execute($sql);
        }
    }


  $insertGoTo = "listinventoryitems.php?msg=New item has been added";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
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
  <h3>Add a New Inventory Item</h3>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Item Name:</td>
          <td><input type="text" name="itemName" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Total Quantity:</td>
          <td><input type="text" name="qtyAvailable" value="" size="32" /></td>
        </tr>
        <!--<tr valign="baseline">
          <td nowrap="nowrap" align="right">Material Owner:</td>
          <td><label>
            <input type="text" name="materialOwner" />
          </label></td>
        </tr>-->
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Add Item" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
  </td>
</tr>
<tr>
    <td><hr size=1 /></td>
</tr>
<tr>
    <td>
        <form method="post"  action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
            Excel File: <input type="file" name="inventoryBatch" />
            <br><small>columns in spreadsheet should include only item name, quantity; acceptable file format: .xls, .xslx</small>
            <p><input type="submit" value="UPLOAD ITEMS" /></p>
            <input type="hidden" name="MM_insert" value="form2" />
        </form>
    </td>
</tr>
</table>
</body>
</html>