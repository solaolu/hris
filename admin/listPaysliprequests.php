<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

include('paginate.php');

    $limit = 10;	
    $page = mysqli_escape_string($cn, $_GET['page']);
    if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
    }

$rs=mysqli_query($cn, "select a.*, b.fullname from payslipRequest_tbl as a left join staff_tbl as b on a.user=b.email order by a.ID desc limit $start, $limit") or die(mysqli_error($cn));

$stages=3;
$targetpage="listPaysliprequests.php";
$total_pages=mysqli_num_rows(mysqli_query($cn, "select a.ID from payslipRequest_tbl as a left join staff_tbl as b on a.user=b.email "));

$paginate=paginate($total_pages, $stages, $page, $limit, $targetpage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>
<body>
    <div style="padding: 30px;" >
    <h3>PAYSLIP REQUESTS</h3>
    <table cellpadding=5>
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No Payslip requests found.</td></tr>";
        ?>
        <tr>
            <td>FULL NAME</td><td>SLIP START DATE</td><td>DURATION</td><td>SUBMITTED ON</td>
        </tr>
    <?php while ($row=mysqli_fetch_assoc($rs)) {
        ?>
        <tr>
            <td><?php echo $row['fullname']; ?></td>
            <td><u><?php echo $row['startDate']; ?></u></td>
            <td><u><?php echo $row['duration']; ?> months</u></td>
            <td><u><?php echo $row['requestDate']; ?></u></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php echo "<div>".$paginate."</div>"; ?>
    </div>
</body>
</html>