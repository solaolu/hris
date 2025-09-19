<?php
require_once('checkAdmin.php');
require_once('../Connections/cn.php');


$id=$_GET['id'];

$sql = "select * from supplier_tbl where ID=$id";
$sql2 = "select * from supplierBanks_tbl where supplierID=$id";
$sql3 = "select * from supplierCapability_tbl where supplierID=$id";
$sql4 = "select * from supplierExperience_tbl where supplierID=$id";
$sql5 = "select * from supplierSales_tbl where supplierID=$id";
$sql6 = "select * from supplierReference_tbl where supplierID=$id";
$sql7 = "select distinct category from supplierCategory_tbl";

//var_dump($_POST);

$rows = $db->getData($sql);
$_SESSION['supplierinfo'] = $rows[0];
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
       <h3>SUPPLIER APPLICATION DETAILS</h3>
        <?php 
        $template = array(2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,2,1,2,1,2,3,4,2,1,1,1,2,2);
        $skip = "`status`";
        showView('supplier_tbl', $skip, $template, $rows[0]); ?>
        <h4>Bank Information</h4>
        <?php $rows = $db->getData($sql2); 
        if (count($rows)==0) {
            echo "No bank detail registered.";
        } else {
        ?>
        <table cellspacing=1 cellpadding=4 bgcolor="#ccc">
                <thead>
                    <th>Bank Name</th>
                    <th>Bank Address</th>
                    <th>Bank Account Name</th>
                    <th>Bank Sort Code</th>
                </thead>
                <tbody>
            <?php foreach($rows as $row){ ?>
                <tr bgcolor="#fff">
                    <td><?php echo $row['bankName']; ?></td>
                    <td><?php echo $row['bankAddress']; ?></td>
                    <td><?php echo $row['bankAccountName']; ?></td>
                    <td><?php echo $row['bankSortCode']; ?></td>
                </tr>
            <?php }?>
                </tbody>
        </table>    
        <?php
        }
        ?>
        <h4>Capabilities</h4>
        <?php $rows = $db->getData($sql3); 
        if (count($rows)==0) {
            echo "No capability registered.";
        } else {
        ?>
        <table cellspacing=1 cellpadding=4 bgcolor="#ccc">
                <thead>
                    <th>Service</th>
                    <th>Description</th>
                    <th>Authorised Agent</th>
                    <th>Telephone</th>
                </thead>
                <tbody>
            <?php foreach($rows as $row){ ?>
                <tr bgcolor="#fff">
                    <td><?php echo $row['service']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['authorizedAgent']; ?></td>
                    <td><?php echo $row['telephone']; ?></td>
                </tr>
            <?php }?>
                </tbody>
        </table>    
        <?php
        }
        ?>
        <h4>Experience</h4>
        <?php $rows = $db->getData($sql4); 
        if (count($rows)==0) {
            echo "No experience registered.";
        } else {
        ?>
        <table cellspacing=1 cellpadding=4 bgcolor="#ccc">
                <thead>
                    <th>Organisaiton</th>
                    <th>Value</th>
                    <th>Year</th>
                    <th>Supplied Goods</th>
                    <th>Destination</th>
                </thead>
                <tbody>
            <?php foreach($rows as $row){ ?>
                <tr bgcolor="#fff">
                    <td><?php echo $row['organisation']; ?></td>
                    <td><?php echo $row['value']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['suppliedGood']; ?></td>
                    <td><?php echo $row['destination']; ?></td>
                </tr>
            <?php }?>
                </tbody>
        </table>    
        <?php
        }
        ?>
        <h4>Sales</h4>
                <?php $rows = $db->getData($sql5); 
        if (count($rows)==0) {
            echo "No sales registered.";
        } else {
        ?>
        <table cellspacing=1 cellpadding=4 bgcolor="#ccc">
                <thead>
                    <th>Service</th>
                    <th>Company</th>
                    <th>Address</th>
                    <th>Contact Person</th>
                    <th>Phone No</th>
                    <th>Sales Value</th>
                </thead>
                <tbody>
            <?php foreach($rows as $row){ ?>
                <tr bgcolor="#fff">
                    <td><?php echo $row['service']; ?></td>
                    <td><?php echo $row['company']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['contactPerson']; ?></td>
                    <td><?php echo $row['phoneNo']; ?></td>
                    <td><?php echo $row['salesValue']; ?></td>
                </tr>
            <?php }?>
                </tbody>
        </table>    
        <?php
        }
        ?>
        <h4>References</h4>
                <?php $rows = $db->getData($sql6); 
        if (count($rows)==0) {
            echo "No reference registered.";
        } else {
        ?>
        <table cellspacing=1 cellpadding=4 bgcolor="#ccc">
                <thead>
                    <th>Company Name</th>
                    <th>Company Address</th>
                    <th>Company Phone No</th>
                    <th>Company Telephone No</th>
                    <th>Recommendation Letter</th>
                </thead>
                <tbody>
            <?php foreach($rows as $row){ ?>
                <tr bgcolor="#fff">
                    <td><?php echo $row['companyName']; ?></td>
                    <td><?php echo $row['companyAddress']; ?></td>
                    <td><?php echo $row['companyPhoneNo']; ?></td>
                    <td><?php echo $row['companyTelephoneNo']; ?></td>
                    <td><A target="_blank" href="../<?php echo $row['recommendationLetter']; ?>">View Letter</A></td>
                </tr>
            <?php }?>
                </tbody>
        </table>    
        <?php
        }
        ?>
        <p>&nbsp;</p>
        <FORM method=post action="procurementapplications.php?mm_post=true">
           <input type="hidden" value="<?php echo $_GET['id']; ?>" name="u" />
            <table cellpadding="3">
                <tr>
                    <td><label><input type="radio" name="approval" value="2" />APPROVE</label></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td><label><input type="radio" name="approval" value="3" />UNDERGOING ADMINISTRATIVE REVIEW</label></td>
                    <TD><label><input type="radio" name="approval" value="1" />DISAPPROVE</label></TD>
                </tr>
                <tr>
                    <td colspan="2">
                       <select name="category" >
                        <option>Category</option>
                        <?php 
                                $categories=$db->getData($sql7);
                                foreach($categories as $category){
                                    echo "<option value='".$category['category']."'>".$category['category']."</option>";
                                }?>    
                       </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <select name="service">
                            <option>BRIEFS APPLICABLE</option>
                            <option value="events">EVENTS</option>
                            <option value="logistics">LOGISTICS</option>
                            <option value="logo">LOGO</option>
                            <option value="research">RESEARCH AND STRATEGY</option>
                            <option value="dj">TECHNICAL - DEEJAY</option>
                            <option value="light">TECHNICAL - LIGHT</option>
                            <option value="photography">TECHNICAL - PHOTOGRAPHY</option>
                            <option value="videography">TECHNICAL - VIDEOGRAPHY</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><input type="submit" value="SUBMIT DECISION" /></td>
                </tr>
            </table>
            <p>&nbsp;</p>
        </FORM>
        <?php
        } else {
            echo "No supplier found!";
        }
        ?>
   </div>
   <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
</body>
</html>