<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

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
    <?php
    $id=$_GET['id'];
    $action=$_GET['a'];
    
    
        $rs=mysqli_query($cn, "select * from inventoryRequest_tbl where ID=$id") or die(mysqli_error($cn));
        if (!mysqli_num_rows($rs)) {
            echo "<p>Invalid Record</p>";
            } else {
        $row=mysqli_fetch_assoc($rs);
        ?>
        <table cellspacing="0" cellpadding="5">
  <tr>
    <td align="right">Project Name: </td>
    <td><?php echo $row['projectName']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">Item(s) Required:</td>
    <td><table cellspacing="0" cellpadding="5" border=1 bordercolor="#000000">
      <tr>
        <td>Inventory Item</td>
        <td>Qty</td>
      </tr>
      <?php
      $items=explode(",", $row['itemRequired']);
      $qty=explode(",", $row['quantityRequired']);
      
      for ($i=0; $i<count($items); $i++) {
      ?>
      <tr>
        <td><?php echo $items[$i]; ?></td>
        <td><?php echo $qty[$i]; ?></td>
      </tr>
      <?php
      if ($action=="release"){
        mysqli_query($cn, "update inventoryItems_tbl set qtyAvailable=qtyAvailable-$qty[$i], qtyInTransit=qtyIntransit+$qty[$i] where itemName='$items[$i]'");
      mysqli_query($cn, "update inventoryRequest_tbl set released=1 where ID=$id");
      $msg="The items have now being released from the inventory, quantity available has been updated!";
      }
      else {
        mysqli_query($cn, "update inventoryItems_tbl set qtyAvailable=qtyAvailable+$qty[$i], qtyInTransit=qtyIntransit-$qty[$i] where itemName='$items[$i]'");
      mysqli_query($cn, "update inventoryRequest_tbl set released=0 where ID=$id");
      $msg="The items have now being restored to the inventory, quantity available has been updated!";
      }
      } ?>
    </table></td>
  </tr>
  <tr>
    <td align="right">Duration: </td>
    <td><?php echo $row['duration']; ?></td>
  </tr>
  <tr>
    <td align="right">Pick Up Person: </td>
    <td><?php echo $row['toBePickedBy']; ?></td>
  </tr>
  <tr>
    <td align="right">Pick Up Time: </td>
    <td><?php echo $row['pickUpTime']; ?></td>
  </tr>
  <tr>
    <td align="right">Other remarks/comments</td>
    <td><?php echo $row['otherRemarks']; ?></td>
  </tr>
</table>
        <?php
            if ($row['LMApproval']=='') {$approval="incomplete";$color="orange";}
            if ($row['LMApproval']=='pending') {$approval="pending";$color="#ffcc00";}
            if ($row['LMApproval']=='approved') {$approval="approved";$color="green";}
            if ($row['LMApproval']=='disapproved') {$approval="disapproved";$color="red";}
            ?>
            
        <p><div style='background:<?php echo $color; ?>; color: #ffffff; padding: 5px; float: left;' align=center><?php
            echo $approval;
            ?></div></p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo $msg; ?></p>
        <?php 
        } ?>
    </div>
</body>
</html>