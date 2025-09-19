<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
//mysqli_select_db($database_cn);
$query = "select distinct sc from scorecard_tbl"; //where companyID=$admin_companyID";
error_log($query);
$rs=mysqli_query($cn, $query);
$row_rs=mysqli_fetch_assoc($rs);
if (isset($_GET['msg'])) $msg=urldecode($_GET['msg']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <strong><?php echo $msg; ?></strong>
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top"><p><a href="addScorecard.php">Add New Scorecard</a></p>
      <table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do {?>
  <tr>
    <td><?php echo $row_rs['sc']; ?></td>
    <td><a href="viewScorecard.php?code=<?php echo urlencode($row_rs['sc']); ?>">View Scorecard Elements</a></td>
    <td><a href="delScorecard.php?code=<?php echo urlencode($row_rs['sc']); ?>" onclick="checkBeforeDelete('<?php echo $row_rs['sc']; ?>')">Delete</a></td>
  </tr>
  <?php } while($row_rs=mysqli_fetch_assoc($rs)); ?>
</table>
    <p><a href="addScorecard.php">Add New Scorecard</a></p></td>
  </tr>
</table>
<script>
  function checkBeforeDelete(sc){
    if (!window.confirm("Are you sure you want to delete this scorecard '"+sc+"' and all it's sub-elements?")) {event.returnValue = false;}
  }
</script>
</body>
</html>