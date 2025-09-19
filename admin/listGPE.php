<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
//mysqli_select_db($database_cn);
$query = "select distinct a.* from gpe_tbl as a left join scorecard_tbl as b on a.scorecard=b.sc where a.isDeleted=0";
$rs=mysqli_query($cn, $query);
$row_rs=mysqli_fetch_assoc($rs);
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
  <h3>General Appraisal Questions</h3>
  <strong><?php echo $_GET['msg']; ?></strong>
<table border="0" cellspacing="0" cellpadding="8">
  <tr>
    <td valign="top">
      <table border="0" id="gpeQuestionTable" cellspacing="1" cellpadding="8" bgcolor="#FFFFFF">
        <thead>
          <tr>
            <th bgcolor="#c0c0c0">Questions</th>
            <th bgcolor="#c0c0c0">Scorecard</th>
            <th>&nbsp;</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php do {?>
          <tr>
            <td bgcolor="#c0c0c0"><?php echo $row_rs['gpeID']; ?></td>
            <td bgcolor="#c0c0c0"><?php echo $row_rs['scorecard']; ?></td>
            <td><a href="editGPE.php?code=<?php echo $row_rs['ID']; ?>">Edit</a></td>
            <td><a href="copyGPE.php?code=<?php echo $row_rs['ID']; ?>">Copy</a></td>
            <td><a class="delete-item" href="delete.php?id=<?php echo $row_rs['ID']; ?>&tag=gpe_tbl&ref=listGPE.php&msg=Question deleted">Delete</a></td>
          </tr>
          <?php } while($row_rs=mysqli_fetch_assoc($rs)); ?>
        </tbody>
        </table>
    <p><a href="addGPE.php">Add New Questions</a></p></td>
  </tr>
</table>
        <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Data Table -->
        <script src="../vendors/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="../vendors/bower_components/jszip/dist/jszip.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script>
            $('#gpeQuestionTable').dataTable({});
        </script>
        <script src="../js/delete-script.js"></script>
</body>
</html>