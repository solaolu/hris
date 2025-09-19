<?php 

require_once('../models/models.php');
require_once('../models/staff.php');

class Performance extends Models
{

    public function getPerformanceTasks($user, $mth, $yr, $self){
       $owner="";
       $adverb="already";
       $sql = "select a.ID, a.kpiID, a.task, a.weight, a.rating, b.initiative from performanceTasks_tbl as a left join scorecard_tbl as b on a.kpiID=b.ID where owner='$user' and period_mth=$mth and period_yr=$yr and (a.rating=0 or a.rating IS NULL)";
       //echo $sql;
       $msg = "Please complete your ratings for this staff";
       $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
       $month = $months[$mth-1];
       
       if ($self){
        $owner="your";
        $adverb = "not";
        
        $msg = "Your rating for $month-$yr is shown below";
        $sql = "select a.ID, a.kpiID, a.task, a.weight, a.rating, b.initiative from performanceTasks_tbl as a left join scorecard_tbl as b on a.kpiID=b.ID where owner='$user' and period_mth=$mth and period_yr=$yr and (a.rating<>0 or a.rating IS NOT NULL)";
        $sql2 = "select SUM(a.weight * a.rating) as score from performanceTasks_tbl as a left join scorecard_tbl as b on a.kpiID=b.ID where owner='$user' and period_mth=$mth and period_yr=$yr and (a.rating<>0 or a.rating IS NOT NULL)";
    } 

       $res = $this->db->getData($sql);

       if (count($res)){
            $this->result->isSuccessful = true;
            $this->result->object = $res; //_group_by($res, "initiative");
            $this->result->owner = $user;
            $this->result->period = $mth.$yr;

            $res2 = $this->db->getData($sql2);

            $this->result->score = $res2[0]['score'];
            $this->result->message = $msg;
        } else {
            $this->result->isSuccessful = false;
            $this->result->message = "Unable to fetch $owner performance tracker for $month-$yr. It either does not exist or has $adverb been completed.";
        }
    }

    function evaluate($data){
        $sql = "select ID from performanceTasks_tbl where owner='$data->owner' and CONCAT(period_mth, period_yr)='$data->period'";
            $res = $this->db->getData($sql);
            
            //$this->db->execute("update kpi_details_tbl set isDeleted=1  where kpiSummaryID=$data->kpiSummaryID ");
            $result=1;
            $insertValues='';
            for ($i=0;$i<count($res);$i++){
                $key = "kpiRating".$res[$i]["ID"];
                //$score = $res[$i]["weight"] * $data->{$key};
                $updateQuery = "update performanceTasks_tbl set rating=".$data->{$key}." where ID=".$res[$i]["ID"];
                $result *= $this->db->execute($updateQuery);
             // $insertValues .= "('".$data->owner."', '".$data->kpiSummaryID."','".$data->period."',".$res[$i]["ID"].",".$score."),"; 
            }

            if ($result) {
                $this->result->isSuccessful = true;
                $this->result->message = "Performance has been saved successfully!";
            }
            
    }

    function _group_by($array, $key) {
        $return = array();
        $rows = array();
        foreach($array as $val) {
            //$row["row"][]=;
            $return[$val[$key]][] = $val;
        }
        
        //convert grouped cols to array
        $i=0;
        foreach ($return as $key => $value){
            $rows[$i]["id"] = $i;
            $rows[$i]["section"] = $key;
            $rows[$i]["detail"] = $value;
            $i++;
        }
        
        return $rows;
    }
}

?>