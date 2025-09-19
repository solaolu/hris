<?php
require_once("models.php");

class Staff extends Models
{
    
    public function getAll(){
        $companyID = $_SESSION["user__info"]['companyID'];
        $sql = "select fullname as staffname, email from staff_tbl where companyID=$companyID";
        $res = $this->db->getData($sql);
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        }
    }
    
    public function subordinates($user){
        $sql="select fullname, email from staff_tbl where linemgremail='$user'";
        $res = $this->db->getData($sql);
        
        if (count($res)){
            $this->result->isSuccessful = true;
            $this->result->object = $res;
            $this->result->message = $sql;
        }


        $this->result->message = $sql;
    }
    
    public function profile($user, $full=null){
        if ($full==null){
            $sql = "select email, employeeID, firstname, lastname, middlename, dob, phonenumber, CONCAT(homeAddress, ' ', homeCity, ' ', homeState) as address, CONCAT('Name: ', nokName1, '\nAddress: ',nokAddress1, '\nPhone Number: ',nokPhone1) as nokInfo  from employeeProfile_tbl where email='$user'";
            //$sql = "select * from employeeProfile_tbl where email='$user'";
        } else {
            $sql = "select * from employeeProfile_tbl where email='$user'";
        }
        
        $res = $this->db->getData($sql);
        if (count($res)){
            $this->result->isSuccessful = true;
            $profile = $res[0];
            $sql = "select * from dependentProfile_tbl where parentEmail='$user'";
            $res_d = $this->db->getData($sql);
            
            if (count($res_d)) $profile['dependents'] = $res_d;
            
            $_SESSION['profile']=$profile;
            $this->result->object = $profile;
        }
    }
    
    public function editProfile($user){
        //$this->profile($user, true);
    }
    
    public function save($profile){
        $dependents = $profile->dependents;
        
        //add dependents;
        foreach($dependents as $dependent){
            $dependent->parentEmail = $profile->email;
            $this->db->insert("dependentProfile_tbl", $dependent);
        }
        
        unset($profile->dependents);
        $res = $this->db->insert("employeeProfile_tbl", $profile);
        
        if ($res){
            $this->result->isSuccessful=true;
            $this->result->message = "Your profile has been saved!";
        }
        
    }
    
    public function update($profile){
        $user = $_SESSION['user'];
        $dependents = $profile->dependents;
        unset($profile->dependents);
        $res = $this->db->update("employeeProfile_tbl",$profile,"email='$user'");
        if ($res===TRUE){
            
            $this->result->isSuccessful=true;
            $this->result->message = "Your profile changes have been saved!";
        }
    }
    
    public function updateDependent($profile){
        $user = $_SESSION['user'];
        $ID = $profile->ID;
        unset($profile->ID);
        $res = $this->db->update("dependentProfile_tbl",$profile,"parentEmail='$user' and ID=$ID");
        if ($res===TRUE){
            
            $this->result->isSuccessful=true;
            $this->result->message = "Dependent profile changes have been saved!";
        }
    }
    
    public function detachDependent($ID, $user){
        $sql = "delete from dependentProfile_tbl where ID=$ID and parentEmail='$user'";
        $this->db->execute($sql);
        $this->result->isSuccessful = false;
        $this->result->message = 'Dependent has been deleted from your profile';
    }
    
    public function jobInfo($user){
        $sql = "select a.*, b.jobtitle, b.sc_code from staff_tbl as a left join(jobs_tbl as b) on (a.jobcode=b.jobcode) where a.email='$user' limit 1";
        $res = $this->db->getData($sql);
        
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->object = $res;
        }
    }

    public function fullname($user){
        $sql = "select fullname from staff_tbl where email='$user' limit 1";
        $res = $this->db->getData($sql);
        return $res[0]['fullname'];
    }

    public function scCode($user){
        $sql = "select b.sc_code from staff_tbl as a left join(jobs_tbl as b) on (a.jobcode=b.jobcode) where a.email='$user' limit 1";
        $res = $this->db->getData($sql);
        
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->code = $res[0]['sc_code'];
            
        }
    }  
    
    public function jobCode($user){
        $sql = "select jobcode from staff_tbl where email='$user' limit 1";
        $res = $this->db->getData($sql);
        
        if ($res){
            $this->result->isSuccessful = true;
            $this->result->code = $res[0]['jobcode'];
            
        } 
    }
    
    public function sslcProfile($profile){
     $res = $this->db->insert('sslc_profile_tbl', $profile);
        
        if ($res) {
            
            $this->result->isSuccessful=true;
            $this->result->message = "Your profile has been saved!";
        }
    }

    
}