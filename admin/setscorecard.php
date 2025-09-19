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
  
  $updateSQL = sprintf("update suppliers_tbl set scorecard=%s where ID=%s",
                       GetSQLValueString($_POST['scorecard'], "text"),
		       GetSQLValueString($_POST['ID'], "int"));

//echo "Query: ".$updateSQL;		       
		       
  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $updateSQL) or die(mysqli_error($cn));
  
  echo "Saved | <a href=# onclick=\"setScorecard(this, '".$_POST['ID']."')\">Reset</a>";
}

else {
$id=$_GET['id'];

$rs=mysqli_query($cn, "select * from suppliers_tbl where ID=$id") or die(mysqli_error($cn));

$row=mysqli_fetch_assoc($rs);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td><select name="scorecard">
      <option></option>
      <?php
      $rs1=mysqli_query($cn, "select distinct scorecard from supplierKPIs_tbl");
      while ($row1=mysqli_fetch_assoc($rs1)){
      ?>
      <option value="<?php echo $row1['scorecard']; ?>" <?php if ($row1['scorecard']==$row['scorecard']) echo "selected=\"selected\""; ?> ><?php echo $row1['scorecard']; ?></option>
      <?php }  ?>
      </select>
      </td>
      <td><input type="button" value="Set Scorecard" onclick="updateScorecard($('#form1').parent())" /></td>
    </tr>
  </table>
  <input type=hidden name="ID" value="<?php echo $id; ?>" id="ID" />
  <input type="hidden" name="MM_edit" value="form1" />
</form>
<?php } ?>