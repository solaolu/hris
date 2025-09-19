<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

include('paginate.php');

    $limit = 10;	
    $page = (isset($_GET['page'])) ? mysqli_escape_string($cn, $_GET['page']): null;
    if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
    }

$sql="select a.ID, a.owner, a.projectName, a.requestPurpose, a.collectionBy, a.collectionTime, a.requestStatus, b.fullname from inventoryRequests_tbl as a left join staff_tbl as b on a.owner=b.email order by ID desc limit $start, $limit";


$rs=mysqli_query($cn, $sql) or die(mysqli_error($cn));

$stages=3;
$targetpage="inventoryrequests.php";
$total_pages=mysqli_num_rows(mysqli_query($cn, "select ID from inventoryRequests_tbl"));

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
    <h3>INVENTORY REQUESTS</h3>
    <table cellpadding=5 cellspacing=1 bgcolor="#333">
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No inventory request found.</td></tr>";
    while ($row=mysqli_fetch_assoc($rs)) {
        ?>
        <tr bgcolor="#efefef">
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['projectName']; ?></td>
            <!--<td><?php echo $row['collectionBy']; ?></td>-->
            <td><u><?php echo $row['collectionTime']; ?></u></td>
            <?php
                switch ($row['requestStatus']){
                    case 0:
                        //$approval="incomplete";$color="orange";
                        $approval="pending";$color="#ffcc00";
                        break;
                    case 1:
                        $approval="items received";$color="green";
                        break;
                    case 2:
                        $approval="items returned";$color="red";
                        break;
                }
            
            ?>
            <td style='background:<?php echo $color; ?>; color: #ffffff;' align=center><?php
            echo strtoupper($approval);
            ?></td>
            <td><a href="showinventoryrequest.php?id=<?php echo $row['ID']; ?>">SHOW DETAILS</a></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php echo "<div>".$paginate."</div>"; ?>
    </div>
</body>
</html>