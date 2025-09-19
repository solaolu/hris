<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

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
    <?php
    $id=$_GET['id'];
        $extraparams.="&id=$id";
        $rs=mysqli_query($cn, "select a.*, b.fullname, b.department from leaveRequests_tbl as a left join staff_tbl as b on a.owner=b.email where a.ID=$id") or die(mysqli_error($cn));
        if (!mysqli_num_rows($rs)) {
            echo "<p>Invalid Record</p>";
            } else {
        $row=mysqli_fetch_assoc($rs);
        ?>
        <p>&nbsp;</p>
        <table wi dth="70%" cellspacing="0" cellpadding="5">
  <tr>
    <td align="right"><strong>Home Address</strong></td>
    <td><?php echo $row['homeAddress']; ?></td>
  </tr>
  <tr>
    <td align="right"><strong>Address while on leave</strong></td>
    <td><?php echo $row['leaveAddress']; ?></td>
  </tr>
  <tr>
    <td align="right"><strong>Phone number while on leave</strong></td>
    <td><?php echo $row['leavePhone']; ?></td>
  </tr>
  <tr>
    <td align="right"><strong>Next of kin Information</strong></td>
    <td><?php echo $row['nokInformation']; ?></td>
  </tr>
  <tr>
    <td align="right"><strong>Total Leave Days Requested</strong></td>
    <td><?php echo $row['totalLeaveDays']; ?></td>
  </tr>
  <tr>
    <td align="right"><strong>Leave Request Period</strong></td>
    <td><?php echo $row['fromDate']." - ".$row['toDate']; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong>Leave Made up of</strong></td>
    <td><?php echo $row['annualLeaveDays']; ?> - Annual Leave Days<br />
      <?php echo $row['sickLeaveDays']; ?> - Sick Leave Days<br />
<?php echo $row['maternityLeaveDays']; ?> - Maternity Leave Days<br />
<?php echo $row['unpaidLeaveDays']; ?> - Unpaid Leave Days<br />
<?php echo $row['studyLeaveDays']; ?> - Study Leave Days<br />
<?php echo $row['paternityLeaveDays']; ?> - Paternity Leave Days<br />
<?php echo $row['casualLeaveDays']; ?> - Casual Leave Days<br />
<?php echo $row['examLeaveDays']; ?> - Exam Leave Days<br /></td>
  </tr>
  <tr>
    <td align="right"><strong>Application Date</strong></td>
    <td><?php echo $row['applicationDate']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
        <p><?php
            if ($row['LMApproval']=='') {$approval="incomplete";$color="orange";}
            if ($row['LMApproval']=='pending') {$approval="pending";$color="#ffcc00";}
            if ($row['LMApproval']=='approved') {$approval="approved";$color="green";}
            if ($row['LMApproval']=='disapproved') {$approval="disapproved";$color="red";}
            ?>
            <div style='background:<?php echo $color; ?>; color: #ffffff; padding: 5px; float: left;' align=center><?php
            echo $approval;
            ?></div</p>
        <?php } ?>
    </div>
</body>
</html>