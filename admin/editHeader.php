<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$p = $_GET['head'];
$sc=$_GET['sc'];
mysqli_select_db($database_cn);
$query2 = "select perspective from scorecard_tbl where sc='$sc' and perspective='$p'";
$rs2=mysqli_query($cn, $query2);
$row_rs2=mysqli_fetch_assoc($rs2);

if ($_POST['MM_Edit']=="Edit") {
	$newP = $_POST['perspective'];
	$uQuery = "update scorecard_tbl set perspective='$newP' where sc='$sc' and perspective='$p'";
	mysqli_query($cn, $uQuery);
	header("location: viewScorecard.php?code=$sc&msg=Header saved!");
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
    <td valign="top"><h4>HEADERS
      </h4>
      <form id="form1" name="form1" method="post" action="?sc=<?php echo  $sc; ?>&head=<?php echo $p; ?>">
        <table border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td valign="top">PERSPECTIVE</td>
            <td valign="top"><textarea name="perspective" cols="40" rows="6" id="textfield"><?php echo $row_rs2['perspective']; ?></textarea></td>
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