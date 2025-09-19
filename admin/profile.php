<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); 
//mysqli_select_db($database_cn);
$user=$_GET['un'];
$query = "select a.*, b.jobtitle from staff_tbl as a left join jobs_tbl as b on b.jobcode=a.jobcode where a.email='$user'";
$rs = mysqli_query($cn, $query);
$row_rs = mysqli_fetch_assoc($rs);

$rs2=mysqli_query($cn, "select * from employeeProfile_tbl where email='$user'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="../jquery.min.js"></script>
</head>

<body>
<table border="0" cellspacing="2" cellpadding="8" width=95%>
  <tr>
      <td><h2><?php echo $row_rs['fullname']; ?></h2></td>
  </tr>
  <tr>
	<td bgcolor="#c0c0c0">JOB POSITION: <strong><?php echo $row_rs['jobtitle']; ?></strong></td>
      <td bgcolor="#7bebea">DEPARTMENT: <strong><?php echo $row_rs['department']; ?></strong></td>
      <td bgcolor="#f8dbd3">LINE MANAGER: <strong><?php echo $row_rs['linemgr']; ?></strong></td>
  </tr>
  <tr>
	<td colspan=3>
		<p>&nbsp;</p>
<div class="tabs">
	<ul>
		<li style="background: #ffffff">Personal Information</li>
		<li>Dependent(s) Information</li>
		<li>Medical Information</li>
		<li>Salary Info</li>
	</ul>
</div>
<div class=tab>
	<div style="padding: 20px;">
<?php
if (mysqli_num_rows($rs2)) {
	$row=mysqli_fetch_assoc($rs2);
?>
<table cellspacing="1" cellpadding="5" width=100%>
<tr valign="top"><tD align="right">Employee ID:</tD><td><?php echo $row['employeeID']; ?></td></tr>
<tr><td colspan=6 align="right" valign="top"></td><td rowspan=10 valign="top"><img src="../<?php echo $row["photograph"]; ?>" border=1 width=150 /></td></tr>
  <tr valign="top">
    <td align="right" width="14%">First Name:</td>
    <td bgcolor="#cccccc" width="14%"><?php echo $row['firstname']; ?></td>
    <td align="right" width="14%">Last Name:</td>
    <td bgcolor="#cccccc" width="14%"><?php echo $row['lastname']; ?></td>
    <td align="right" width="14%">Middle Name:</td>
    <td bgcolor="#cccccc" width="14%"><?php echo $row['middlename']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Date of Birth: </td>
    <td bgcolor="#cccccc"><?php echo $row['dob']; ?></td>
    <td align="right">Marital Status: </td>
    <td bgcolor="#cccccc"><?php echo $row['maritalStatus']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Phone Number: </td>
    <td bgcolor="#cccccc"><?php echo $row['phonenumber']; ?></td>
    <td align="right">Personal Email:</td>
    <td bgcolor="#cccccc"><?php echo $row['personalEmail']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Home Address: </td>
    <td bgcolor="#cccccc"><?php echo $row['homeAddress']; ?></td>
    <td align="right">Home City: </td>
    <td bgcolor="#cccccc"><?php echo $row['homeCity']; ?></td>
    <td align="right">Home State: </td>
    <td bgcolor="#cccccc"><?php echo $row['homeState']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Last Qualification <br />
    Obtained: </td>
    <td bgcolor="#cccccc"><?php echo $row['lastQualification']; ?></td>
    <td align="right">Course Studied: </td>
    <td bgcolor="#cccccc"><?php echo $row['courseStudied']; ?></td>
    <td align="right">Last Institution<br> Attended: </td>
    <td bgcolor="#cccccc"><?php echo $row['institution']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Trainings Attended: </td>
    <td bgcolor="#cccccc"><?php echo $row['trainings']; ?></td>
    <td align="right">Professional <br />
    Certifications:</td>
    <td bgcolor="#cccccc"><?php echo $row['professionalCerts']; ?></td>
    <td align="right">Professional <br>Membership: </td>
    <td bgcolor="#cccccc"><?php echo $row['professionalMembership']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Next of Kin <br />
    Name (1): </td>
    <td bgcolor="#cccccc"><?php echo $row['nokName1']; ?></td>
    <td align="right">Next of Kin <br />
    Relationship (1): </td>
    <td bgcolor="#cccccc"><?php echo $row['nokRelationship1']; ?></td>
    <td align="right">Next of Kin <br />
    Phone Number (1): </td>
    <td bgcolor="#cccccc"><?php echo $row['nokPhone1']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Next of Kin <br />
    Address (1): </td>
    <td bgcolor="#cccccc"><?php echo $row['nokAddress1']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Next of Kin <br />
    Name (2):</td>
    <td bgcolor="#cccccc"><?php echo $row['nokName2']; ?></td>
    <td align="right">Next of Kin <br />
    Relationship(2):</td>
    <td bgcolor="#cccccc"><?php echo $row['nokRelationship2']; ?></td>
    <td align="right">Next of Kin <br />
    Phone Number (2): </td>
    <td bgcolor="#cccccc"><?php echo $row['nokPhone2']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Next of Kin <br />
    Address (2): </td>
    <td bgcolor="#cccccc"><?php echo $row['nokAddress2']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Referee Name:</td>
    <td bgcolor="#cccccc"><?php echo $row['refName']; ?></td>
    <td align="right">Referee EMail: </td>
    <td bgcolor="#cccccc"><?php echo $row['refEmail']; ?></td>
    <td align="right">Referee <br />
    Phone Number:</td>
    <td bgcolor="#cccccc"><?php echo $row['refPhone']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Referee Address:</td>
    <td bgcolor="#cccccc"><?php echo $row['refAddress']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Referee (2) Name:</td>
    <td bgcolor="#cccccc"><?php echo $row['refName2']; ?></td>
    <td align="right">Referee (2) EMail: </td>
    <td bgcolor="#cccccc"><?php echo $row['refEmail2']; ?></td>
    <td align="right">Referee (2) <br />
    Phone Number:</td>
    <td bgcolor="#cccccc"><?php echo $row['refPhone2']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Referee (2) Address:</td>
    <td bgcolor="#cccccc"><?php echo $row['refAddress2']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Previous Employer: </td>
    <td bgcolor="#cccccc"><?php echo $row['previousEmployer']; ?></td>
    <td align="right">Previous Employer <br />
    Contact Email:</td>
    <td bgcolor="#cccccc"><?php echo $row['pEmployerEmail']; ?></td>
    <td align="right">Previous Employer <br />
    Contact Phone: </td>
    <td bgcolor="#cccccc"><?php echo $row['pEmployerPhone']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Previous Employer <br />
    Contact Address: <br /></td>
    <td bgcolor="#cccccc"><?php echo $row['pEmployerAddress']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Bank Name:</td>
    <td bgcolor="#cccccc"><?php echo $row['bankName'];?></td>
    <td align="right">Nuban Number:</td>
    <td bgcolor="#CCCCCC"><?php echo $row['NubanNumber'];?></td>
    <td align="right">Account Name:</td>
    <td bgcolor="#CCCCCC"><?php echo $row['AccountName']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Bank Branch:</td>
    <td bgcolor="#cccccc"><?php echo $row['bankBranch']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Pension Administrator Name:</td>
    <td bgcolor="#cccccc"><?php echo $row['pensionAdministratorName']; ?></td>
    <td align="right">Pension Administrator Account Number</td>
    <td bgcolor="#CCCCCC"><?php echo $row['pensionAdministratorAccountNumber']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Resumption Date</td>
    <td bgcolor="#cccccc"><?php echo $row['resumptionDate']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php if ($row['jobcode']!="FLD") { ?>
  <tr valign="top">
    <td align="right">Work Tools In Possession:</td>
    <td bgcolor="#cccccc"><?php echo $row['workToolsInPossession']; ?></td>
    <td align="right">Work Tool Status:</td>
    <td bgcolor="#CCCCCC"><?php echo $row['workToolStatus']; ?></td>
    <td align="right">Laptop Serial No:</td>
    <td bgcolor="#CCCCCC"><?php echo $row['laptopSerialNo']; ?></td>
  </tr>
  <?php } else {?>
  <tr valign="top">
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Personal Code:</td>
    <td bgcolor="#cccccc"><?php echo $row['personalCode']; ?></td>
    <td align="right">CUG Number:</td>
    <td bgcolor="#CCCCCC"><?php echo $row['CUGNumber']; ?></td>
    <td align="right">Designation:</td>
    <td bgcolor="#CCCCCC"><?php echo $row['designation']; ?></td>
  </tr>
  <tr valign="top">
    <td align="right">Work Status:</td>
    <td bgcolor="#cccccc"><?php echo $row['workStatus']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td align="right">Outlet Covering:</td>
    <td bgcolor="#cccccc"><?php echo $row['outletCovering']; ?></td>
    <td align="right">Outlet Code:</td>
    <td bgcolor="#CCCCCC"><?php echo $row['outletCode']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php } ?>
</table>
<?php } else echo "Employee profile has not yet been added!";?>
	</div>
</div>
<div class=tab>
	<div style="padding: 20px;">
<?php
$rs3=mysqli_query($cn, "select * from dependentProfile_tbl where parentEmail='$user'");
    if (mysqli_num_rows($rs3)) {
        
	while ($row=mysqli_fetch_assoc($rs3)){
	echo "<p>&nbsp;</p><table width=70% cellpadding=5 cellspacing=0 border=1 bordercolor=#cccccc><tr><td valign=top>";
        echo "<table cellpadding=4 border=0>";
	echo "<tr><td colspan=2><strong>DEPENDENT INFORMATION";
	if ($row['dependentCode']==1) echo " (SPOUSE)"; else echo " (CHILD)";
	echo "</strong></td></tr>";
        echo "<tr><td align=right><b>NAME:</b></td><td>".$row['name']."</td></tr>";
        echo "<tr><td align=right><b>DATE OF BIRTH:</b></td><td>".$row['dob']."</td></tr>";
        echo "<tr><td align=right><b>GENDER:</b></td><td>".$row['gender']."</td></tr>";
        if ($row['dependentCode']==1) {
            echo "<tr><td align=right><b>E-MAIL:</b></td><td>".$row['email']."</td></tr>";
            echo "<tr><td align=right><b>EMPLOYER NAME:</b></td><td>".$row['organisation']."</td></tr>";
        }
	echo "</table></td>";
        echo "<td valign=top><table cellpadding=4 cellspacing=0 ><tr><td colspan=2><strong>MEDICAL RECORD</strong></td></tr><tr><td colspan=2>";
        echo "<strong>GENOTYPE:</strong> ".$row['genotype']."<br />";
        echo "<strong>BLOOD GROUP:</strong> ".$row['bloodGroup']."<br />";
        echo "<P><strong>KNOWN MEDICAL CONDITION(S):</strong><BR>".$row['medicalConditions']."</P>";
        echo "<strong>HOSPITAL NAME:</strong> ".$row['hospitalName']."<br />";
        echo "<strong>HOSPITAL ADDRESS:</strong> ".$row['hospitalAddress']."<br />&nbsp;";
        echo "</td></tr>";
        echo "</table></td>";
	echo "<td rowspan=4><img src='".$row['photo']."' width=200 /></td></tr></table>";
	}
    } else {
        echo "No  dependent record found!";
    }
?></div>
</div>
<div class="tab">
	<div style="padding: 20px;">
	<h3>EMPLOYEES MEDICAL INFORMATION</h3>
	<?php
	mysqli_free_result($rs);
	$rs=mysqli_query($cn, "select * from medical_tbl where email='$user'");
    $cnt=mysqli_num_rows($rs);
    
    if ($cnt) {
        $row=mysqli_fetch_assoc($rs);
        echo "<strong>GENOTYPE:</strong> ".$row['genotype']."<br />";
        echo "<strong>BLOOD GROUP:</strong> ".$row['bloodGroup']."<br />";
        echo "<strong>PREFERRED MEDICAL PLAN:</strong> ".$row['preferredPlan']."<br />";
        echo "<P><strong>KNOWN MEDICAL CONDITION(S):</strong><BR>".$row['medicalConditions']."</P>";
        echo "<strong>HOSPITAL NAME:</strong> ".$row['hospitalName']."<br />";
        echo "<strong>HOSPITAL ADDRESS:</strong> ".$row['hospitalAddress']."<br />&nbsp;";
        echo "<hr size=1 />";
    }
    mysqli_free_result($rs);
    echo "<h3>Dependents' Medical Record</h3>";
    $rs=mysqli_query($cn, "select * from dependentProfile_tbl where parentEmail='$user'");
    $cnt=mysqli_num_rows($rs);
    if ($cnt) {
        echo "<Table border=1 bordercolor=#000 cellspacing=0 cellpadding=3 ><tr><th>NAME</th><th>GENOTYPE</th><th>BLOOD GROUP</th><th>KNOWN MEDICAL CONDITION(S)</th><th>HOSPITAL NAME</th></tr>";
        while ($row=mysqli_fetch_assoc($rs)) {
        echo "<tr><td valign=top>".$row['name']."</td>";
        echo "<td valign=top>".$row['genotype']."</td>";
        echo "<td valign=top>".$row['bloodGroup']."</td>";
        echo "<td valign=top>".$row['medicalConditions']."</td>";
        echo "<td valign=top><strong>".$row['hospitalName']."</strong><br>".$row['hospitalAddress']."</td>";
        echo "</tr>";
        }
        echo "</table>";
    }
    else {
        echo "<p>No dependent records existing!</p>";
    }
    ?></div>
</div>
<div class="tab">
	<h3>CURRENT SALARY PROFILE</h3>
	<div style="padding: 20px;">
	<?php
    $rs=mysqli_query($cn, "select a.*, c.fullname, b.jobtitle, d.employeeID from payslip_tbl as a left join jobs_tbl as b on (a.paycode=b.paycode) left join staff_tbl as c on (b.jobcode=c.jobcode) left join employeeProfile_tbl as d on (c.email=d.email) where c.email='$user'") or die(mysqli_error($cn));
    $cnt=mysqli_num_rows($rs);
    $total=0.00;
    /*if ($cnt) {
        $fldcount=mysqli_num_fields($rs);
        for ($i=0; $i<$fldcount; $i++) {
            $fld = mysqli_fieldname($rs, $i);
            $$fld = mysqli_result($rs, 0, $i);
            if(is_numeric($$fld) && ($fld!="ID") && ($fld!="employeeID")) {
                $total+=$$fld;
            }
        }
    $deductions=$payee+$pension+$leave+$others;
    $allowances=$total - $basic - $deductions;
    $netpay=$total-($deductions*2);
    $grosspay=$basic+$allowances;
    }*/
		?>
		<table cellspacing="0" cellpadding="4" width=100%>
  <tr>
    <th>Taxable   Earnings</th>
    <td></td>
    <th>Amount</th>
    <th>Allowance</th>
    <th>Amount (<s>N</s>)</th>
    <th></td>
    <th>Deductions</th>
    <th>Amount (<s>N</s>)</th>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Consolidated Salary</td>
    <td></td>
    <td align="right"><?php echo number_format($basic, 2, '.', ','); ?></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td></td>
    <td>Paye</td>
    <td align="right"><?php echo number_format($payee, 2, '.', ','); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td></td>
    <td>Pension</td>
    <td align="right"><?php echo number_format($pension, 2, '.', ','); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td></td>
    <td>Loan</td>
    <td align="right"><?php echo number_format($loan, 2, '.', ','); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td></td>
    <td>Other Deductions</td>
    <td align="right"><?php echo number_format($others, 2, '.', ','); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total Taxable</td>
    <td></td>
    <td align="right" style="border-top:1px solid #000;"><?php echo number_format($basic, 2, '.', ','); ?></td>
    <td align="center">Total</td>
    <td align="right" style="border-top:1px solid #000;"><?php echo number_format($allowances, 2, '.', ','); ?></td>
    <td></td>
    <td>Total</td>
    <td align="right" style="border-top:1px solid #000;"><?php echo number_format($deductions, 2, '.', ','); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Gross Earnings</td>
    <td></td>
    <td align="right" style="border-bottom: double #000;"><?php echo number_format($grosspay, 2, '.', ','); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>NET PAY **** =N=</td>
    <td></td>
    <td align="right" style="border-bottom: double #000; border-top:1px solid #000;"><?php echo number_format($netpay, 2, '.', ','); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
	</div>
</div>
	</td>
  </tr>
</table>

<script>
	$('.tabs li').click(function(){
		$('.tabs li').css({'background':'#ccc'});
		$(this).css({'background':'#ffffff'});
		var tab = ($('.tabs li').index($(this)));
		$('.tab').hide();
		$('.tab:eq('+tab+')').show();
		});
	$('.tab:eq(0)').show();
</script>
</body>
</html>