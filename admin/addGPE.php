<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
//mysqli_select_db($database_cn);
$query2 = "select distinct sc from scorecard_tbl";
$rs2=mysqli_query($cn, $query2);


if ($_POST['MM_Insert']=="Insert") {
    $gpe = $_POST['gpeID'];
    $sc = $_POST['scorecard'];

    $scs = $_POST['scorecard'];
    $value="";
    for ($i=0; $i<count($scs); $i++ ){
        $value.="('$gpe','".$scs[$i]."',0),";
    }
    $value = trim($value, ',');
	$iQuery = "insert into gpe_tbl (gpeID, scorecard, isDeleted) values $value";
	
	mysqli_query($cn, $iQuery);
	header("location: listGPE.php?msg=GPE Question added!");
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
    <td valign="top"><h4>ADD QUESTION</h4>
      <form id="form1" name="form1" method="post" action="">
        <table border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td valign="top">Question:<br /> <textarea name="gpeID" cols="60" rows="6" id="textfield"><?php echo $row_rs2['gpeID']; ?></textarea></td>
          </tr>
          <tr>
            <td>
            Applicable Scorecard(s):<br />
            <?php while ($row_rs2 = mysqli_fetch_assoc($rs2)) { ?>
                    <span class="spaced"><nobr><label><input type=checkbox name="scorecard[]" value="<?php echo $row_rs2['sc']; ?>" /><?php echo strtoupper($row_rs2['sc']); ?></label></nobr></span>
                <?php } ?>
            </td>
          </tr>
          <tr>
            <td><input type="submit" name="button" id="button" value="Add Question" /></td>
          </tr>
        </table>
        <input type="hidden" value="Insert" name="MM_Insert" />
      </form>
    <h4>&nbsp;</h4></td>
  </tr>
</table>

</body>
</html>