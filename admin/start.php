<?php
declare(strict_types=1);
session_start();

require_once('../Connections/cn.php');

function getPageMode(): int {
    return isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
}

function escape($str): string {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

$pagemode = getPageMode();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>HRIS Admin | Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <script src="../jquery.min.js"></script>
    <script src="../jquery.sparkline.min.js"></script>
    <link rel="stylesheet" href="../datePicker.css" />
    <script src="../date.js"></script>
    <script src="../jquery.datePicker.js"></script>
</head>
<body>
<div class="container">
<?php

switch ($pagemode) {
    case 1:
        // EMPLOYEE MANAGEMENT
        ?>
        <h2>EMPLOYEE MANAGEMENT</h2>
        <a class="bigbutton" href="createuser.php">Create New User</a>
        <a class="bigbutton" href="userMgt.php">Employee List</a>
        <a class="bigbutton" href="createjobs.php">Job Positions</a>
        <a class="bigbutton" href="sendletter.php">Send Letter</a>
        <a class="bigbutton" href="salaries.php">Manage Salaries</a>
        <?php
        break;

    case 2:
        // APPRAISAL MANAGEMENT
        ?>
        <h2>APPRAISAL MANAGEMENT</h2>
        <a class="bigbutton" href="createappraisals.php">Appraisal Periods</a>
        <a class="bigbutton" href="listScorecards.php">Scorecard Management</a>
        <a class="bigbutton" href="list360Appraisals.php">360° Appraisal Management</a>
        <a class="bigbutton" href="listGPE.php">General Appraisal Questions</a>
        <hr />

        <?php
        // Get latest appraisal period
        $latest_appraisal = '';
        $totalfilled = $complete = $incomplete = 0;
        $approved = $disapproved = $pending = 0;
        $rate = 0.0;
        $staffcount = 0;

        if ($stmt = $cn->prepare("SELECT period FROM time_tbl ORDER BY ID DESC LIMIT 1")) {
            $stmt->execute();
            $stmt->bind_result($latest_appraisal);
            $stmt->fetch();
            $stmt->close();
        }

        if ($latest_appraisal) {
            // Completion statistics
            if ($stmt = $cn->prepare("SELECT COUNT(*) AS totalcount, completed FROM kpi_summary_tbl WHERE period = ? GROUP BY completed")) {
                $stmt->bind_param("s", $latest_appraisal);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    if ((int)$row['completed'] === 0) $incomplete = (int)$row['totalcount'];
                    else $complete = (int)$row['totalcount'];
                    $totalfilled += (int)$row['totalcount'];
                }
                $stmt->close();
            }

            // Staff count
            if ($stmt = $cn->prepare("SELECT COUNT(*) FROM staff_tbl")) {
                $stmt->execute();
                $stmt->bind_result($staffcount);
                $stmt->fetch();
                $stmt->close();
            }

            if ($staffcount > 0) {
                $rate = number_format(($totalfilled / $staffcount) * 100, 2);
            }

            // Approval stats
            if ($stmt = $cn->prepare("SELECT COUNT(*) AS total, approval FROM kpi_summary_tbl WHERE period = ? AND completed = 1 GROUP BY approval")) {
                $stmt->bind_param("s", $latest_appraisal);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    if ($row['approval'] === 'approved') $approved = (int)$row['total'];
                    elseif ($row['approval'] === 'disapproved') $disapproved = (int)$row['total'];
                    else $pending = (int)$row['total'];
                }
                $stmt->close();
            }
        }
        ?>
        <table cellpadding="5" cellspacing="0" width="80%" align="center">
            <tr>
                <td align="left" valign="top">
                    <h3>Staff Completion Statistics</h3>
                    <p><strong>LATEST APPRAISAL:</strong> <?= escape($latest_appraisal) ?></p>
                    <p><strong>STAFF COMPLETION RATE:</strong> <?= escape($rate) ?>%</p>
                    <p><strong>TOTAL FILLED:</strong> <?= escape($totalfilled) ?><br>
                        <strong>TOTAL COMPLETED:</strong> <?= escape($complete) ?></p>
                </td>
                <td valign="top" align="left">
                    <h3>Approval Chart</h3>
                    <div id="sparkline" style="float:left;"></div>
                    <div style="float: left; margin-left: 20px; margin-top: 15px;">
                        <div>
                            <div style="float: left; width: 10px; height: 10px; background: blue; margin-top: 2px; margin-right: 5px;"></div>
                            <div style="float: left; margin-right: 15px;">Approved</div>
                        </div>
                        <br>
                        <div>
                            <div style="float: left; width: 10px; height: 10px; background: red; margin-top: 2px; margin-right: 5px;"></div>
                            <div style="float: left; margin-right: 15px;">Disapproved</div>
                        </div>
                        <br>
                        <div>
                            <div style="float: left; width: 10px; height: 10px; background: orange; margin-top: 2px; margin-right: 5px;"></div>
                            <div style="float: left; margin-right: 15px;">Pending</div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <script>
            $('#sparkline').sparkline([<?= "$approved,$disapproved,$pending" ?>],{
                type: 'pie',
                width: '150',
                height: '150',
                tooltipFormat: '{{offset:offset}} ({{percent.1}}%)',
                tooltipValueLookups: {'offset': {
                    0:'Approved',1:'Disapproved',2: 'Pending'
                }}
            });
        </script>
        <?php
        break;

    case 3:
        // TASK MANAGEMENT
        $thedate = date('Y-m-d');
        $previousday = date('j/n/Y', strtotime("$thedate -1 Weekday"));
        ?>
        <h2>TASK MANAGEMENT</h2>
        <a class="bigbutton" href="settasks.php">Set Weekly Task(s)</a>
        <a class="bigbutton" href="listtimesheets.php">View Today's Timesheets</a>
        <a class="bigbutton" href="listtimesheets.php?thedate=<?= escape($previousday) ?>">Previous Day's Timesheets</a>
        <hr />
        <form action="listtimesheets.php" method="get">
            <table cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td>
                        <input type="text" id="datebox" name="thedate" class="inputbox" size="35" placeholder="Timesheet date" />
                    </td>
                    <td>
                        <input type="submit" class="button" value="Get Timesheets" />
                    </td>
                </tr>
            </table>
        </form>
        <script>
        $(function() {
            Date.format='d/m/yyyy';
            $('#datebox').datePicker({clickInput:true, createButton:false,  startDate:'01/01/1910'});
        });
        </script>
        <?php
        break;

    case 4:
        // LEAVE MANAGEMENT
        ?>
        <h2>LEAVE MANAGEMENT</h2>
        <a class="bigbutton" href="leaveschedule.php?m=individual">Annual Leave Schedule (Individual)</a>
        <a class="bigbutton" href="leaveschedule.php?m=department">Annual Leave Schedule (Department)</a>
        <a class="bigbutton" href="listleaverequests.php">Leave Requests</a>
        <a class="bigbutton" href="reset.php">Reset Annual Schedule</a>
        <?php
        break;

    case 5:
        // TRAINING MANAGEMENT
        ?>
        <h2>TRAINING MANAGEMENT</h2>
        <a class="bigbutton" href="attendance.php">Internal Training Attendance</a>
        <a class="bigbutton" href="listtrainingrequests.php">Training Requests</a>
        <?php
        break;

    case 6:
        // INVENTORY MANAGEMENT
        ?>
        <h2>INVENTORY MANAGEMENT</h2>
        <a class="bigbutton" href="inventoryrequests.php">Inventory Requests</a>
        <a class="bigbutton" href="listinventoryitems.php">Inventory Items</a>
        <?php
        break;

    case 7:
        // PROCUREMENT MANAGEMENT
        ?>
        <h2>PROCUREMENT MANAGEMENT</h2>
        <a class="bigbutton" href="addSupplier.php">Add New Supplier</a>
        <a class="bigbutton" href="supplierscorecards.php">Supplier Scorecards</a>
        <a class="bigbutton" href="supplierslist.php">Suppliers List</a>
        <a class="bigbutton" href="supplierbrief.php">Supplier Briefs</a>
        <a class="bigbutton" href="jobcompletion.php">Job Completion Reports</a>
        <a class="bigbutton" href="supplierappraisallist.php">Project Evaluation Report</a>
        <?php
        break;

    default:
        echo "<p>Invalid section.</p>";
        break;
}
?>
</div>
</body>
</html>
