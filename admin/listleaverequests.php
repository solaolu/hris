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

$rs=mysqli_query($cn, "select a.ID, a.owner, b.fullname, a.LMApproval, a.fromDate, a.toDate from leaveRequests_tbl as a left join staff_tbl as b on a.owner=b.email where b.companyID=$admin_companyID order by ID desc limit $start, $limit") or die(mysqli_error($cn));

$stages=3;
$targetpage="listleaverequests.php";
$total_pages=mysqli_num_rows(mysqli_query($cn, "select a.ID from leaveRequests_tbl as a left join staff_tbl as b on a.owner=b.email where b.companyID=$admin_companyID"));

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
    <h3>LEAVE REQUESTS</h3>
    <table cellpadding=5>
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No leave requests found.</td></tr>";
    while ($row=mysqli_fetch_assoc($rs)) {
        ?>
        <tr>
            <td><?php echo $row['fullname']; ?></td>
            <td><u><?php echo $row['fromDate']."</u> to <u>".$row['toDate']; ?></u></td>
            <?php
            if ($row['LMApproval']=='') {$approval="incomplete";$color="orange";}
            if ($row['LMApproval']=='pending') {$approval="pending";$color="#ffcc00";}
            if ($row['LMApproval']=='approved') {$approval="approved";$color="green";}
            if ($row['LMApproval']=='disapproved') {$approval="disapproved";$color="red";}
            ?>
            <td style='background:<?php echo $color; ?>; color: #ffffff;' align=center><?php
            echo $approval;
            ?></td>
            <td><a href="showleaverequest.php?id=<?php echo $row['ID']; ?>">SHOW DETAILS</a></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php echo "<div>".$paginate."</div>"; ?>
    </div>
</body>
</html>