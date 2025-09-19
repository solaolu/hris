<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

if (!isset($_GET['m'])) $listmode="individual"; else $listmode=$_GET['m'];

if ($listmode=="individual") $rs=mysqli_query($cn, "select distinct a.email, a.approval, b.fullname from leaveDays_tbl as a left join staff_tbl as b on a.email=b.email") or die(mysqli_error($cn));
else $rs=mysqli_query($cn, "select distinct b.department from leaveDays_tbl as a left join staff_tbl as b on a.email=b.email") or die(mysqli_error($cn));
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
    <h3>Leave Schedule listed by <?php echo $listmode; ?></h3>
    <table cellpadding=5>
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No existing schedule found.</td></tr>";
    while ($row=mysqli_fetch_assoc($rs)) {
        if ($listmode=="individual") {
        ?>
        <tr>
            <td><?php echo $row['fullname']; ?></td>
            <?php
            if ($row['approval']=='') {$approval="incomplete";$color="orange";}
            if ($row['approval']=='pending') {$approval="pending";$color="#ffcc00";}
            if ($row['approval']=='approved') {$approval="approved";$color="green";}
            if ($row['approval']=='disapproved') {$approval="disapproved";$color="red";}
            ?>
            <td style='background:<?php echo $color; ?>; color: #ffffff;' align=center><?php
            echo $approval;
            ?></td>
            <td><a href="showschedule.php?user=<?php echo $row['email']; ?>">SHOW SCHEDULE</a></td>
        </tr>
        <?php
        } else {
            ?>
        <tr>
            <td><?php echo $row['department']; ?></td>
            <td><a href="showdepartmentschedule.php?dept=<?php echo urlencode($row['department']); ?>">SHOW SCHEDULE</a></td>
        </tr>            
            <?php
        }
        }?>
    </table>
    </div>
</body>
</html>