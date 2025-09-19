<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

include('paginate.php');

    $limit = 15;	
    $page = mysqli_escape_string($_GET['page']);
    if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
    }

$rs=mysqli_query($cn, "select a.*, b.fullname, c.supplierName as supplier from briefTemplate_tbl as a left join staff_tbl as b on a.filledBy=b.email left join suppliers_tbl as c on a.preferredSupplier=c.ID order by ID desc limit $start, $limit") or die(mysqli_error($cn));

$stages=3;
$targetpage="supplierbrief.php";
$total_pages=mysqli_num_rows(mysqli_query($cn, "select ID from briefTemplate_tbl"));

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
    <div style="padding: 30px;" >
    <h3>SUPPLIER BRIEFING</h3>
    <p><strong><?php
//$msg=$_GET['msg'];
//echo $msg; ?></strong></p>
    <table cellpadding=5 border=1 bordercolor="#000000" cellspacing=0>
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No reports found.</td></tr>"; else {?>
            <tr>
            <th>Request By</th>
            <th>Project Name</th>
            <th>Supplier</th>
            <th>Event Date</th>
            <td></td>
        </tr>
    <?php }
    while ($row=mysqli_fetch_assoc($rs)) {
        ?>
        <tr><td><?php echo $row['fullname']; ?></td>
            <td><?php echo strtoupper($row['projectName']); ?></td>
            <td><?php echo $row['supplier']; ?></td>
            <td><?php echo $row['eventDate'];?></td>

            <td><a href="brief.php?id=<?php echo $row['ID']; ?>">VIEW BRIEF</a></td>
            <!--<td><a  href="delete.php?id=<?php echo $row['ID'];?>&ref=listinventoryitems.php&msg=inventory item deleted&tag=inventoryItems_tbl">DELETE</a></td>-->
        </tr>
        <?php
        }
        ?>
    </table>
    <p>&nbsp;</p>
    <?php echo "<div>".$paginate."</div>"; ?>
    </div>
</body>
</html>