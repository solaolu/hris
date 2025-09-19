<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); 
//mysqli_select_db($database_cn);
$admin_companyID=$_SESSION["user__info"]['companyID'];
$admin_company=$_SESSION["user__info"]['companyName'];
$query = "select a.*, b.name as companyname from staff_tbl as a left join company_tbl as b on a.companyID=b.ID where companyID=$admin_companyID and a.isDeleted=0";

if ($admin_companyID==1) $query = "select a.*, b.name as companyname from staff_tbl as a left join company_tbl as b on a.companyID=b.ID where a.isDeleted=0";


$rs = mysqli_query($cn, $query) or die(mysqli_error($cn));
$row_rs = mysqli_fetch_assoc($rs);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script>
function notify(email, fullname) {
var ans = confirm("Are you sure you want to delete staff profile for "+fullname+" and all associated information");
if (ans) {
	window.location = "deleteUser.php?un="+email;
	}
}
</script>
</head>

<body>
<p>&nbsp;</p>
<A href="createuser.php">ADD NEW USER</A> 
<p>&nbsp;</p>
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td valign="top" bgcolor="#ebebeb"><table border="0" id="userTable" cellspacing="0" cellpadding="5">
  <?php
  if (!mysqli_num_rows($rs)) {
      echo "<tr><td>No staff found for <strong>$admin_company</strong>!</td></tr>";
  } else {
  ?>
  <thead>
   <tr>
    <th>STAFF NAME</th>
    <th>USERNAME</th>
    <th>COMPANY NAME</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>
  <tbody>
  <?php
do {
?>  <tr>
    <td><?php echo $row_rs['fullname']; ?></td>
    <td><?php echo $row_rs['email']; ?></td>
    <td><?php echo $row_rs['companyname']; ?></td>
    <!---<td><a href="showAppraisals.php?un=<?php echo $row_rs['email'];?>">View Appraisal Details</a></td>-->
    <td><a href="profile.php?un=<?php echo $row_rs['email'];?>">Show Profile</a></td>
    <td><a href="editUser.php?un=<?php echo $row_rs['email'];?>">Edit Details</a></td>
    <td><a href="documents.php?un=<?php echo $row_rs['email'];?>">Documents</a></td>
    <?php if ($admin_companyID==8) { ?>
    <td><a href="salesForceAttendance.php?un=<?php echo $row_rs['email']; ?>">Work Attendance</a></td>
    <?php } ?>    
    <td><a href="#" onclick="notify('<?php echo $row_rs['email']."', '".$row_rs['fullname'];?>');">Delete User</a></td>
    </tr>
<?php	
  } while ($row_rs=mysqli_fetch_assoc($rs));
}
?>
</tbody>
  <!--<tr><td colspan="3"></td></tr>-->
</table>
</td>
  </tr>
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
            $('#userTable').dataTable({});
        </script>
</html>