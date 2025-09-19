<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

if (!isset($_GET['thedate'])) $thedate=date('j/n/Y'); else $thedate=$_GET['thedate'];

$rs=mysqli_query($cn, "select distinct a.email, b.fullname, a.approval from timesheet_tbl as a left join staff_tbl as b on a.email=b.email where a.taskDate='$thedate'") or die(mysqli_error($cn));
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
    <h3>Timesheets for <?php echo $thedate; ?></h3>
    <table cellpadding=5>
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No existing timesheet found.</td></tr>";
    while ($row=mysqli_fetch_assoc($rs)) {
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
            <td><a href="showtimesheet.php?user=<?php echo $row['email']; ?>&taskfor=<?php echo $thedate; ?>">SHOW</a></td>
        </tr>
        <?php
        }?>
    </table>
    </div>
</body>
</html>