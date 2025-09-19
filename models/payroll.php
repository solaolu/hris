<?php

use Entity\Payslips as Payslips;
use Entity\Result as Result;

require_once("../classes/dao.php");
require_once("../entities/Payslips.php");
require_once('../models/staff.php');
require_once("../entities/Result.php");

class Payroll {

    private $db;
    private $result;
	
    public function __construct(){
            $this->db = new DAO();
            $this->result = new Result;
    }
	
	public function getIncomes($jobcode, $date){
		/*$iIDs = explode(",", $incomes);
		foreach($iIDs as $key => $val){
			$sql = "select * from payroll_incomes_tbl where incomeID=$val";
		}
		*/
		
		$sql = "select a.*, b.incomeName from payroll_tbl as a left join payroll_incomes_tbl as b on a.payTypeID = b.ID where a.jobCode='$jobcode' and a.payType=1 and a.payslipDate='$date'";
		$incomes = $this->db->getData($sql);
		/*if ($incomes){
			$this->result->isSuccessful=true;
			$this->result->object = $incomes;
		}*/
		return $incomes;
	}
	
	public function getDeductions($jobcode, $date){
		//$sql = "";
		$sql = "select a.*, b.deductionName from payroll_tbl as a left join payroll_deductions_tbl as b on a.payTypeID = b.ID where a.jobCode='$jobcode' and a.payType=2 and a.payslipDate='$date'";
		$deductions = $this->db->getData($sql);
		/*if ($deductions){
			$this->result->isSuccessful=true;
			$this->result->object = $deductions;
		}*/
		return $deductions;
	}

	public function getLatestPayrollDate($owner){
		$payrollDate=0;
		$sql = "select distinct a.payslipDate from payroll_tbl as a left join staff_tbl as b on a.jobCode=b.jobCode where b.email='$owner' order by payslipDate desc limit 1";
		$date = $this->db->getData($sql);
		if ($date){
			$payrollDate = $date[0]['payslipDate'];
		}

		return $payrollDate;
	}
	
	public function getPayslip($owner, $date){
		$payslip = new Payslips;
		$sql = "select a.jobcode, a.fullname, b.jobtitle from staff_tbl as a left join jobs_tbl as b on a.jobcode=b.jobcode where a.email='$owner' limit 1";
		$rs = $this->db->getData($sql);
		
		if ($date==0){
			$date=$this->getLatestPayrollDate($owner);
		}

		if ($rs && $date!=0){
			$jobcode = $rs[0]["jobcode"];
			$payslip->fullname = $rs[0]["fullname"];
            $payslip->jobtitle = $rs[0]["jobtitle"];
			$payslip->incomes = $this->getIncomes($jobcode, $date);
			$payslip->deductions = $this->getDeductions($jobcode, $date);
            $payslip->date = date_format(date_create($date), "d-M-Y");
			$payslip->process();
			
			$this->result->isSuccessful = true;
			$this->result->object = $payslip;
			
		} else {
			$this->result->isSuccessful=false;
			$this->result->code=$date;
			$this->result->message = "An error occurred! Unable to complete this request because valid payroll data for this staff does not exist. Please contact HR to check and fix.";
		}
		
	}

	public function archives($owner){
		
			$sql = "select distinct a.payslipDate, date_format(a.payslipDate, '%M %Y') as date from payroll_tbl as a left join staff_tbl as b on a.jobcode=b.jobCode where b.email='$owner' and a.isDeleted=0";
			$rs = $this->db->getData($sql);
			if ($rs){
				$this->result->isSuccessful=true;
				$this->result->object=$rs;
			} else {
				$this->result->message = "No payslip found in archives";
			}

		
	}
    
    public function requestPayslip($user, $data)
    {
        $data->requestDate = date('Y-m-d H:i:s');
        $data->user = $user;
        $res = $this->db->insert("payslipRequest_tbl", $data);
        if ($res) {
            $this->result->isSuccessful=true;
            $this->result->message = "Your request has been sent and would be processed by the HR Administrator in charge.";
        }
    }
    
        public function getResult(){
            return $this->result;
        }
}
	
?>