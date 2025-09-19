<?php
require_once('checkAdmin.php');
require_once('../Connections/cn.php');
$db->connectPublic();
$cn=$db->connect();

$id=$_GET['id'];

$sql = "select * from biodata_tbl where applicantID=$id";
$sql2 = "select * from educationalInfo_tbl where applicantID=$id";
$sql3 = "select * from references_tbl where applicantID=$id";
$sql4 = "select * from workExperience_tbl where applicantID=$id";

//var_dump($_POST);

$rows = $db->getData($sql);
//$_SESSION['supplierinfo'] = $rows[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>
<body>
  <?php
    if (count($rows))
    {
    ?>
   <div style="padding: 30px;" >
       <h3>APPLICANT DETAILS</h3>
        <?php 
        $template = array(1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,2,1,2,1,2,3,4,2,1,1,1,2,2);
        $skip = "`applicantID`";
        showView('biodata_tbl', $skip, $template, $rows[0]); ?>
        <h4>Education Information</h4>
        <?php $rows = $db->getData($sql2); 
        if (count($rows)==0) {
            echo "No educational information submitted.";
        } else {
        ?>
        <table cellspacing=1 cellpadding=4 bgcolor="#ccc">
                <thead>
                    <th>Institution Attended</th>
                    <th>Qualification</th>
                    <th>Certification</th>
                </thead>
                <tbody>
            <?php foreach($rows as $row){ ?>
                <tr bgcolor="#fff">
                    <td><?php echo $row['schoolAttended']; ?></td>
                    <td><?php echo $row['qualification']; ?></td>
                    <td><?php echo $row['certification']; ?></td>
                </tr>
            <?php }?>
                </tbody>
        </table>    
        <?php
        }
        ?>
        <h4>References</h4>
        <?php $rows = $db->getData($sql3); 
        if (count($rows)==0) {
            echo "No references.";
        } else {
        ?>
        <table cellspacing=1 cellpadding=4 bgcolor="#ccc">
                <thead>
                    <th>Referee Name</th>
                    <th>Company</th>
                    <th>Residential Address</th>
                    <th>Referee Phone No</th>
                </thead>
                <tbody>
            <?php foreach($rows as $row){ ?>
                <tr bgcolor="#fff">
                    <td><?php echo $row['refereeName']; ?></td>
                    <td><?php echo $row['company']; ?></td>
                    <td><?php echo $row['residentialAddress']; ?></td>
                    <td><?php echo $row['refereephoneNo']; ?></td>
                    <td><?php echo $row['refereeEmail']; ?></td>
                </tr>
            <?php }?>
                </tbody>
        </table>    
        <?php
        }
        ?>
        <h4>Work Experience</h4>
        <?php $rows = $db->getData($sql4); 
        if (count($rows)==0) {
            echo "No experience registered.";
        } else {
        ?>
        <table cellspacing=1 cellpadding=4 bgcolor="#ccc">
                <thead>
                    <th>Organisaiton</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Contact Email</th>
                    <th>Contact Name</th>
                    <th>ContactPhoneNo</th>
                </thead>
                <tbody>
            <?php foreach($rows as $row){ ?>
                <tr bgcolor="#fff">
                    <td><?php echo $row['companyName']; ?></td>
                    <td><?php echo $row['startDate']; ?></td>
                    <td><?php echo $row['endDate']; ?></td>
                    <td><?php echo $row['contactEmail']; ?></td>
                    <td><?php echo $row['contactName']; ?></td>
                    <td><?php echo $row['contactPhoneNo']; ?></td>
                </tr>
            <?php }?>
                </tbody>
        </table>    
        <?php
        }
        ?>
        
        <p>&nbsp;</p>

        <?php
        } else {
            echo "No applicant found!";
        }
        ?>
   </div>
   <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
</body>
</html>