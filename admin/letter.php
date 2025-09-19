<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');
include('../MPDF/mpdf.php');

function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    if (mail($mailto, $subject, "", $header)) {
        echo "letter sent successfully ... OK"; // or use booleans here
    } else {
        echo "sending failed ... ERROR!";
    }
}

$user=$_GET['user'];

$rs=mysql_query("select a.fullname, a.department, b.* from staff_tbl as a left join employeeProfile_tbl as b on a.email=b.email where a.email='$user'");
$row=mysql_fetch_assoc($rs);
$brokennames=explode(" ", $row['fullname']);

$s=mysql_query("select value from config_tbl where parameter='HR Signature' or parameter='HR Name' order by ID asc");
$signaturename=mysql_result($s,0,'value');
$signaturefile=mysql_result($s,1,'value');

if ($signaturefile!="") $signature="<img src='../images/config/$signaturefile' border=0 /><br><strong>$signaturename</strong>";

$firstname = ($row['firstname']=="")?$brokennames[0]:$row['firstname'];
$letter=$_GET['l'];
ob_start();
?>
<p align=right><img src="../images/logo.gif" ></p>
<p><?php echo date('j/n/Y'); ?></p>
<p><?php echo $row['fullname']; ?>,<br />
  <?php echo $row['department']; ?> Department,<br />
  <?php echo $row['homeAddress']; ?>,<br />
  <?php echo $row['homeCity'].", ".$row['homeState']; ?> </p>
<p>&nbsp;</p>
<p>Dear <?php echo $firstname; ?>,</p>
<?php switch ($letter) {
   case "anniversary": ?>
<p>I&rsquo;d like to take this opportunity to say thank you for the <?php echo $_GET['years']; ?> years of service to our organization. <?php echo $_GET['years']; ?> years may seem like a short time, but in your case it represents some significant contributions to <?php echo $_GET['companyname']; ?>. We appreciate your dedication, and wish you special happiness as you celebrate another year.</p>
<p>Thank you for sharing your unique gifts and talents and contributing to our success. We&rsquo;re looking forward to working with you in the years to come.</p>
<p>Sincerely,</p>
<p><?php echo $signature; ?></p>
<p>HR/Admin.</p>
<?php break;
case "confirmation": ?>
<p><strong><u>CONFIRMATION OF APPOINTMENT</u></strong></p>
<p>This is to inform you that having satisfactorily completed your probationary period. Your appointment is hereby confirmed with effect from <?php echo $_GET['duedate']; ?> </p>
<p>Your position and remuneration remains unchanged.</p>
<p>On behalf of Management, I offer you hearty congratulations on your confirmation, and you have our best wishes for a most fulfilling career with Connect Marketing.</p>
<p>&nbsp;</p>
<p>Yours Faithfully<br />
  For: <strong>CONNECT MARKETING SERVICES LIMITED</strong></p>
<p><?php echo $signature; ?><br />
  <strong>HR &amp; Admin. Unit</strong></p>
<?php
break;
case "welcome":
    ?>
    <p align="center"><strong>&ldquo;Coming together is a beginning, staying together is progress, </strong><br />
  <strong>and working together is success.&rdquo;</strong><br />
  <strong>~Henry Ford~</strong></p>
<p><br />
  We're delighted that you joined <?php echo $_GET['companyname']; ?>. You will be a great asset to our team, and we look forward to a positive employment relationship.</p>
<p>There&rsquo;s always a lot to learn, not only about the work, but also about our culture and certain organizational procedures. Something as simple as getting a photocopy may be an entirely different procedure from what it was at your last job! </p>
<p>We want you to know that we&rsquo;re all anxious to see you succeed and there will be plenty of opportunity for you to learn and grow in the position.</p>
<p>Your induction timetable will be shared with you and concerned persons.</p>
<p>Good luck on the new job, and please feel free to contact me if you have any questions as you get started.</p>
<p>&nbsp;</p>
<p>Sincerely, </p>
<p><?php echo $signature; ?></p>
<p>HR Unit </p>
    <?php
    break;
case "SLC":?>
<p><strong><u>OFFER OF EMPLOYMENT</u></strong><br />
  Further to your application for employment and subsequent interviews with us, we are pleased to offer you contract employment as <strong>Ad-hoc Samsung Smart Life Consultant (SSLC) </strong>effective<strong> <?php echo $_GET['dateofemployment1']; ?></strong></p>
  <p>The terms and conditions of this offer are set out below:</p>
<p><strong><u>DUTIES AND RESPONSIBILITIES</u></strong></p>
<p>Please find enclosed to this letter your duties and responsibilities.</p>
<p>Your primary responsibility and professional loyalty will be to <strong>Connect Marketing Services Limited</strong>.</p>
<p><strong><u>REMUNERATION</u></strong></p>
<p>Your gross monthly salary is <strong>N<?php echo $_GET['monthlysalary1']; ?></strong></p>
<ul>
  <li>Transport Allowance <strong>N<?php echo $_GET['transportallowance']; ?>.</strong></li>
</ul>
<p><strong><u>CONFIDENTIALITY</u></strong></p>
<p>You are to be discreet with all information given to you and you should not in any way disclose any information on our product to anyone.</p>
<p>Failure to adhere to this instruction results to instant termination of employment.</p>
<p><strong><u>WORKING HOURS</u></strong>:</p>
<p>Your normal working hours will be from 08:00 to 17:00, Monday to Saturday. However, you may also be required to work extra hours as and when required by your Manager, or dictated by the nature and requirements of your job, and/or requirements of the department/ business.</p>
<p><strong><u>TERMINATION OF APPOINTMENT:</u></strong></p>
<p>Termination of appointment during and after probation by either party will be subject to two (2) weeks&rsquo; notice in writing and in the case of a default, a payment of two (2) weeks basic salary in lieu of notice is mandatory. </p>
<p>If the above terms and conditions are acceptable to you, please affix your signature to the attached copy and return same to us on or before your effective date of assumption of duty. Please note that you are to report to the Head, Human Resources.</p>
<p>Once again, we are delighted to welcome you to Connect Marketing Services Limited<strong> </strong>and hope that you will justify the confidence reposed in you.</p>
<p>Yours Sincerely,<br />
  For: <strong>Connect Marketing Services Limited</strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td>Nwanyichioma Eze<br />
    <strong>HR/Admin</strong><br /></td>
    <td>Adegoke Obembe<strong><br />
      Country Manager</strong><br />      
    <strong></strong></td>
  </tr>
</table>
<p><strong>&nbsp;</strong></p>
<p>I,_________________________________do hereby accept the offer of employment with the Company, subject to the terms set out above.</p>
<p>Signature_____________________.Date______________.</p>
<?php
break;
case "trade":
    ?>
    <p><strong><u>OFFER OF EMPLOYMENT</u></strong></p>
<p>Further to your application for employment and subsequent interviews with us, we are pleased to offer you contract employment as <strong>Trade Representative </strong>on grade level <strong>B1 </strong>effective from<strong> <?php echo $_GET['dateofemployment2']; ?></strong></p>
<p>The terms and conditions of this offer are set out below:</p>
<p><strong><u>DUTIES AND RESPONSIBILITIES</u></strong></p>
<p>Your duties and responsibilities will be handed over to you at resumption.</p>
<p>Your primary responsibility and professional loyalty will be to <strong>Connect Marketing Services Limited</strong>.</p>
<p><strong><u>REMUNERATION</u></strong></p>
<p>Your gross monthly salary is <strong>N<?php echo $_GET['monthlysalary2']; ?></strong> (subject to tax).</p>
<p>In addition, you will be entitled to the following:</p>
<ul>
  <li>Mandatory Pension contribution (7.5% each from both parties)</li>
  <li>HMO Scheme</li>
  <li>Transport Allowance</li>
  <li>Incentive (Performance based)</li>
</ul>
<p><strong><u>CONFIDENTIALITY</u></strong></p>
<p>You are to be discreet with all information given to you and you should not in any way disclose any information on our product to anyone.</p>
<p>Failure to adhere to this instruction results to instant termination of employment.</p>
<p><strong><u>WORKING HOURS</u></strong>:</p>
<p>Your normal working hours will be from 08:00 to 17:00, Monday to Saturday.ÊHowever, you may also be required to work extra hours as and when required by your Manager, or dictated by the nature and requirements of your job, and/or requirements of the department/ business.</p>
<p><strong><u>OTHER TERMS AND CONDITIONS</u></strong></p>
<p>Your employment is subject to a probation period of 3 (three) months. After the probationary period, you will be entitled to <strong>15</strong> working days annual leave at 6 months to your resumption date, but this is subject to a maximum of <strong>5</strong> days at a stretch. Note that this contract is renewable yearly.<strong><u></u></strong></p>
<p><strong><u>TERMINATION OF APPOINTMENT:</u></strong></p>
<p>Termination of appointment during and after probation by either party will be subject to two (2) weeks&rsquo; notice in writing and in the case of a default, a payment of two (2) weeks basic salary in lieu of notice is mandatory. </p>
<p>If the above terms and conditions are acceptable to you, please affix your signature to the attached copy and return same to us on or before your effective date of assumption of duty. Please note that you are to report to the Head, Human Resources.</p>
<p>Once again, we are delighted to welcome you to Connect Marketing Services Limited<strong> </strong>and hope that you will justify the confidence reposed in you.</p>
<p>Yours Sincerely,<br />
  For: <strong>Connect Marketing Services Limited</strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td>Nwanyichioma Eze<br />
    <strong>HR/Admin</strong><br /></td>
    <td>Adegoke Obembe<strong><br />
      Country Manager</strong><br />      
    <strong></strong></td>
  </tr>
</table>
<p><strong>&nbsp;</strong></p>
<p>I,_________________________________do hereby accept the offer of employment with the Company, subject to the terms set out above.</p>
<p>Signature_____________________.Date______________.</p>
    <?php
    break;
}
$message = ob_get_contents();
ob_end_clean();

$mpdf=new mPDF();

$file=time().".pdf";

$mpdf->WriteHTML($message);
$mpdf->Output("../letters/$file");
$msg="<p>Hello $firstname!</p><p>Please view the attached document. Kindly note that you cannot reply to this email, channel all correspondence/requests to the appropriate HR Team.</p><p>Thank you.</p>";
mail_attachment($file, "../letters/", $user, 'noreply@connectmarketingonline.com', "HRIS Platform", "noreply@connectmarketingonline.com", "$letter Letter for You", $msg);

if (file_exists($file)) unlink($file);

exit;
?>