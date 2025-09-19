<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
//$sql = "select SUM(amount), payType from payroll_tbl where payslipDate = (select payslipDate from payroll_tbl order by payslipDate desc limit 0,1) group by payType";
$sql = "select SUM(amount) as total, payType, payslipDate from payroll_tbl group by payType, payslipDate order by payslipDate desc limit 0,20";
$res = $db->getData($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body style="margin-top:50px;">
 
 <table width="80%" border="0" cellspacing="1" cellpadding="10" align=center bgcolor="#333">
  <tr><td valign=top bgcolor="#efefef">
  <h3>Payroll Schedules</h3>
   <?php 
      $date="";
      $j=-1;
      $paydates=array(array());
        for ($i=0; $i<count($res);$i++)
        {
               if ($date!=$res[$i]['payslipDate']) {
                   $j++;
                   $date=$res[$i]['payslipDate'] ;
                   $paydates[$j][0]=$date;
               } 
            
            $paydates[$j][$res[$i]['payType']]=$res[$i]['total'];
        }
      echo "<table id=payablesReport cellpadding=5 cellspacing=1 bgcolor=#333><tr bgcolor=#ccc><td>Date</td><td>Total Allowances</td><td>Total Deductions</td></tr>";
      foreach ($paydates as $rows)
      {
          echo "<tr bgcolor=#ccc>";
          echo "<td>".date("d-M-Y", strtotime($rows[0]))."</td><td>".$rows[1]."</td><td>".$rows[2]."</td>";
          echo "</tr>";
      }
      echo "</table>";
      
   ?>
   <p><a href="#" onclick="exportF(this)" target="_blank">Export to Excel</a></p>
  </td>
</tr></table>
</body>
<script>
function exportF(elem) {
  var table = document.getElementById("payablesReport");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "export.xls"); // Choose the file name
  return false;
}    
</script>
</html>
<?php
//mysqli_free_result($Recordset1);
?>
