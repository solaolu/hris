<?php
require_once('checkAdmin.php');
require_once('../Connections/cn.php');

include('paginate.php');
$msg="";
if (isset($_GET['MM_post']) && $_GET['MM_post']=="notify"){
    foreach($_POST as $request=>$suppliers){
        foreach($suppliers as $supplier=>$id){
            $notify=(Object) ["category"=>substr($request, 0, 4),"requestID"=>substr($request, 4), "supplierID"=>$id];
            
            //write to db
            /*$TBL=NULL;
            switch ($brieftype){
                case "EVEN":
                    $tbl = "eventRequest_tbl";
                    break;
                case "LOGI": 
                    $tbl="logisticsRequest_tbl";
                    break;
                case "LOGO": 
                    $tbl="logoRequest_tbl";
                    break;
                case "RESEA": 
                    $tbl="researchRequest_tbl";
                    break;
                case "DEEJ": 
                    $tbl="djRequest_tbl";
                    break;
                case "LIGH": 
                    $tbl="lightRequest_tbl";
                    break;
                case "PHOT": 
                    $tbl="photographyRequest_tbl";
                    break;
                case "VIDE": 
                    $tbl="videographyRequest_tbl";
                    break;
            }
            if (!is_null($tbl)) */
            
            $db->insert("supplierNotification_tbl", $notify);
        }
    }
    $msg="Notification has been sent to the selected Suppliers.";
}

$limit = 15;	
$page = isset($_GET['page']) ? mysqli_escape_string($cn, $_GET['page']):null;
if($page){
    $start = ($page - 1) * $limit; 
} else{
    $start = 0;	
}

$sql = "select a.ID, a.owner, a.requestDate, a.type, a.supplier1, a.supplier2, a.supplier3, b.fullname, c.supplierName as supplier1Name, d.supplierName as supplier2Name, e.supplierName as supplier3Name, f.quote as quote1, f.status as status1, g.quote as quote2, g.status as status2, h.quote as quote3, h.status as status3 from (select ID, owner, supplier1, supplier2, supplier3, requestDate, 'EVENT' as type from eventRequest_tbl union select ID, owner, supplier1, supplier2, supplier3, requestDate, 'LOGISTICS' as type from logisticsRequest_tbl union select ID, owner, supplier1, supplier2, supplier3, requestDate, 'LOGO' as type from logoRequest_tbl union select ID, owner, supplier1, supplier2, supplier3, requestDate, 'RESEARCH' as type from researchRequest_tbl union select ID, owner, supplier1, supplier2, supplier3, requestDate, 'DEEJAY' as type from djRequest_tbl union select ID, owner, supplier1, supplier2, supplier3, requestDate, 'LIGHTING' as type from lightRequest_tbl union select ID, owner, supplier1, supplier2, supplier3, requestDate, 'PHOTOGRAPHY' as type from photographyRequest_tbl union select ID, owner, supplier1, supplier2, supplier3, requestDate, 'VIDEOGRAPHY' as type from videographyRequest_tbl) as a left join staff_tbl as b on a.owner=b.email left join approvedSuppliers_tbl as c on a.supplier1=c.ID left join approvedSuppliers_tbl as d on a.supplier2=d.ID left join approvedSuppliers_tbl as e on a.supplier3=e.ID
left join supplierNotification_tbl as f on (f.category+'_'+f.requestID+'_'+f.supplierID)=(LEFT(a.type, 4)+'_'+a.ID+'_'+a.supplier1)
left join supplierNotification_tbl as g on (g.category+'_'+g.requestID+'_'+g.supplierID)=(LEFT(a.type, 4)+'_'+a.ID+'_'+a.supplier2)
left join supplierNotification_tbl as h on (h.category+'_'+h.requestID+'_'+h.supplierID)=(LEFT(a.type, 4)+'_'+a.ID+'_'+a.supplier3)
order by requestDate desc limit $start, $limit";


//var_dump($_POST);

$rows = $db->getData($sql);
$stages=3;
$targetpage="briefrequests.php";
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
    <div style="padding: 30px;" >
<?php
if (count($rows))
{
?>
<h3>SUPPORT BRIEFS</h3>
<p><strong><?php echo $msg; ?></strong></p>
<form method="post" action="?MM_post=notify&page=<?php echo $page?>">
<table cellpadding=5 cellspacing=1 bgcolor="#cccccc" border=0 >
<thead>
    <tr>
        <th></th>
        <th>Requester</th>
        <th>Brief Type</th>
        <th>Preferred Supplier 1</th>
        <th>Preferred Supplier 2</th>
        <th>Preferred Supplier 3</th>
        <th>Request Date</th>
    </tr>
</thead>
<tbody>
    <?php $i=1;foreach($rows as $row){ ?>
    <tr bgcolor="#fff">
        <td><?php echo $i; ?></td>
        <td><?php echo $row['fullname']; ?></td>
        <td><?php echo $row['type']; ?></td>
        <td><?php if (!is_null($row['supplier1Name'])) { 
            if (is_null($row['status1'])){
            ?>
            <label><input  name="<?php echo substr($row['type'],0, 4).$row['ID']; ?>[]" type="checkbox" value="<?php echo $row['supplier1']; ?>">&nbsp;<?php echo $row['supplier1Name']; ?></label>
            <?php } else {
                ?>
                <?php echo $row['supplier1Name']; ?>
            <?php
                }
            } ?>
        </td>
        <td><?php if (!is_null($row['supplier2Name'])) { 
            if (is_null($row['status2'])){
            ?>
            <label><input  name="<?php echo substr($row['type'],0, 4).$row['ID']; ?>[]" type="checkbox" value="<?php echo $row['supplier2']; ?>">&nbsp;<?php echo $row['supplier2Name']; ?></label>
            <?php } else {
                ?>
                <?php echo $row['supplier2Name']; ?>
            <?php
                }
            } ?>
        </td>
        <td><?php if (!is_null($row['supplier3Name'])) { 
            if (is_null($row['status3'])){
            ?>
            <label><input  name="<?php echo substr($row['type'],0, 4).$row['ID']; ?>[]" type="checkbox" value="<?php echo $row['supplier3']; ?>">&nbsp;<?php echo $row['supplier3Name']; ?></label>
            <?php } else {
                ?>
                <?php echo $row['supplier3Name']; ?>
            <?php
                }
            } ?>
        </td>
        <td><?php echo $row['requestDate']; ?></td>
        <td><a href="#">View</a></td>
        <td>
            <input class="select-row" type="checkbox" value="" />
        </td>
    </tr>
    <?php 
        $i++;                        
        }?>
    <tr>
        <td colspan="7"><input type="submit" value="Request for Quote" /></td>
        <td align="right" colspan="2"><label><input id="checkAll" type="checkbox" />Select All</label></td>
    </tr>
    <tr>
        <td colspan="9" align=center>
    <?php echo "<div>".$paginate."</div>"; ?>  </td>
    </tr>
</tbody>
</table> 
</form> 
    <p>&nbsp;</p>
<?php
} else {
    echo "No requests found!";
}
?>
    </div>
    <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script>
        $('.select-row').click(function(){
            if ($(this).is(":checked")) {
                $(this).parents('tr').find("input[type='checkbox']").prop("checked", true);
            } else {
                $(this).parents('tr').find("input[type='checkbox']").prop("checked", false);
            }
        });
        
        $('#checkAll').click(function(){
            if ($(this).is(":checked")) {
                $(this).parents('table').find("input[type='checkbox']").prop("checked", true);
            } else {
                $(this).parents('table').find("input[type='checkbox']").prop("checked", false);
            }
        });
    </script>
</body>
</html>


