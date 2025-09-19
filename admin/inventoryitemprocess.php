<?php
require_once("../Connections/cn.php");
require_once("../models/inventory.php");

try
{
    $item = $_GET['i'];
    if (!is_nan($item)){
        $m = $_GET['m'];
        if ($m==1 || $m==2) {
        $batch = $_GET['b'];
        if ($item<0){
            
            $sql = "update inventoryRequestItems_tbl set itemReturnStatus=$m";
            if ($m==1) $sql.=", itemReturnedDate=NOW()";
            $sql.=" where requestBatchID=$batch";
            returnItemstoStore($batch, 0);
        } else {
            $sql = "update inventoryRequestItems_tbl set itemReturnStatus=$m";
            if ($m==1) {
                $sql.=", itemReturnedDate=NOW()";
            }
            $sql.=" where ID=$item";
            returnItemstoStore(0, $item);
        }
            $db->execute($sql);
            updateRequest($batch);
            header("location: showinventoryrequest.php?id=$batch");
        }
    }
    
} catch (Exception $ex) {
    echo $ex;
}

function updateRequest($batch){
    global $db;
    $sql1 = "select SUM(itemReturnStatus) as sum, count(requestBatchID) as count from inventoryRequestItems_tbl where requestBatchID=$batch group by requestBatchID ";
    
    //echo $sql1;
    $row = $db->getData($sql1);
    if ($row[0]['sum'] == 2*$row[0]['count']){
        $sql2="update inventoryRequests_tbl set requestStatus=2 where ID=$batch";
    } else {
        $sql2="update inventoryRequests_tbl set requestStatus=1 where ID=$batch";
    }
    $db->execute($sql2);
}

function returnItemstoStore($batchID, $item){
    global $db;
    $inv = new Inventory();
    
    if ($batchID==0){
        $sql = "select itemID, itemQty from inventoryRequestItems_tbl where ID=$item";
    } else {
        $sql = "select itemID, itemQty from inventoryRequestItems_tbl where requestBatchID=$itemID";
    }
        
        $rows = $db->getData($sql);
        
        foreach($rows as $row){
            
            $inv->returnItems($row['itemID'], $row['itemQty']);
        }
}

?>