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
        $rs=mysqli_query($cn, "select * from inventoryRequests_tbl where ID=$id") or die(mysqli_error($cn));
        if (!mysqli_num_rows($rs)) {
            echo "<p>Invalid Record</p>";
            } else {
        $row=mysqli_fetch_assoc($rs);
        ?>
        <table><tr><td valign=top>
        <table cellspacing="0" cellpadding="5">
  <tr>
    <td align="right">Project Name: </td>
    <td><?php echo $row['projectName']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">Item(s) Requested:</td>
    <td valign="top">
     <?php
        $sql = "select a.ID, a.requestBatchID, a.itemID, a.itemQty, a.itemExpectedReturnDate, a.itemReturnStatus,
        b.itemName from inventoryRequestItems_tbl as a
        left join inventory_tbl as b on a.itemID = b.ID
        where a.requestBatchID=$id";
            //echo $sql;
            $r=mysqli_query($cn, $sql);
     ?>
     <table cellspacing="0" cellpadding="5" border=1 bordercolor="#000000">
      <tr>
        <td>Inventory Item</td>
        <td>Quantity</td>
        <td>Expected Return Date</td>
        <td>Return Status</td>
        <td colspan="2" align="center">Set Item Status</td>
      </tr>
      <?php
      while ($row_r=mysqli_fetch_assoc($r)) {
      ?>
      <tr>
        <td><?php echo $row_r['itemName']; ?></td>
        <td><?php echo $row_r['itemQty']; ?></td>
        <td><?php echo $row_r['itemExpectedReturnDate']; ?></td>
        <td><?php switch ($row_r['itemReturnStatus'])
      {
          case 0:
              echo "Not collected";
              break;
          case 1:
              echo "Collected";
              break;
          case 2:
              echo "Returned";
              break;
      }?></td>
          <td><a href="inventoryitemprocess.php?i=<?php echo $row_r['ID']; ?>&m=1&b=<?php echo $id; ?>">Mark as Collected</a></td>
          <td><a href="inventoryitemprocess.php?i=<?php echo $row_r['ID']; ?>&m=2&b=<?php echo $id; ?>">Mark as Returned</a></td>
      </tr>
      <?php } ?>
    
    
    
  
    </table>
    <p><a href="inventoryitemprocess.php?i=-1&m=1&b=<?php echo $id; ?>">Mark all Items as Collected</a> | <a href="inventoryitemprocess.php?i=-1&m=2&b=<?php echo $id; ?>">Mark all Items as Returned</a></p>
       
    </td>
  </tr>
  <!--<tr>
    <td align="right">Duration: </td>
    <td><?php //echo $row['duration']; ?></td>
  </tr>-->
  <tr>
    <td align="right">Collection By: </td>
    <td><?php echo $row['collectionBy']; ?></td>
  </tr>
  <tr>
    <td align="right">Pick Up Time: </td>
    <td><?php echo $row['collectionTime']; ?></td>
  </tr>
  <tr>
      <td></td>
      <td>
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
            
        <p><div style='background:<?php echo $color; ?>; color: #ffffff; padding: 5px; float: left;' align=center><?php
            echo strtoupper($approval);
            ?></div></p>
      </td>
  </tr>
  <tr><td colspan=2>
  <hr size=1 />
  </td></tr>
  <tr>
                <td>&nbsp;</td>
                <td>
                
                </td>
  </tr>
</table>
        </td>
        <td>&nbsp;</td>
        <td valign=top>
        <p><strong>Status or Comments on received/returned items</strong></p>
       <p>
       <form id="commentForm">
       <input type="hidden" name="tblID" value="1" />
       <input type="hidden" name="rowID" value="<?php echo $id; ?>" />

       <input type="hidden" name="MM_Post" value="Post" />
       <textarea name="comment" rows="8" cols="80"></textarea>    
       </form>
       </p>
       <p><strong><a class="add-comment" href="#">Add Comment</a></strong></p>
    <hr size=1 />
      <div class="comments">
        <?php $rs1=mysqli_query($cn, "select * from comments_tbl where rowID=$id and tblID=1 order by id desc") or die(mysqli_error($cn));
        if (!mysqli_num_rows($rs1)) {

        } else {
          while($row1=mysqli_fetch_assoc($rs1)){
          ?>
          <div style='background-color: #efefef; padding: 8px; margin-bottom:2px'><?php echo $row1['comment']; ?></div>
          <?php }
        }?>
      </div>
        </td></tr>
        </table>
  
        
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>
        <?php
        /*if ($approval=="approved") 
        if ($row['released']==0) { ?>
        <a class="button" href="inventoryaction.php?a=release&id=<?php echo $id; ?>">Release Requested Items</a>
        <?php } else { ?>
        <a class="button" href="inventoryaction.php?a=restore&id=<?php echo $id; ?>" >Restore Items</a>
        <?php }*/ ?>
        </p>
        <?php 
        }  ?>
    </div>
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script>
      $('.add-comment').click(function(){
        $.post('addComment.php', $('#commentForm').serialize(), function(resp){
            $('.comments').prepend(resp);
            $('textarea[name=comment]').html();
        });
      });
    </script>
</body>
</html>