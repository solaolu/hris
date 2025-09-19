<?php require_once("../Connections/cn.php");
mysqli_select_db($database_cn);
$user = $_GET['user'];
$period = $_GET['period'];
$tbl = array("appraisal360_tbl","development_tbl","performance_tbl","kpi_details_tbl","mykpi_details_tbl","kpi_summary_tbl", "recommendation_tbl");

for ($i=0; $i < count($tbl); $i++) {
	$query = "update $tbl[$i]  set isDeleted=1  where owner='$user' and period='$period'"; 
	mysqli_query($cn, $query);
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
    <td width="351" valign="top" bgcolor="#999999">All appraisal data (<?php echo $period; ?>) for <?php echo $user; ?> has been successfully purged!</td>
  </tr>
</table>
</body>
</html>