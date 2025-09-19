<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

$user=$_GET['user'];

$rs=mysqli_query($cn, "select a.*, b.fullname from leaveDays_tbl as a left join staff_tbl as b on a.email=b.email where a.email='$user'") or die(mysqli_error($cn));
$row=mysqli_fetch_assoc($rs);
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
    <h3><?php echo $row['fullname']; ?>'s Leave Schedule</h3>
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No existing schedule found.</td></tr>";
            $theselecteddays=mysqli_result($rs, 0, 'leaveDays');
            echo "<h3>Selected leave days</h3>";
            $thedays=explode(",", $theselecteddays);
            //sort($thedays);
            $months=array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");
            echo "<table>";
            for ($j=1;$j<=count($months);$j++) {
                echo "<tr><td>".strtoupper($months[$j-1]).":</td><td>";
                for ($i=0;$i<count($thedays); $i++) {
                    $daynow=trim($thedays[$i], "'");
                    if (strpos($daynow, "/$j/")===false) {} else {
                        $theday=explode("/", $daynow);
                        echo "<div style='float:left; padding: 3px; background: #990000; margin-right: 3px; color: #ffffff;'>".$theday[0]."</div>";
                        } 
                }
                echo "</td></tr>";
            }
            ?>
        <?php
            if ($row['approval']=='') {$approval="incomplete";$color="orange";}
            if ($row['approval']=='pending') {$approval="pending";$color="#ffcc00";}
            if ($row['approval']=='approved') {$approval="approved";$color="green";}
            if ($row['approval']=='disapproved') {$approval="disapproved";$color="red";}
            ?>
            <tr>
            <td style='background:<?php echo $color; ?>; color: #ffffff; padding: 5px;' align=center><?php
            echo $approval;
            ?></td></tr>
            <?php
            echo "</table>";
            ?>
    </div>
</body>
</html>