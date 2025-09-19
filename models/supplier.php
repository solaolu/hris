<?php

require_once('models.php');
require_once('../classes/workflow.php');

class Supplier extends Models
{
    
    private $fld;
    
    public function register($supplier){
        $banks = $supplier->banks;
        $capabilities = $supplier->capability;
        $sales = $supplier->sales;
        $experiences = $supplier->experience;

        unset($supplier->banks);
        unset($supplier->capability);
        unset($supplier->sales);
        unset($supplier->experience);
        
        $id = $this->db->insert("supplier_tbl", $supplier);
        
        if ($id) {
            $this->addDetails("supplierBanks_tbl", $banks, $id);
            $this->addDetails("supplierCapability_tbl", $capabilities, $id);
            $this->addDetails("supplierSales_tbl", $sales, $id);
            $this->addDetails("supplierExperience_tbl", $experiences, $id);
        
            //send mail or notify procurement???
            
            $this->result->isSuccessful = true;
            $this->result->message = "Details submitted successfully.";

            //notify procurement

            $wf = new Workflow();
            $wf->start(0,0,"Supplier",null, -1, $supplier);
        }
        
    }
    
    /*public function addBanks($banks, $supplierID){}
    public function addCapabilities($capabilities, $supplierID){}
    public function addSales($sales, $supplierID){}
    public function addExperience($experiences, $supplierID){}*/
    
    public function addDetails($table, $data, $supplierID){
        foreach ($data as $row){
            $row->supplierID = $supplierID; 
            $this->db->insert($table, $row);
        }
    }
    
    public function certify(){
        
    }
    
    public function details($id){
        $sql = "select * from supplier_tbl where ID=$id";
        $res = $this->getData($sql);
        
        if (count($res)){
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        }
    }
    
    public function notify(){}
    
    public function getSupplierByCategory($cat){
        $sql="select supplierName, ID from approvedSuppliers_tbl where UPPER(category)=UPPER('$cat')";
        $rows=$this->db->getData($sql);
        return $rows;
    }
    
    public function submitBrief($data, $brieftype){
        $suppliers=explode(",", $data->supplier1);
        
        $data->supplier1 = $suppliers[0];
        $recipients = $this->getSupplierEmailByID($suppliers[0]);
        if (count($suppliers) >1 ){
            $data->supplier2 = $suppliers[1];
            $recipients = $recipients.", ".$this->getSupplierEmailByID($suppliers[1]);
            if (count($suppliers)>2){
                $data->supplier3 = $suppliers[2];
                $recipients = $recipients.", ".$this->getSupplierEmailByID($suppliers[2]);
            }
        }
        
        switch ($brieftype){
            case "eventsBrief":
                $tbl = "eventRequest_tbl";
                break;
            case "logisticsBrief": 
                $tbl="logisticsRequest_tbl";
                break;
            case "logoBrief": 
                $tbl="logoRequest_tbl";
                break;
            case "rsBrief": 
                $tbl="researchRequest_tbl";
                break;
            case "djBrief": 
                $tbl="djRequest_tbl";
                break;
            case "lightBrief": 
                $tbl="lightRequest_tbl";
                break;
            case "photographyBrief": 
                $tbl="photographyRequest_tbl";
                break;
            case "videographyBrief": 
                $tbl="videographyRequest_tbl";
                break;
        }

        $data->requestDate=date('Y-m-d H:i:s');
        $res = $this->db->insert($tbl, $data);
        
        if ($res) {
            $this->result->isSuccessful = true;
            $this->result->message = "Your brief has been successfully submitted";

            //notify suppliers of brief
            $wf = new Workflow();
            $wf->start(0, 0, "Briefs", $data->owner, -1, $data, $recipients);

        }
    }

    private function getSupplierEmailByID($id){
        $id=0;
        $sql="select a.companyEmail, b.ID  from supplier_tbl as a
        left join approvedSuppliers_tbl as b on a.ID=b.supplierID
        where b.ID=$id";
        //echo $sql;
        $res=$this->db->getData($sql);
        if (count($res)){
            $id = $res[0]['companyEmail'];
        }
        return $email;
    }
    
    private function getSupplierIDByEmail($supplier){
        $id=0;
        $sql="select a.companyEmail, b.ID  from supplier_tbl as a
        left join approvedSuppliers_tbl as b on a.ID=b.supplierID
        where a.companyEmail='$supplier'";
        //echo $sql;
        $res=$this->db->getData($sql);
        if (count($res)){
            $id = $res[0]['ID'];
        }
        return $id;
    }
    
    public function getNotificationBrief($supplier){
        
        $supplier_id=$this->getSupplierIDByEmail($supplier);
        if ($supplier_id){
          $sql = "select a.* from supplierNotification_tbl as a
            where a.supplierID=$supplier_id and a.status=0 order by id desc";  
            
            $res = $this->db->getData($sql);
            $rows=[];
            if (count($res)){
                foreach($res as $notification){
                    $query=$this->buildSQL($notification['category']);
                    $sql2="select a.*,".$this->fld." from supplierNotification_tbl as a
                            left join $query as b on a.requestID=b.ID
                            where a.supplierID=$supplier_id and a.status=0"; 
                    $res2=$this->db->getData($sql2);
                    $rows=array_merge($rows, $res2);
                }
                
                if (count($rows)){
                    $this->result->isSuccessful=true;
                    $this->result->object = $rows;
                }
            } else {
                $this->result->message = "No brief received!";
            }
            
        } else {
            $this->result->message = "Supplier does not exist $supplier_id $supplier";
        }
        
    }
    
    private function buildSQL($brieftype){
        $sql = null;
        $this->fld=" b.ProjectName, b.EventDate ";
                        switch ($brieftype){
                            case "EVEN":
                                $sql = "eventRequest_tbl";
                                $this->fld="b.what as ProjectName, b.when as EventDate ";
                                break;
                            case "LOGI": 
                                $sql="logisticsRequest_tbl";
                                break;
                            case "LOGO": 
                                $sql="logoRequest_tbl";
                                $this->fld="b.Name as ProjectName, '' as EventDate";
                                break;
                            case "RESE": 
                                $sql="researchRequest_tbl";
                                break;
                            case "DEEJ": 
                                $sql="djRequest_tbl";
                                break;
                            case "LIGH": 
                                $sql="lightRequest_tbl";
                                break;
                            case "PHOT": 
                                $sql="photographyRequest_tbl";
                                break;
                            case "VIDE": 
                                $sql="videographyRequest_tbl";
                                break;
                        }
        return $sql;
    }
    
    private function getTableByShortCode($brieftype){
        $tbl=NULL;
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
                            case "RESE": 
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
        return $tbl;
    }
    
    public function submitQuote($data){
        $sql="update supplierNotification_tbl set comment='".$data->comment."', quote='".$data->quote."', status=1 where ID=".$data->ID;
        $res = $this->db->execute($sql);
        
        if ($res){
            $this->result->isSuccessful=true;
            $this->result->message="Your quotation for the brief has submitted successfully.";

            //notify procurement
            $wf = new Workflow();
            $wf->start(0,7,"Briefs", null, 2, $data);
        }
    }
}


?>