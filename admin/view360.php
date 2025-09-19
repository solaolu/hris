<?php require_once('../Connections/cn.php'); ?>
<?php
$level = $_GET['code'];
mysqli_select_db($database_cn);
$query = "select * from 360_tbl where level='$level'";
$rs=mysqli_query($cn, $query);
$row_rs=mysqli_fetch_assoc($rs);

$query2 = "select distinct section from 360_tbl where level='$level'";
$rs2=mysqli_query($cn, $query2);
$row_rs2=mysqli_fetch_assoc($rs2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top" >
    <p>You are viewing scorecard: <?php echo $level;?></p>
    <p><?php echo $_GET['msg']; ?></p>
    <h4>HEADERS
      </h4>
      <table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_rs2['section']; ?></td>
    <td><a href="edit360Header.php?head=<?php echo $row_rs2['section']; ?>&sc=<?php echo $level; ?>">Edit</a></td>
  </tr>
  <?php } while ($row_rs2=mysqli_fetch_assoc($rs2));?>
</table>

      <h4>KEY AREAS</h4>
      <table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do {?>
  <tr>
    <td><?php echo $row_rs['section']; ?></td>
    <td><?php echo $row_rs['title']; ?></td>
    <td><a href="edit360.php?id=<?php echo $row_rs['ID']; ?>">Edit</a></td>
    <td><a href="delete.php?msg=360 Key area successfully deleted&id=<?php echo $row_rs['ID']; ?>&tag=360_tbl&ref=view360.php&extra=code=<?php echo $level; ?>">Delete</a></td>
  </tr>
  <?php } while($row_rs=mysqli_fetch_assoc($rs)); ?>
</table>
</td>
  </tr>
</table>

</body>
</html>