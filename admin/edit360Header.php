<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$section = $_GET['head'];
$level=$_GET['sc'];
mysqli_select_db($database_cn);
$query2 = "select section from 360_tbl where level='$level' and section='$section'";
$rs2=mysqli_query($cn, $query2);
$row_rs2=mysqli_fetch_assoc($rs2);

if ($_POST['MM_Edit']=="Edit") {
	$newP = $_POST['section'];
	$uQuery = "update 360_tbl set section='$newP' where level='$level' and section='$section'";
	mysqli_query($cn, $uQuery);
	header("location: view360.php?code=$level&msg=Header saved!");
	}

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
    <td valign="top" bgcolor="#CCCCCC"><h4>HEADERS
      </h4>
      <form id="form1" name="form1" method="post" action="?sc=<?php echo  $level; ?>&head=<?php echo $section; ?>">
        <table border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td valign="top">Section</td>
            <td valign="top"><textarea name="section" cols="40" rows="6" id="textfield"><?php echo $row_rs2['section']; ?></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="Submit" /></td>
          </tr>
        </table>
        <input type="hidden" value="Edit" name="MM_Edit" />
      </form>
    <h4>&nbsp;</h4></td>
  </tr>
</table>

</body>
</html>