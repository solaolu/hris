<?php
if(session_id() == '') session_start();
require_once('models.php');

class User extends Models
{
    public $url;
    public function login($user){
        $username = addslashes($user->username);
        $password = addslashes($user->password);
        
        $sql = "select a.*, b.fullname, c.theme, c.logo, c.handbook, c.name as companyName, companyID from users_tbl as a 
        left join staff_tbl as b on a.email=b.email
        left join company_tbl as c on b.companyID = c.ID
        where a.email='$username' and a.password=md5('$password')";
        
        
        
        $res = $this->db->getData($sql);
        
        if (count($res)){
            //update last access
            $this->result->isSuccessful=true;
            $this->result->object=$res[0];
            $this->result->code = $res[0]['isPasswordChanged'];
            //$now = date();
            $userid = $res[0]["ID"];
            //$this->result->message="update users_tbl set lastAccess=NOW() where ID=$userid";
            $this->db->execute("update users_tbl set lastAccess=NOW() where ID=$userid");
            $companyID=$res[0]['companyID'];
            //if ($companyID==8) $this->addLog($user);
            
            $this->setUserEnvironment($res[0]);
            
        } else {
            $this->result->message = "Incorrect username or password provided! Please check and retry.";
        }
        
    }
    
    public function addLog($user, $action=1) {
        unset($user->password);
        
        $user->loginTimestamp = date('Y-m-d H:i:s');
        $user->action = $action;
        $user = $this->getDeviceData($user);
        
        $res = $this->db->insert('loginLog_tbl', $user);
    }
    
    public function getDeviceData($user){
        if (isset($user->more_info)){
            $info = explode(':', $user->more_info);
            $user->longitude = $info[0];
            $user->latitude = $info[1];
            $user->deviceID = $info[2];
        }
        return $user;
    }
    
    public function dailyClockCount($user){
        $date = date('Y-m-d');
        $sql = "select ID from loginLog_tbl where username = '$user' and DATE_FORMAT(loginTimestamp, '%Y-%m-%d')='$date'";
        $clocks = $this->db->getData($sql);
        return count($clocks);
    }
    
    public function clockIn($data){
        //check registered device location, id
        //user, device, longitude, latitude, timestamp
        //check already clocked in for the day
        if ($this->dailyClockCount($data->username)==0)
        {
            $validOrigin = $this->validateOrigin($data);
            //var_dump($validOrigin);
            if ($validOrigin==3) {
                $this->addLog($data, 2);
                $this->result->isSuccessful = true;
            }
            else {
                $this->result->isSuccessful=false;
                $this->result->message = "Unable to clock-in, you are either using an invalid device or you are in a wrong location.";
                $this->result->code = $validOrigin;
            }
        } 
        else
        {
            $this->result->isSuccessful=false;
            $this->result->message = "You have already clocked-in today";
        }
    }
    
    public function clockOut($data){
        //check  registered device location, id, clock-in
        //user, device, longitude, latitude, timestamp
        $clocks=$this->dailyClockCount($data->username);
        if ($clocks==1)
        {
            $validOrigin = $this->validateOrigin($data);
            if ($validOrigin==3) {
                $this->addLog($data, 3);
                $this->result->isSuccessful = true;
            }
            else {
                $this->result->isSuccessful=false;
                $this->result->message = "Unable to clock-out, you are either using an invalid device or you are in a wrong location.";
                $this->result->code = $validOrigin;
            }
        }
        else
        {
            $this->result->isSuccessful=false;
            
            $this->result->message = $clocks>=2?"You have already clocked-out today.":"You haven't clocked-in today and therefore won't be allowed to clock-out";
        }
    }
    

    
    public function changePassword($data){
        
        $username = addslashes($data->username);
        $oldpassword = addslashes($data->oldpassword);
        $newpassword = addslashes($data->newpassword);
        
        $deviceReg = $this->checkAndRegisterDevice($data);
        
        $sql = "UPDATE `users_tbl` AS `new`, (SELECT ID FROM `users_tbl` WHERE email='$username' and password = md5('$oldpassword')) AS `old`
                SET `new`.`password` = md5('$newpassword'), new.lastAccess = NOW(), isPasswordChanged=1 $deviceReg 
                WHERE `new`.`id` = `old`.`ID`";
        
        $res = $this->db->execute($sql);
        
        if ($res){
            $this->result->isSuccessful=true;
            $this->result->message="Password updated";
            //if ()
        } else {
            $this->result->message="Update failed, no user with matching email and password.";
        }
        
    }
    
    public function checkAndRegisterDevice($data){
                //authenticate user with temp password, if user is a sales force staff and logging on for the first time, then register device (ID, coordinates)
        $regD = "";
        
        $username = addslashes($data->username);
        $oldpassword = addslashes($data->oldpassword);
        
        $sql = "select a.*, b.companyID from users_tbl as a 
        left join staff_tbl as b on a.email=b.email
        where a.email='$username' and a.password=md5('$oldpassword')";
        
        $res = $this->db->getData($sql);
        if (count($res)) {
            if ($res[0]['deviceRegistered']=='0'){
                
                $data = $this->getDeviceData($data);
                unset($data->oldpassword);
                unset($data->newpassword);
                unset($data->more_info);
                unset($data->cnewpassword);
                if ($this->db->insert("device_tbl", $data)) $regD = ", deviceRegistered=1"; 
            }
            
        }
        return $regD;
    }
    
    public function readHandbook($user){
        $user=addslashes($user);
        $sql="update users_tbl set agreedToHandbook=1 where email='$user'";
        
        $res=$this->db->execute($sql);
        if ($res){
            $this->result->isSuccessful=true;
            //update read handbook info in case there is a page refresh
            $user = $_SESSION["user__info"];
            $user['agreedToHandbook']=1;
            $_SESSION["user__info"]=$user;
        }
    }
    
    public function passwordReset($email){
        
    }
    
    public function setUserEnvironment($user){
        //use to direct to appropriate page;
        switch ($user['role']){
            case 1:
            case 2:
                $this->result->code = $user['isPasswordChanged']; //cause to stay on same page
                $url="app.php";
                if ($user['role']==2) {
                    $user['theme']=7;
                    $user['logo']="republicom.png";
                }
                break;
                
            case 3:
                //cause to stay on same page
                $url="hybrid.php";
                break;
        }
        //set session values;
        $_SESSION["user__info"]=$user;
        $_SESSION["user"]=$user['email'];
        $this->result->url = $url;
    }
    
    public function validateOrigin($data){
        /*  isValid:
            0 - Invalid, no registered device for user
            3 - Valid, registered device and within range
            2 - Invalid, device mismatch
            1 - Invalid, not within 1km location range
        */
        
        $isValid = 0;
        $deviceData = $this->getDeviceData($data);
        
        $sql = "select * from device_tbl where username='".$deviceData->username."'";
        $res = $this->db->getData($sql);
        if (count($res)){
             $isValid=3;
             if ($res[0]['deviceID']==$deviceData->deviceID){
                 $dist = $this->calculateDistance($res[0]['latitude'],$res[0]['longitude'], $deviceData->latitude, $deviceData->longitude);
                 $dist2 = $this->calculateDistance2($res[0]['latitude'],$res[0]['longitude'], $deviceData->latitude, $deviceData->longitude);
                // var_dump('radius: '.$dist.":".$dist2);
                 if ($dist>1) $isValid=1;
             }   
             else {
                 $isValid=2;
             }
        }
        
        
        return $isValid;
    }
    
    public function calculateDistance($lat1, $lon1, $lat2, $lon2) {
      $R = 6371; // km
      $dLat = $this->toRad($lat2 - $lat1);
      $dLon = $this->toRad($lon2 - $lon1); 
      $a = sin($dLat / 2) * sin($dLat / 2) +
              cos($this->toRad($lat1)) * cos($this->toRad($lat2)) * 
              sin($dLon / 2) * sin($dLon / 2); 
      $c = 2 * atan2(sqrt($a), sqrt(1 - $a)); 
      $d = $R * $c;
      return $d;
    }
    
    public function calculateDistance2($lat1, $lon1, $lat2, $lon2){
        $d=6371*acos(sin($lat1*pi()/180)*sin($lat2*pi()/180) + cos($lat1*pi()/180)*cos($lat2*pi()/180)*cos($lon2*pi()/180-$lon1*pi()/180));
        return $d;
    }
    
    public function toRad($a) {
        return $a * pi() / 180;
    }
    
}

?>
