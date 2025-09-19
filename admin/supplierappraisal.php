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
  
  $updateSQL = sprintf("update suppliers_tbl set flagged=%s,flagComment=%s where ID=%s",
                       GetSQLValueString($_POST['flagged'], "text"),
		       GetSQLValueString($fcomment, "text"),
		       GetSQLValueString($_POST['ID'], "int"));

//echo "Query: ".$updateSQL;		       
		       
  mysqli_select_db($cn, $database_cn);
  $Result1 = mysqli_query($cn, $updateSQL) or die(mysqli_error($cn));

  $updateGoTo = "supplierslist.php?msg=Flag has been set as specified";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$id=$_GET['id'];
$rs=mysqli_query($cn, "select a.*, b.fullname from supplierAppraisal_tbl as a left join staff_tbl as b on a.filledBy=b.email where a.ID=$id") or die(mysqli_error($cn));

$row=mysqli_fetch_assoc($rs);
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
  <h3>SUPPLIER APPRAISAL</h3>
  <DIV style="padding: 20px;">
    As completed by: <strong><?php echo  $row['fullname']; ?></strong>
    <p>&nbsp;</p>
<table cellspacing="0" cellpadding="5">
  <tbody>
  <tr>
    <td align="right" valign=top>Date:</td>
    <td><?php echo $row['dateStamp']; ?><p>&nbsp;</p></td>
  </tr>
  <tr>
    <td align=right>Department:</td>
    <td><?php echo $row['department']; ?></td>
  </tr>
  <tr>
    <td align="right">Client:</td>
    <td><?php echo $row['clientName']; ?></td>
  </tr>
  <tr>
    <td align="right">Project Name:</td>
    <td><?php echo $row['projectName']; ?></td>
  </tr>
  <tr>
    <td align="right">Activation Date:</td>
    <td><?php echo $row['activationDate']; ?></td>
  </tr>
  <tr>
    <td align="right">Supplier:</td>
    <td><?php echo $row['supplierName']; ?></td>
  </tr>
</tbody></table>
<br>
  <?php
  $supplier=$row['supplierName'];
  //$rs1=mysqli_query($cn, "select scorecard from suppliers_tbl where supplierName='$supplier'");
$sc="GRADE1";//mysqli_result($rs1, 0, 'scorecard');

$rs1=mysqli_query($cn, "select a.*, b.metric, b.weight as metricweight from supplierKPIs_tbl as a left join supplierMetrics_tbl as b on a.metricID=b.ID where a.scorecard='$sc' order by b.metric ") or die(mysqli_error($cn));
?>
<table width="95%" border="1" cellpadding="5" cellspacing="0" bordercolor="#0000000">
  <tr>
    <td>Metric</td>
    <td>Metric Weight</td>
    <td>Weighting per sub KPI</td>
    <td>KPI</td>
    <td>Score (User Unit)</td>
    <!--<td>Comment</td>-->
    <td>KPI Measurement</td>
  </tr>
  <?php
  $metric="";
  $i=0;
  $kpiScore=explode("||", $row['KPIScore']);
  $kpiComment=explode("||", $row['scoreComments']);
  while ($row1=mysqli_fetch_assoc($rs1)) {?>
  <tr>
    <?php if ($metric!=$row1['metric']) { ?>
    <td  style="border-bottom:0px;"><?php echo $row1['metric']; ?></td>
    <td  style="border-bottom:0px;"><?php echo $row1['metricweight']; ?></td>
    <?php
    }
    else {
        ?>
    <td style="border-top:0px;border-bottom:0px;">&nbsp;</td>
    <td style="border-top:0px;border-bottom:0px;">&nbsp;</td>
        <?php
        } ?>
    <td><?php echo $row1['weight']; ?>%</td>
    <td><?php echo $row1['KPI']; ?></td>
    <td>
      <?php echo $kpiScore[$i]; ?>
    </td>
    <!--<td><?php echo $kpiComment[$i]; ?></td>-->
    <td><?php echo $row1['measurement']; ?></td>
  </tr>
  <?php
  $metric=$row1['metric'];
  $i++;
  } ?>
  <tr>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong>100%</strong></td>
    <td bgcolor="#CCCCCC"><strong>100%</strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
</table>
<br>
<table cellpadding="4">
  <tbody><tr>
    <td>Job Completion Status: </td>
    <td><?php echo $row['jobCompletionStatus']; ?></td>
  </tr>
</tbody></table>
<br>
<table cellspacing="0" cellpadding="5">
  <tbody><tr>
    <td>Invoiced Amount:</td>
    <td><?php echo $row['invoicedAmount']; ?></td>
  </tr>
  <tr>
    <td colspan="2">Project Manager Comments:
      <p><?php echo $row['comments']; ?></p></td>
    </tr>
</tbody></table>
</DIV>
  </td>
</tr></table>
</body>
</html>