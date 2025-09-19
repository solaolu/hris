<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../jquery.min.js"></script>
<link href="../datePicker.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../date.js"></script>
    <script type="text/javascript" src="../jquery.datePicker.js"></script>
<?php
if (isset($_POST['todo'])) {
    if ($_POST['todo']=="addUnit"){
        $unitInfo = "|".$_POST['unit'].":".$_POST['unitHead']."|";
        mysqli_query($cn, "update config_tbl set value=CONCAT(value, '$unitInfo') where parameter='Unit Heads'") or die(mysqli_error($cn));
        
        $msg="New unit settings added and saved!";
    }
    
    if ($_POST['todo']=="updateUnit"){
        $units = $_POST['unit'];
        $unitHeads = $_POST['unitHead'];
        $items = count($units);
        for ($i=0; $i<$items; $i++){
        $unitInfo .= "|".$units[$i].":".$unitHeads[$i]."|";
        }
        mysqli_query($cn, "update config_tbl set value='$unitInfo' where parameter='Unit Heads'") or die(mysqli_error($cn));
        
        $msg="Unit Head settings updated successfully!";
    }
    
    if ($_POST['todo']=="saveNotifiers") {
        $depts = array("Admin", "Finance", "Procurement");
        for ($i=0; $i<3; $i++){
            $query="update config_tbl set value='".$_POST[$depts[$i]]."' where parameter='".$depts[$i]."'";
            
            mysqli_query($cn, $query);
        }
        $msg="Department notification settings saved!";
    }
    
    if ($_POST['todo']=="signatures") {
        mysqli_query($cn, "update config_tbl set value='".$_POST['hrpersonell']."' where parameter='HR Name'");
        mysqli_query($cn, "update config_tbl set value='".$_POST['financepersonell']."' where parameter='Finance & Admin Name'");
        
        if (isset($_FILES['hrsignature'])){
        move_uploaded_file($_FILES['hrsignature']['tmp_name'], '../images/config/hrsignature.jpg');    
        mysqli_query($cn, "update config_tbl set value='hrsignature.jpg' where parameter='HR Signature' and value=''");
        }
        
        if (isset($_FILES['financesignature'])) {
        move_uploaded_file($_FILES['financesignature']['tmp_name'], '../images/config/financesignature.jpg');
                mysqli_query($cn, "update config_tbl set value='financesignature.jpg' where parameter='Finance & Admin Signature' and value=''");

        }
        $msg = "Personel name and signatures saved!";
    }
}
?>
</head>
<body>
<div style="padding: 20px;">
    <h3>HRIS CONFIGURATIONS</h3>
    <p><Strong><?php echo $msg; ?></Strong>&nbsp;</p>
    <table border=1 bordercolor="#000000" cellpadding=10 cellspacing=5 width=100%>
        <tr>
            <td valign="TOP" width="50%"><TABLE align=left cellpadding=5 width=100%>
        <TR>
            <td bgcolor="#CCC"><h4>UNITS & UNIT HEADS</h4></td>
        </TR>
        <TR>
            <td align="left">
                <form method=post>
                    <p><strong>Add a Unit Configuration:</strong></p>
                    <select name="unit">
                        <option>Select a Unit</option>
                    <?php
                    $u=mysqli_query($cn, "select distinct department from staff_tbl order by department");
                    while ($rowu=mysqli_fetch_assoc($u)){
                        ?>
                        <option value="<?php echo $rowu['department']; ?>"><?php echo $rowu['department']; ?></option>
                        <?php
                    }
                    ?>
                    </select><br>
                    Unit Head (email): <input type=text value="" name="unitHead" />
                    <input type="hidden" value="addUnit" name="todo" />
                    <input type="submit" value="ADD UNIT SETTINGS" />
                </form>
                <p>&nbsp;</p>
                <form method="post">
                <table cellpadding=4 cellspacing=0 border=1 bordercolor="#000000">
                    <tr><td>UNIT</td><td>UNIT HEAD (email)</td></tr>
                    <?php
                    $rs=mysqli_query($cn, "select * from config_tbl where parameter='Unit Heads'");
                    $thevals=mysqli_result($rs, 0, 'value');
                    
                    $unit = explode("||", $thevals);
                    for ($i=0; $i<count($unit); $i++){
                        if (!is_null($unit[$i])){
                        $unitvals=explode(":", trim($unit[$i], "|"));
                        ?>
                        <tr>
                            <td><strong><?php echo $unitvals[0]; ?></strong><input type="hidden" name="unit[]" value="<?php echo $unitvals[0]; ?>" /></td>
                            <td><input type="text" name="unitHead[]" value="<?php echo $unitvals[1]; ?>" size="40" /></td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                </table>
                <input type="submit" value="Save Changes" />
                <input type="hidden" value="updateUnit" name="todo" />
                </form>
            </td>
        </TR>
</TABLE></td>
            <td valign="top">
                <table cellpadding=4 cellpadding=5 width=100%>
                    <tr>
                    <td colspan=2 bgcolor="#ccc"><h4>DEPARTMENT CORRESPONDENCE (NOTIFICATIONS)</h4></td>
                    </tr>
                    <tr>
                        <TD>
                            <form method=post>
                                <table cellpadding="4">
                                    <tr>
                                        <th>Department</th>
                                        <th>Email (seperated by commas)</th>
                                    </tr>
                                    <?php
                                    mysqli_free_result($rs);
                                    $rs=mysqli_query($cn, "select * from config_tbl where parameter='Procurement' or parameter='Finance' or parameter='Admin'");
                                    while ($row=mysqli_fetch_assoc($rs)){
                                    ?>
                                    <tr>
                                        <td align=right><strong><?php echo $row['parameter']; ?>:</strong></td>
                                        <td><input type="text" size=40 name="<?php echo $row['parameter']; ?>" value="<?php echo $row['value']; ?>"></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                <input type="hidden" name="todo" value="saveNotifiers" />
                                <input type="submit" value="Save All" />
                            </form>
                        </TD>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <form method=post enctype="multipart/form-data">
                    <input type="hidden" name="todo" value="signatures" />
                    <?php
                    $rs=mysqli_query($cn, "select * from config_tbl where parameter='HR Name' or parameter='HR Signature' or parameter='Finance & Admin Name' or parameter='Finance & Admin Signature' order by ID asc");
                    ?>
                <table cellpadding=4 width=100%  >
                    <tr>
                        <td colspan=3 bgcolor="#ccc"><h4>SIGNATURES (FOR LETTERS AND PAYSLIPS)</h4></td>
                    </tr>
                    <tr>
                        <td align=RIGHT>HR PERSONELL NAME:</td>
                        <td><input type="text" name="hrpersonell" value="<?php echo mysqli_result($rs, 0, 'value'); ?>" /></td>
                    </tr>
                    <tr>
                        <td align="right" valign=top>HR PERSONELL SIGNATURE:</td>
                        <td><?php
                        $hrsign=mysqli_result($rs, 1, 'value');
                        if ($hrsign!="") echo "<img src='../images/config/$hrsign' height='50' /><br>Replace:";
                        ?><input type=file name="hrsignature" /></td>
                    </tr>
                    <tr>
                        <td align=RIGHT>FINANCE PERSONELL NAME:</td>
                        <td><input type="text" name="financepersonell" value="<?php echo mysqli_result($rs, 2, 'value'); ?>" /></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">FINANCE PERSONELL SIGNATURE:</td>
                        <td><?php
                        $finsign=mysqli_result($rs, 3, 'value');
                        if ($finsign!="") echo "<img src='../images/config/$finsign' height='50' /><br>Replace:";
                        ?><input type=file name="financesignature" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" value="SAVE SIGNATURES" /></td>
                    </tr>
                </table>
                </form>
            </td>
            <td></td>
        </tr>
    </table>
</div>
</body>
</html>
