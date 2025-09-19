<?php

require_once('models.php');
require_once('../classes/workflow.php');

class Inventory extends Models
{
    
    private $item;
    
    public function getItems(){
        $sql = "select * from inventory_tbl where itemInStore>0";
        $res=$this->db->getData($sql);
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        }
    }
    
    public function removeItems($itemID, $number){
        $sql = "select * from inventory_tbl where ID=$itemID";
        $res = $this->db->getData($sql);
        
        if (count($res)){
            $this->item=$res[0]['itemName'];
            if ($res[0]['itemInStore']>=$number){
                //proceed with updating inventory
                $sql = "update inventory_tbl set itemInStore=(itemInStore - $number), itemInTransit=(itemInTransit + $number), lastUpdated=NOW() where ID=$itemID";
                $res = $this->db->execute($sql);
                return true;
                
            } else
            {
                return false;
            }
        } else {
            //throw error
            return false;
        }
    }
    
    public function returnItems($itemID, $number){
        $sql = "select * from inventory_tbl where ID=$itemID";
        $res = $this->db->getData($sql);
        
        if (count($res)){
            $this->item=$res[0]['itemName'];
            if ($res[0]['itemInTransit']>=$number){
                //proceed with updating inventory
                $sql = "update inventory_tbl set itemInStore=(itemInStore + $number), itemInTransit=(itemInTransit - $number), lastUpdated=NOW() where ID=$itemID";
                $res = $this->db->execute($sql);
                return true;
                
            }
            else {
                return false;
            }
        } else {
            //throw error
            return false;
        }
    }
    
    public function newRequest($request){
        $items = $request->items;
        unset($request->items);
        $status = true;
        
        $batchID = $this->db->insert("inventoryRequests_tbl", $request);
        if ($batchID){
            foreach($items as $item){
                $item->requestBatchID = $batchID;
                if ($this->removeItems($item->itemID, $item->itemQty)) {
                    $this->db->insert("inventoryRequestItems_tbl", $item);
                    $status&=true;
                } else {
                    $message = "unable to place order for item - $this->item"; //todo: modify the remove and return methods to return the item name to the private variable item, return errors as array of items.
                    $status&=false;
                }
            }
            $this->result->isSuccessful=true;
            $wf = new Workflow();
            $wf->start(0,0,"Inventory",$request->owner, -1, $request);

            if (!$status)
                $this->result->message = "Request submitted but one or more items required failed to book succesfully.";
            else
                $this->result->message = "Request submitted successfully and items required booked";
            
        } else {
            $this->result->message = "Failed to book your request, please retry!";
        }
    }
    
    
}

?>