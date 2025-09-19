<?php require_once('../Connections/cn.php'); ?>
<?php
mysqli_select_db($database_cn);
$query = "select distinct level from 360_tbl";
$rs=mysqli_query($cn, $query);
$row_rs=mysqli_fetch_assoc($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div style="padding:20px;">
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top" ><p><a href="addScorecard.php">Add New 360 Appraisal Key Areas</a></p>
      <table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do {?>
  <tr>
    <td><?php echo $row_rs['level']; ?></td>
    <td><a href="view360.php?code=<?php echo $row_rs['level']; ?>">View 360 Sections</a></td>
  </tr>
  <?php } while($row_rs=mysqli_fetch_assoc($rs)); ?>
</table>
    <p><a href="add360.php">Add New 360 Appraisal Key Areas</a></p></td>
  </tr>
</table>
</div>
</body>
</html>