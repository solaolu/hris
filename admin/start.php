<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../jquery.sparkline.min.js"></script>
<link href="../datePicker.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../date.js"></script>
    <script type="text/javascript" src="../jquery.datePicker.js"></script>

</head>
<?php include('../Connections/cn.php');
mysqli_selectdb($database_cn);
?>
<body>
<div class="container">
<?php
$pagemode=$_GET['p'];

switch ($pagemode){
    case 1:?>
    <h2>EMPLOYEE MANAGEMENT</h2>
   <!-- <form>
    <div>
        <input type=text class="inputbox" size=40 /><a class=button href=""><img src="../images/search.png" border=0 hspace=5 /></a>        
    </div>
    <table><tr><tD></tD></tr></table>
    </form>-->
    <a class="bigbutton" href="createuser.php">create new user</a>
    <a class="bigbutton" href="userMgt.php">employee list</a>
    <a class="bigbutton" href="createjobs.php">job positions</a>
    <a class="bigbutton" href="sendletter.php">send letter</a>
    <a class="bigbutton" href="salaries.php">manage salaries</a>
    <?php
        break;
    case 2:
    ?>
    <h2>APPRAISAL MANAGEMENT</h2>
    <a class="bigbutton" href="createappraisals.php">appraisal periods</a>
    <a class="bigbutton" href="listScorecards.php">scorecard management</a>
    <a class="bigbutton" href="list360Appraisals.php">360&deg; appraisal management</a>
    <a class="bigbutton" href="listGPE.php">general appraisal questions</a>
    <hr size=1>
    <?php
    $rs=mysqli_query($cn, "select * from time_tbl order by ID desc limit 1");
    if (mysqli_num_rows($rs)) {
        $latest_appraisal=mysqli_result($rs, 0, 'period');
    }
    mysqli_free_result($rs);
    
    //$latest_appraisal='MID-YEAR APPRAISAL 2013';
    $rs=mysqli_query($cn, "select COUNT(*) as totalcount, completed from kpi_summary_tbl where period='$latest_appraisal' group by completed");
    
    if (mysqli_num_rows($rs)) {
        $totalfilled=0;
        while ($row=mysqli_fetch_assoc($rs)) {
            if ($row['completed']==0) $incomplete=$row['totalcount']; else $complete=$row['totalcount'];
            $totalfilled+=$row['totalcount'];
        }
    }
    
    $rst=mysqli_query($cn, "select * from staff_tbl");
    $staffcount=mysqli_num_rows($rst);
    
    $rate=($totalfilled/$staffcount)*100;
    $rate=number_format($rate, 2);
    ?>
    <table cellpadding=5 cellspacing=0 width=80% align=CENTER>
        <tr><td align="left" valign=top>
        <h3>Staff Completion Statistics</h3>
    <?php
    echo "<p><strong>LATEST APPRAISAL:</strong> $latest_appraisal</p>";
    echo "<p><strong>STAFF COMPLETION RATE:</strong> $rate%</p>";
    echo "<p><strong>TOTAL FILLED:</strong> $totalfilled<br>";
    echo "<strong>TOTAL COMPLETED:</strong> $complete</p>";
    ?>
    </td>
    <td valign=TOP align=left>      
    <?php
    mysqli_free_result($rs);
    mysqli_free_result($rst);
    
    //get stats for approved, pending and disapproved
    $rs=mysqli_query($cn, "select count(*) as total, approval from kpi_summary_tbl where period='$latest_appraisal' and completed=1 group by approval");
    if (mysqli_num_rows($rs)) {
        $approved=0; $disapproved=0; $pending=0;
        while ($row=mysqli_fetch_assoc($rs)) {
            if ($row['approval']=='approved') $approved=$row['total']; elseif ($row['approval']=='disapproved') $disapproved=$row['total']; else $pending=$row['total'];
        }
    }
    
    ?>
    <h3>Approval Chart</h3>
    <div id="sparkline" style="float:left;"></div>
    <div style="float: left; margin-left: 20px; margin-top: 15px;">
    <div>
        <div style="float: left; width: 10px; height: 10px; background: blue; margin-top: 2px; margin-right: 5px;"></div><div style="float: left; margin-right: 15px;">Approved</div>
    </div>
    <br>
    <div>
        <div style="float: left; width: 10px; height: 10px; background: red; margin-top: 2px; margin-right: 5px;"></div><div style="float: left; margin-right: 15px;">Disapproved</div>
    </div>
    <br>
    <div>
        <div style="float: left; width: 10px; height: 10px; background: orange; margin-top: 2px; margin-right: 5px;"></div><div style="float: left; margin-right: 15px;">Pending</div>
    </div>
    </div>
    </td>  </tr>
    </table>
    <script>
        $('#sparkline').sparkline([<?php echo "$approved,$disapproved,$pending"; ?>],{
            type: 'pie',
            width: '150',
            height: '150',
            tooltipFormat: '{{offset:offset}} ({{percent.1}}%)',
            tooltipValueLookups: {'offset': {
            0:'Approved',1:'Disapproved',2: 'Pending'
            }
            }
            });
    </script>
    <?php
        break;
    case 3:
    $thedate = date('Y-m-d');    
    $previousday = date('j/n/Y', strtotime("$thedate -1 Weekday"));
    ?>
    <h2>TASK MANAGEMENT</h2>
    <A class="bigbutton" href="settasks.php">set weekly task(s)</A>
    <a class="bigbutton" href="listtimesheets.php">view today's timesheets</a>
    <a class="bigbutton" href="listtimesheets.php?thedate=<?php echo $previousday; ?>">previous day's timesheets</a>
    <hr size=1 />
    <p>&nbsp;</p>
    <form action=listtimesheets.php method="get" >
    <table cellspacing=0 cellpadding=0 align=center>
        <tr>
            <td><input type=text id="datebox" name="thedate" class="inputbox" size=35 value="timesheet date" /></td>
            <td><input type=submit class=button value="get timesheets" /></td>
        </tr>
    </table>
    </form>
        <script>
            $(function()
            {
		Date.format='d/m/yyyy';
                $('#datebox').datePicker({clickInput:true, createButton:false,  startDate:'01/01/1910'});
            });
    </script>
    <?php
        break;
    case 4:?>
    <h2>LEAVE MANAGEMENT</h2>
    <a class="bigbutton" href="leaveschedule.php?m=individual">annual leave schedule (individual)</a>
    <a class="bigbutton" href="leaveschedule.php?m=department">annual leave schedule (department)</a>
    <a class="bigbutton" href="listleaverequests.php">leave requests</a>
    <a class="bigbutton" href="reset.php">reset annual schedule</a>
    <?php
        break;
    case 5:?>
    <h2>TRAINING MANAGEMENT</h2>
    <a class="bigbutton" href="attendance.php">internal training attendance</a>
    <a class=bigbutton href="listtrainingrequests.php">training requests</a>
    <?php
        break;
    case 6:?>
    <h2>INVENTORY MANAGEMENT</h2>
    <a class="bigbutton" href="inventoryrequests.php">inventory requests</a>
    <a class=bigbutton href="listinventoryitems.php">inventory items</a>
    <?php
        break;
    case 7:?>
    <h2>PROCUREMENT MANAGEMENT</h2>
    <a class=bigbutton href="addSupplier.php">add new supplier</a> 
    <a class="bigbutton" href="supplierscorecards.php">supplier scorecards</a>
    <a class=bigbutton href="supplierslist.php">suppliers list</a>
    <a class=bigbutton href="supplierbrief.php">supplier briefs</a>
    <a class=bigbutton href="jobcompletion.php">job completion reports</a>
    <a class=bigbutton href="supplierappraisallist.php">project evaluation report</a>
    <?php
        break;
}
?>
</div>
</body>
</html>
