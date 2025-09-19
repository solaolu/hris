<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$code=$_GET['code'];
//mysqli_select_db($database_cn);
$query2 = "select * from gpe_tbl where id='$code'";
$rs2=mysqli_query($cn, $query2);
$row_rs2=mysqli_fetch_assoc($rs2);

$query="select distinct sc from scorecard_tbl where sc<>'".$row_rs['sc']."'";
$rs = mysqli_query($cn, $query);

if ($_POST['MM_Copy']=="Copy") {
    $scs = $_POST['sc'];
    $gpe = $row_rs2['gpeID'];
    $value="";
    for ($i=0; $i<count($scs); $i++ ){
        $value.="('$gpe','".$scs[$i]."',0),";
    }
    $value = trim($value, ',');
	$iQuery = "insert into gpe_tbl (gpeID, scorecard, isDeleted) values $value";
    
    //echo $iQuery;
    mysqli_query($cn, $iQuery);
    header("location: listGPE.php?msg=Question(s) copied!");
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
<table border="0" cellspacing="0" cellpadding="5" width=80%>
  <tr>
    <td valign="top"><h4>COPY QUESTION
      </h4>
      <form id="form1" name="form1" method="post" action="?code=<?php echo $code; ?>">
        <table border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td valign="top"><?php echo $row_rs2['gpeID']; ?></td>
          </tr>
          <tr>
            <td>
                <strong>Copy this question to the scorecards</strong> (select):<br /> 
                <?php while ($row_rs = mysqli_fetch_assoc($rs)) { ?>
                    <span class="spaced"><nobr><label><input type=checkbox name="sc[]" value="<?php echo $row_rs['sc']; ?>" /><?php echo strtoupper($row_rs['sc']); ?></label></nobr></span>
                <?php } ?>
            </td>
          </tr>
          <tr>
            <td><input type="submit" name="button" id="button" value="Copy to Selected SCs" /></td>
          </tr>
        </table>
        <input type="hidden" value="Copy" name="MM_Copy" />
      </form>
    <h4>&nbsp;</h4></td>
  </tr>
</table>

</body>
</html>