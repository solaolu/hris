<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

$dept=urldecode($_GET['dept']);

$rs=mysqli_query($cn, "select a.*, b.fullname from leaveDays_tbl as a left join staff_tbl as b on a.email=b.email where b.department='$dept'") or die(mysqli_error($cn));

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
    <h3><?php echo $dept; ?>'s Leave Schedule</h3>
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No existing schedule found.</td></tr>";
        $months=array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");
            echo "<table border=1 bordercolor=#000000 cellspacing=0 cellpadding=4 width=100%><tr><tD></td>";
            for ($j=1;$j<=count($months);$j++) {
                echo "<td>".strtoupper($months[$j-1])."</td>";
            }
            echo "<td></td><tr>";
            
            while ($row=mysqli_fetch_assoc($rs)) {
            $theselecteddays=$row['leaveDays'];
            $thedays=explode(",", $theselecteddays);
            //sort($thedays);
                echo "<tr><td>".$row['fullname']."</td>";
                for ($j=1; $j<=12; $j++) {
                    echo "<td>";
                    for ($i=0;$i<count($thedays); $i++) {
                        $daynow=trim($thedays[$i], "'");
                        if (strpos($daynow, "/$j/")===false) {} else {
                            $theday=explode("/", $daynow);
                            echo "<div style='float:left; padding: 3px; background: #990000; margin-right: 3px; color: #ffffff; font-size: smaller;'>".$theday[0]."</div>";
                            } 
                    }
                    echo "</td>";
                }
            if ($row['approval']=='') {$approval="incomplete";$color="orange";}
            if ($row['approval']=='pending') {$approval="pending";$color="#ffcc00";}
            if ($row['approval']=='approved') {$approval="approved";$color="green";}
            if ($row['approval']=='disapproved') {$approval="disapproved";$color="red";}
            ?>
            <td style='background:<?php echo $color; ?>; color: #ffffff; padding: 5px;' align=center><?php
            echo $approval;
            ?></td></tr>
            <?php
            }
            
            echo "</table>";
            ?>
    </div>
</body>
</html>