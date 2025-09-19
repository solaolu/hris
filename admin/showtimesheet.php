<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

$userinview=$_GET['user'];

$rs=mysqli_query($cn, "select a.*, b.jobtitle from staff_tbl as a left join jobs_tbl as b on (a.jobcode=b.jobcode) where a.email='$userinview' ");
$fullname=mysqli_result($rs, 0, 'fullname');
$department=mysqli_result($rs, 0, 'department');
$jobtitle=mysqli_result($rs, 0, 'jobtitle');

$user=$_SESSION['username'];

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
<table cellpadding=5 cellspacing=0>
    <tr><td align="right">Staff Name: </td><td><?php echo $fullname; ?></td></tr>
    <tr><td align="right">Job Position:</td><td><?php echo $jobtitle; ?></td></tr>
</table>
<?php
$today=$_GET['taskfor'];
    $rs=mysqli_query($cn, "select * from timesheet_tbl where email='$userinview' and taskDate='$today' AND taskType='to-do' order by ID asc");
    echo "<h3>ACTIVITY SCHEDULE FOR $today</h3>";
    echo "<table border=1 bordercolor=#000000 cellpadding=4 cellspacing=0 width=100% >";
    echo "<tr style='background: #e0e0e0;'><th>S/N</th><th>TO DO LIST/ACTION PLAN</th><th>REMARKS (if any)</th><th>START TIME</th><th>END TIME</th></tr>";
    $sn=1;
    while ($row=mysqli_fetch_assoc($rs)){
        echo "<tr><td align=right><strong>$sn.</strong></td><td>".$row['title']."</td><td>".$row['remark']."</td><td>".$row['startTime']."</td><td>".$row['endTime']."</td></tr>";
        $sn++;
        $approvalstatus=$row['approval'];
    }
    mysqli_free_result($rs);
    echo "<tr><td colspan=5></td></tr>";
    $rs=mysqli_query($cn, "select * from timesheet_tbl where email='$userinview' and taskDate='$today' AND taskType='meeting' order by ID asc");
    echo "<tr style='background: #e0e0e0;'><th>&nbsp;</th><th>MEETING ATTENDED</th><th>REMARKS (Objectives/Contact Report Status)</th><th>START TIME</th><th>END TIME</th></tr>";
    while ($row=mysqli_fetch_assoc($rs)){
        echo "<tr><td align=right><strong>$sn.</strong></td><td>".$row['title']."</td><td>".$row['remark']."</td><td>".$row['startTime']."</td><td>".$row['endTime']."</td></tr>";
        $sn++;
    }
    echo "</table>";
    
    //load line manager assignments
    $rst=mysqli_query($cn, "select * from assignment_tbl where assignedTo='$userinview' and `date`='$today'");
    echo "<p>&nbsp;</p><h3>Tasks assigned by Manager</h3>";
    if (mysqli_num_rows($rst)) {
        echo "<table border=1 cellpadding=4 width=100% cellspacing=0 bordercolor=#000000>";
        echo "<tr><td></td><th>TASKS</th><th>LINE MANAGER <BR>REMARK(s)</th><th>STATUS</th><th>USER REMARK(S)</th></tr>";
        $counter=1;
            while ($row_rst=mysqli_fetch_assoc($rst)){
                echo "<tR><tD align=right>$counter.</tD><td>".$row_rst['task']."</td><tD>".$row_rst['remark']."</tD><tD>".$row_rst['status']."</tD><td>".$row_rst['userRemark']."</td></tr>";
            $counter++;
            }
        echo "</table>";    
    }
    else {
        echo "No additional task assigned by line manager";
    }
    //$datetoday=date('j/n/Y');
    ?>
    <hr size=1 />
    <h3>Line Manager Assigned Task(s) for next day (<?php
    $thedate=DateTime::createFromFormat('d/m/Y', $today)->format('Y-m-d');
    //echo $thedate;
    $nextday = date('j/n/Y', strtotime("$thedate +1 Weekday"));
    echo $nextday;
    ?>):</h3>
    <div id="nextdaytasks">
        <?php
       // echo "select * from assignment_tbl where assignedTo='$userinview' and `date`='$nextday' and assignee='$user'";
            $rs=mysqli_query($cn, "select * from assignment_tbl where assignedTo='$userinview' and `date`='$nextday'");
    echo "<p>&nbsp;</p>";
    echo "<table width=80% cellpadding=4 cellspacing=0 border=1 bordercolor=#000000 >";
    echo "<tr><th>Task</th><th>Remark</th></tr>";
    while ($row=mysqli_fetch_assoc($rs)){
        echo "<tr><td>".$row['task']."</td><td>".$row['remark']."</td></tr>";
    }
    echo "</table>";
        ?>
    </div>
    <?php
            if ($approvalstatus=='') {$approvalstatus="incomplete";$color="orange";}
            if ($approvalstatus=='pending') {$approvalstatus="pending";$color="#ffcc00";}
            if ($approvalstatus=='approved') {$approvalstatus="approved";$color="green";}
            if ($approvalstatus=='disapproved') {$approvalstatus="disapproved";$color="red";}

    echo "<p><span style='background: $color; padding: 8px; color: #fff;'>".strtoupper($approvalstatus)."</span></p>";
?></div>
    </body>
</html>