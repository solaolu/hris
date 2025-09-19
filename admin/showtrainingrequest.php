<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

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
    <h3>LEAVE REQUESTS</h3>
    <?php
    $id=$_GET['id'];
        $extraparams.="&id=$id";
        $rs=mysqli_query($cn, "select a.*, b.fullname, b.department, c.jobtitle from trainingRequests_tbl as a left join staff_tbl as b on a.owner=b.email left join jobs_tbl as c on b.jobcode=c.jobcode where a.ID=$id") or die(mysqli_error($cn));
        if (!mysqli_num_rows($rs)) {
            echo "<p>Invalid Record</p>";
            } else {
        $row=mysqli_fetch_assoc($rs);
        ?>
        <h4><?php echo $row['fullname']; ?><bR><?php echo $row['jobtitle']." | ".$row['department']; ?></h4>
        <table width="70%" cellspacing="0" cellpadding="5" border="1" bordercolor="#000000">
  <tr>
    <td><strong>Proposed Training</strong></td>
    <td><?php echo $row['proposedTraining']; ?></td>
    <td><strong>Type of Training</strong></td>
    <td><?php echo $row['trainingType']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Training Content</strong></td>
    <td><?php echo $row['trainingContent']; ?></td>
    <td><strong>Training Date</strong></td>
    <td><?php echo $row['trainingDate']; ?></td>
    <td><strong>Training Location</strong></td>
    <td><?php echo $row['trainingLocation']; ?></td>
  </tr>
  <tr>
    <td><strong>Number of Training Hours (total)</strong></td>
    <td><?php echo $row['trainingHours']; ?></td>
    <td><strong>Number of Sessions</strong></td>
    <td><?php echo $row['sessionCount']; ?></td>
    <td><strong>Length of Sessions</strong></td>
    <td><?php echo $row['sessionLength']; ?></td>
  </tr>
  <tr>
    <td><strong>Registration Fee</strong></td>
    <td><?php echo $row['registrationFee']; ?></td>
    <td><strong>Total Cost</strong></td>
    <td><?php echo $row['totalCost']; ?></td>
    <td><strong>Other Costs</strong></td>
    <td><?php echo $row['otherCosts']; ?></td>
  </tr>
  <tr>
    <td><strong>Fund Source</strong></td>
    <td><?php echo $row['proposedFundSource']; ?></td>
    <td><strong>Is release time needed?</strong></td>
    <td><?php echo (($row['requiresReleaseTime']==0)?"NO":"YES"); ?></td>
    <td><strong>Is there need for replacement staffing?</strong></td>
    <td><?php echo (($row['requiresReplacement']==0)?"NO":"YES"); ?></td>
  </tr>
  <tr>
    <td><strong>Training Description</strong></td>
    <td colspan="5"><?php echo $row['trainingDescription']; ?></td>
  </tr>
  <tr>
    <td><strong>Training Rationale</strong></td>
    <td colspan="5"><?php echo $row['trainingRationale']; ?></td>
  </tr>
  <tr>
    <td><strong>Desired Competency</strong></td>
    <td colspan="5"><?php echo $row['desiredCompetency']; ?></td>
  </tr>
  <tr>
    <td><strong>Personal Outcome</strong></td>
    <td colspan="5"><?php echo $row['personalOutcome']; ?></td>
  </tr>
  <tr>
    <td><strong>Unit Outcome</strong></td>
    <td colspan="5"><?php echo $row['unitOutcome']; ?></td>
  </tr>
  <tr>
    <td><strong>CMS Outcome</strong></td>
    <td colspan="5"><?php echo $row['cmsOutcome']; ?></td>
  </tr>
  <tr>
    <td><strong>How will this information be shared <br />
    with other unit members?</strong></td>
    <td colspan="5"><?php echo $row['sharedHow']; ?></td>
  </tr>
  <tr>
    <td><strong>Part Of Certification</strong></td>
    <td><?php echo (($row['partOfCertification']==0)?"NO":"YES"); ?></td>
    <td><br />
      <strong>If this is part of a certification, please list the <br />
courses completed and remaining</strong></td>
    <td colspan="3"><?php echo $row['certificationCourses']; ?></td>
  </tr>
</table>
        <p><?php
            if ($row['unitHeadApproval']=='' || $row['unitHeadApproval']=='pending') {$approval="pending";$color="#ffcc00";}
            if ($row['unitHeadApproval']=='approved') {$approval="approved";$color="green";}
            if ($row['unitHeadApproval']=='disapproved') {$approval="disapproved";$color="red";}
            ?>
            <div style='background:<?php echo $color; ?>; color: #ffffff; padding: 5px; float: left;' align=center><?php
            echo $approval;
            ?></div</p>
        <?php } ?>
    </div>
</body>
</html>