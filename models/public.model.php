<?php

require_once('models.php');
require_once('../classes/workflow.php');

class JobApplication extends Models
{
    
    private $fld;
    
    public function apply($applicant) {
        
        $education = $applicant->educationalInfo;
        $references = $applicant->referenceInfo;
        $experience = $applicant->workExperience;

        unset($applicant->educationalInfo);
        unset($applicant->referenceInfo);
        unset($applicant->workExperience);
        
        $this->db->connectPublic();
        $id = $this->db->insert("biodata_tbl", $applicant);
        
        if ($id) {
            $this->addDetails("educationalInfo_tbl", $education, $id);
            $this->addDetails("references_tbl", $references, $id);
            $this->addDetails("workExperience_tbl", $experience, $id);
        
            //send mail or notify procurement???
            
            $this->result->isSuccessful = true;
            $this->result->message = "Details submitted successfully.";

            //notify procurement

          //  $wf = new Workflow();
          //    $wf->start(0,0,"Supplier",null, -1, $supplier);
        }
    }
    
    /*public function addBanks($banks, $supplierID){}
    public function addCapabilities($capabilities, $supplierID){}
    public function addSales($sales, $supplierID){}
    public function addExperience($experiences, $supplierID){}*/
    
    public function addDetails($table, $data, $applicantID) {
        foreach ($data as $row){
            $row->applicantID = $applicantID; 
            $this->db->insert($table, $row);
        }
    }
    

}


?>