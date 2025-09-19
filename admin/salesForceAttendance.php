<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); 
//$db->connectPublic();
//$cn = $db->connect();
$user = $_GET['un'];
$sql="SELECT DISTINCT DATE_FORMAT(loginTimestamp,'%Y-%m-%d') AS date FROM `loginLog_tbl` WHERE username='$user' order by ID desc";
//echo $sql;
$days = $db->getData($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <h4>WORK ATTENDANCE</h4>
   <?php
    $sql = "select a.fullname, a.jobcode, b.deviceID, b.longitude,  b.latitude from staff_tbl as a
    left join 
    device_tbl as b on a.email=b.username
    where a.email='$user'
    ";
    
    $profile = $db->getData($sql);
    
    
    ?>
    <table cellpadding=5>
        <tr>
            <td><strong><?php echo strtoupper($profile[0]['fullname']); ?></strong></td>
            <tD><?php echo strtoupper($profile[0]['jobcode']); ?></tD>
        </tr>
        <tr>
            <td>Device ID: <?php echo $profile[0]['deviceID']; ?></td>
            <td>Registered Location: <?php echo $profile[0]['longitude'].",".$profile[0]['latitude'];?></td>
        </tr>
    </table>
    <table id="attendanceTable">
        <thead>
            <th>Day</th>
            <th>Clock In Time</th>
            <th>Clock Out Time</th>
        </thead>
        <tbody>
            <?php foreach($days as $day) { 
                $sql = "select TIME_FORMAT(loginTimestamp, '%h:%i %p') as time from loginLog_tbl
                where username='$user' and DATE_FORMAT(loginTimestamp,'%Y-%m-%d') = '".$day['date']."' limit 2";
                $clocks = $db->getData($sql);
            ?>
                <tr bgcolor="#fff">
                    <td align=center><?php echo $day['date']; ?></td>
                    <?php foreach($clocks as $clock) {?>
                    <td align=center><?php echo $clock['time']; ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
       <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Data Table -->
        <script src="../vendors/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="../vendors/bower_components/jszip/dist/jszip.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script>
            $('#attendanceTable').dataTable({});
        </script>
</html>