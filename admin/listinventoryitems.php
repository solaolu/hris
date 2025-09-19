<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

include('paginate.php');

    $limit = 20;	
    $page = isset($_GET['page']) ? mysqli_escape_string($cn, $_GET['page']):null;
    if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
    }

$rs=mysqli_query($cn, "select *, (itemInStore + itemInTransit) as itemTotal from inventory_tbl where isDeleted=0 order by ID desc") or die(mysqli_error($cn));

$stages=3;
$targetpage="listinventoryitems.php";
$total_pages=mysqli_num_rows(mysqli_query($cn, "select ID from inventory_tbl"));

$paginate=paginate($total_pages, $stages, $page, $limit, $targetpage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div style="padding: 30px;" >
    <h3>INVENTORY ITEMS</h3>
    <p><a href="addItem.php">ADD NEW INVENTORY ITEM</a></p>
    <p>&nbsp;</p>
    <p><strong><?php
$msg=isset($_GET['msg']) ? $_GET['msg']:null;
echo $msg; ?></strong></p>
    <table id="inventoryTable">
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No items found.</td></tr>"; else {?>
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Item Name</th>
                <th>Total Quantity</th>
                <th>Quantity In Warehouse</th>
                <th>Quantity In Transit</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php }
        while ($row=mysqli_fetch_assoc($rs)) {
            ?>
            <tr><td><?php //echo $row['materialOwner']; ?></td>
                <td><?php echo $row['itemName']; ?></td>
                <td align=right><?php echo $row['itemTotal'];?></td>
                <td align=right><u><?php echo $row['itemInStore'];?></u></td>
                <td align=right><?php echo $row['itemInTransit'];?></td>
                <td><a href="editItem.php?id=<?php echo $row['ID']; ?>">EDIT</a></td>
                <td><a class="delete-item"  href="delete.php?id=<?php echo $row['ID'];?>&ref=listinventoryitems.php&msg=inventory item deleted&tag=inventory_tbl">DELETE</a></td>
            </tr>
            <?php
            }
        ?>
        </tbody>
    </table>
        <p><a href="inventoryexport.php" target="_blank">Export to Excel</a></p>
    <p>&nbsp;</p>
    <?php //echo "<div>".$paginate."</div>"; ?>
    </div>
</body>
       <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Data Table -->
        <script src="../vendors/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="../vendors/bower_components/jszip/dist/jszip.min.js"></script>
        <script src="../vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script>
            $('#inventoryTable').dataTable({});
        </script>
        <script src="../js/delete-script.js"></script>
</html>