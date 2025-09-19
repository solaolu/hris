<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
<link href="../datePicker.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../date.js"></script>
    <script type="text/javascript" src="../jquery.datePicker.js"></script>
<script>
    
    function swapfields(val){
        $('.welcome').hide();$('.confirmation').hide();$('.anniversary').hide();$('.SLC').hide();$('.trade').hide();
        $('.'+val).show();
    }
</script>
</head>
<?php include('../Connections/cn.php');
//mysqli_selectdb($database_cn);
?>
<body>
<div class="container">
    <h3>SEND LETTER</h3>
<form method=get action=letter.php >
    <table cellpadding=5 cellspacing=2 align=center>
        <tr>
            <td>Select recipient: </td>
            <td><select name="user">
                <option value="">select a name</option>
            <?php
            $rs=mysqli_query($cn, "select fullname, email from staff_tbl");
            while ($row=mysqli_fetch_assoc($rs)){
            ?>
            <option value="<?php echo $row['email']; ?>"><?php echo $row['fullname']; ?></option>
            <?php } ?>
            </select>
            <br></td>
        </tr>
        <tr>
            <td>Letter Template: </td>
            <td align=left>
                <select name="l" onchange="swapfields(this.value);">
                <option></option>
                <option value="welcome">Welcome Letter</option>
                    <option value="anniversary">Anniversary Letter</option>
                    <option value="confirmation">Confirmation Letter</option>
                    <option value="SLC">SSLC Letter</option>
                    <option value="trade">Trade Rep Offer Letter</option>
                    <!--<option value="exit">Exit Letter</option>-->
                </select><br></td>
        </tr>
        <tr>
            <td>Company name: </td>
            <td align=left><select name="companyname" >
            <option></option>
        <?php 
        //companies
        $query_rs6 = "select ID, name from company_tbl where id<>7";
        $rs6=mysqli_query($cn, $query_rs6) or die(mysqli_error($cn));
        //$row_rs5=mysqli_fetch_assoc($rs6);
        $totalRows_rs6=mysqli_num_rows($rs6);
        while ($row_rs6 = mysqli_fetch_assoc($rs6)) {  
            ?>
                    <option value="<?php echo $row_rs6['ID']?>" ><?php echo $row_rs6['name']?></option>
                    <?php
            }
        ?>    
      </select><br></td>
        </tr>
        <tr class="anniversary" style="display: none;"><td>Years: </td><td align=left><input type="text" name="years" /></td></tr>
        <tr class="welcome" style="display: none;"><td></td></tr>
        <tr class="confirmation" style="display: none;"><td>Confirmation Date: </td><td align=left><input type="text" name="duedate" /></td></tr>
        <tr class="SLC" style="display: none;"><td>Date of Employment: </td><td align=left><input type="text" name="dateofemployment1" /></td></tr>
        <tr class="SLC" style="display: none;"><td>Monthly Salary: </td><td align=left><input type="text" name="monthlysalary1" /></td></tr>
        <tr class="SLC" style="display: none;"><td>Transport Allowance: </td><td align=left><input type="text" name="transportallowance" /></td></tr>
        <tr class="trade" style="display: none;"><td>Date of Employment: </td><td align=left><input type="text" name="dateofemployment2" /></td>
        <tr class="trade" style="display: none;"><td>Monthly Salary: </td><td align=left><input type="text" name="monthlysalary2" /></td></tr>
    </table>
    
    
        
    <p><input type=submit value="Send Letter" /></p>
</form>
</div>
</body>
</html>
