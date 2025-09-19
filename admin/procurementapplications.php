<?php
require_once('checkAdmin.php');
require_once('../Connections/cn.php');
$msg="";
if ($_GET['mm_post']=="true"){
    if (isset($_POST['approval'])){
        if ($_POST['approval']==1 || $_POST['approval']==2){
            $uID=$_POST['u'];
            $sql="update supplier_tbl set status=".$_POST['approval']." where ID=$uID";
            
            //move to approved table
            if ($_POST['approval']==2){
             
                $supplier = [];
                //var_dump($_SESSION);
                $supplier["supplierName"]=$_SESSION['supplierinfo']['companyName'];
                $supplier["services"]=$_POST['services'];
                $suplier['category']=$_POST['category'];
                $supplier['supplierID']=$_SESSION['supplierinfo']['ID'];
                
                $supplier = (Object) $supplier;
                $db->insert("approvedSuppliers_tbl", $supplier);
                
                $password=randomPassword();
            //notify supplier of account creation
                $company_email=$_SESSION['supplierinfo']['companyEmail'];
                
            //create user
                $user = (Object) ["email"=>$company_email, "password"=>md5($password), "role"=>2];
                $db->insert("users_tbl", $user);
            }
            
            $db->execute($sql);
            $msg="The supplier decision has been saved!";
            unset($_SESSION['supplierinfo']);
        }
    }
}

include('paginate.php');

$limit = 15;	
$page = isset($_GET['page']) ? mysqli_escape_string($cn, $_GET['page']):null;
if($page){
    $start = ($page - 1) * $limit; 
} else{
    $start = 0;	
}

$sql = "select ID, companyName, CONCAT(contactPersonTitle,' ',contactPerson) as contactPerson, contactPersonPhone, companyEmail, businessNature, officeAddress from supplier_tbl where status=0 or status=3 order by ID desc limit $start, $limit";


//var_dump($_POST);

$rows = $db->getData($sql);
$stages=3;
$targetpage="procurementapplications.php";
$total_pages=count($rows);

$paginate=paginate($total_pages, $stages, $page, $limit, $targetpage);
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
       <h3>SUPPLIER APPLICATIONS</h3>
        <p><strong><?php echo $msg; ?></strong></p>
        <table cellpadding=5 cellspacing=1 bgcolor="#cccccc" border=0 >
            <thead>
                <tr>
                    <th></th>
                    <th>Company Name</th>
                    <th>Contact Person</th>
                    <th>Contact Person (Phone)</th>
                    <th>Company Email</th>
                    <th>Business Nature</th>
                    <th>Office Address</th>
                </tr>
            </thead>
            <tbody>
               <?php $i=1;foreach ($rows as $row) { ?>
                <tr bgcolor="#ffffff">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['companyName']; ?></td>
                    <td><?php echo $row['contactPerson']; ?></td>
                    <td><?php echo $row['contactPersonPhone']; ?></td>
                    <td><?php echo $row['companyEmail']; ?></td>
                    <td><?php echo $row['businessNature']; ?></td>
                    <td><?php echo $row['officeAddress']; ?></td>
                    <td><a href="viewprocurementapplication.php?id=<?php echo $row['ID']; ?>">View Details</a></td>
                </tr>
                <?php $i++;} ?>
            </tbody>
        </table>
        <?php echo "<div>".$paginate."</div>"; ?>
        <?php
        } else {
            echo "No requests found!";
        }
        ?>
   </div>
   <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
</body>
</html>