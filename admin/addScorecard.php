<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysqli_select_db($cn, $database_cn);
if ($_POST['MM_Post']=="Post") {
	$query = "insert into scorecard_tbl (sc, perspective, initiative, rating, weight, max, companyID) values ";
	$sc = $_POST['sc'];
	$perspective = $_POST['perspective'];
	$initiative = $_POST['initiative'];
	$rating = $_POST['rating'];
	$weight = $_POST['weight'];
	$max = $_POST['rating'];
	for ($i=0; $i < count($sc); $i++) {
		if ($sc[$i]!=""){
		if ($i!=0) $insertValues .= ", ";
		$insertValues .= "('$sc[$i]','$perspective[$i]','$initiative[$i]','$rating[$i]', $weight[$i], '$max[$i]', $admin_companyID )"; 
		}
	}
	$query .= $insertValues;
	$Result = mysqli_query($cn, $query) or die(mysqli_error($cn));
	
	}
	
	echo $insertQuery;
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
    <td valign="top" bgcolor="#CCCCCC"><?php if ($Result) echo "<h4>Scorecards added successfully!</h4>"; ?>
    <form id="form1" name="form1" method="post" action="">
      <table border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td>#</td>
          <td bgcolor="#999999">SC #</td>
          <td bgcolor="#999999">PERSPECTIVE</td>
          <td bgcolor="#999999">INITIATIVE</td>
          <td bgcolor="#999999">RATING</td>
          <td bgcolor="#999999">WEIGHT</td>
        </tr>
        <?php for ($i=1; $i<=10; $i++) { ?>
        <tr>
          <td><?php echo $i?>.</td>
          <td><label>
            <input name="sc[]" type="text" id="sc[]" size="5" />
          </label></td>
          <td><input name="perspective[]" type="text" id="perspective[]" size="40" /></td>
          <td><input name="initiative[]" type="text" id="initiative[]" size="40" /></td>
          <td><input name="rating[]" type="text" id="rating[]" size="10" /></td>
          <td><input name="weight[]" type="text" id="weight[]" size="10" /></td>
        </tr>
        <?php } ?>
        <tr>
          <td><input name="MM_Post" type="hidden" value="Post" /></td>
          <td colspan="2"><input type="submit" name="button" id="button" value="Add &gt;&gt;" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>

</body>
</html>