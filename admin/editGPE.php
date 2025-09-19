<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$code=$_GET['code'];
//mysqli_select_db($database_cn);
$query2 = "select * from gpe_tbl where id='$code'";
$rs2=mysqli_query($cn, $query2);
$row_rs2=mysqli_fetch_assoc($rs2);

if ($_POST['MM_Edit']=="Edit") {
	$gpe = $_POST['gpeID'];
	$uQuery = "update gpe_tbl set gpeID='$gpe' where id='$code'";
	mysqli_query($cn, $uQuery);
	header("location: listGPE.php?msg=Question updated!");
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
    <td valign="top"><h4>QUESTION
      </h4>
      <form id="form1" name="form1" method="post" action="">
        <table border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td valign="top"><textarea name="gpeID" cols="60" rows="6" id="textfield"><?php echo $row_rs2['gpeID']; ?></textarea></td>
          </tr>
          <tr>
            <td><input type="submit" name="button" id="button" value="Update" /></td>
          </tr>
        </table>
        <input type="hidden" value="Edit" name="MM_Edit" />
      </form>
    <h4>&nbsp;</h4></td>
  </tr>
</table>

</body>
</html>