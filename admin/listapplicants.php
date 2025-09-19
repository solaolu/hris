<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');
$db->connectPublic();
$cn2=$db->connect();
include('paginate.php');

    $limit = 20;	
    $page = isset($_GET['page']) ? mysqli_escape_string($cn, $_GET['page']):null;
    if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
    }
$vcode = $_GET['code'];
$rs=mysqli_query($cn2, "select * from biodata_tbl where vacancyCode='$vcode' order by applicantID asc") or die(mysqli_error($cn2));

$stages=3;
$targetpage="listapplicants.php?code=$vcode";
$total_pages=mysqli_num_rows(mysqli_query($cn2, "select applicantID from biodata_tbl where vacancyCode='$vcode'"));

$paginate=paginate($total_pages, $stages, $page, $limit, $targetpage);
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
    <div style="padding: 30px;" >
    <h3>LISTED VACANCIES</h3>
    <p><a href="addVacancy.php">ADD NEW JOB VACANCY</a></p>
    <p>&nbsp;</p>
    <p><strong><?php
$msg=isset($_GET['msg']) ? $_GET['msg']:null;
echo $msg; ?></strong></p>
    <table id="applicantsTable">
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No applicants found.</td></tr>"; else {?>
        <thead>
                <th>APPLICANT NAME</th>
                <th>DATE SUBMITTED</th>
                <th></th>
        </thead>
        <tbody>
        <?php }
        while ($row=mysqli_fetch_assoc($rs)) {
            ?>
            <tr>
                <td><?php echo $row['fullname']; ?></td>
                <td align=right><?php echo $row['applicationDate'];?></td>
                <td ><a href="viewVacancyApplication.php?id=<?php echo $row['applicantID']; ?>">View Application</a></td>
            </tr>
            <?php
            }
        ?>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <?php //echo "<div>".$paginate."</div>"; ?>
    </div>
</body>
       <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Data Table -->
        <script src="../vendors/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="../vendors/bower_components/jszip/dist/jszip.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script>
            $('#applicantsTable').dataTable({});
        </script>
        <script src="../js/delete-script.js"></script>
</html>