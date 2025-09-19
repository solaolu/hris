<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');
include('../MPDF/mpdf.php');

$user=$_GET['user'];

$rs=mysqli_query($cn, "select a.fullname, a.department, b.* from staff_tbl as a left join employeeProfile_tbl as b on a.email=b.email where a.email='$user'");
$row=mysqli_fetch_assoc($rs);
$brokennames=explode(" ", $row['fullname']);
$firstname = ($row['firstname']=="")?$brokennames[0]:$row['firstname'];
ob_start();
?>
<p align=right><img src="../images/logo.gif" ></p>
<p><?php echo $row['fullname']; ?>,<br />
  <?php echo $row['department']; ?> Department,<br />
  <?php echo $row['homeAddress']; ?>,<br />
  <?php echo $row['homeCity'].", ".$row['homeState']; ?> </p>
<p>&nbsp;</p>
<p>Dear <?php echo $firstname; ?>,</p>
<p>I&rsquo;d like to take this opportunity to say thank you for the <?php echo $_GET['years']; ?> years of service to our organization. <?php echo $_GET['years']; ?> years may seem like a short time, but in your case it represents some significant contributions to Connect Marketing Limited. We appreciate your dedication, and wish you special happiness as you celebrate another year.</p>
<p>Thank you for sharing your unique gifts and talents and contributing to our success. We&rsquo;re looking forward to working with you in the years to come.</p>
<p>Sincerely,</p>
<p>&nbsp;</p>
<p>HR/Admin. </p>
<?php
$message = ob_get_contents();
ob_end_clean();

$mpdf=new mPDF();

$file="../letters/".time().".pdf";

$mpdf->WriteHTML($message);
$mpdf->Output("$file");
exit;
?>