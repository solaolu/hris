<?php
namespace Entity;

class Payslips
{
	public $grossPay;
	public $totalIncome;
	public $totalDeductions;
	public $incomes; //expects object or array
	public $deductions; //expects object or array
	public $fullname;
    public $jobtitle;
    public $date;
	
	private function getTotalIncome(){
		$sum = 0;
		foreach ($this->incomes as $income){
			$sum += $income['amount'];
		}
		$this->totalIncome = $sum; 
	}
	
	private function getTotalDeductions(){
		$sum = 0;
		foreach ($this->deductions as $deduction){
			$sum += $deduction['amount'];
		}
		$this->totalDeductions = $sum;
	}
	
	public function process(){
		$this->getTotalDeductions();
		$this->getTotalIncome();
		$this->grossPay = number_format(($this->totalIncome - $this->totalDeductions)/12, 2, '.', ',');
	}
}
?>