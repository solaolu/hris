<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
if ($_POST['MM_Post']=="Post") {
	$query = "insert into 360_tbl (section, title, level) values ";
	$sc = $_POST['section'];
	$section = $_POST['section'];
	$title = $_POST['title'];
	$level = $_POST['level'];
	for ($i=0; $i < count($sc); $i++) {
		if ($sc[$i]!=""){
		if ($i!=0) $insertValues .= ", ";
		$insertValues .= "('$section[$i]','$title[$i]','$level[$i]')"; 
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
	<h3>Add 360&deg; Key Areas</h3>
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top" bgcolor="#CCCCCC"><?php if ($Result) echo "<h4>Scorecards added successfully!</h4>"; ?>
    <form id="form1" name="form1" method="post" action="">
      <table border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td>#</td>
          <td bgcolor="#999999">SECTION HEAD</td>
          <td bgcolor="#999999">KEY AREA TITLE</td>
          <td bgcolor="#999999">LEVEL</td>
        </tr>
        <?php for ($i=1; $i<=10; $i++) { ?>
        <tr>
          <td><?php echo $i?>.</td>
          <td><input name="section[]" type="text" id="section[]" size="40" /></td>
          <td><input name="title[]" type="text" id="title[]" size="40" /></td>
          <td><input name="level[]" type="text" id="level[]" size="10" /></td>
        </tr>
        <?php } ?>
        <tr>
          <td><input name="MM_Post" type="hidden" value="Post" /></td>
          <td><input type="submit" name="button" id="button" value="Add &gt;&gt;" /></td>
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