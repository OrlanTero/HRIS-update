<?php

namespace Application\models;

class LoanAnalyzer
{

    public $loanEmployees;
    
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->loanEmployees  = $this->getAllEmployeesHaveLoan();
    }

    public function get()
    {
        $records = [];

        foreach ($this->loanEmployees as $data) {
            $employee = $data['employee'];
            $loans = $data['loans'];
            $payments = $data['payments'];

            $lastLoan = count($loans) > 0 ? $loans[0] : null;
            $balance = $this->GetOverAllLoanBalanceOfEmployee($employee->employee_id);

//
            $principal =  $lastLoan ?  $lastLoan->amount : 0;
            $lastBalance = $lastLoan ?  $lastLoan->balance : 0;
            $lastPayment = $lastLoan ? $principal - $lastBalance : 0;
            $amountReceived = $balance > 0 ? -$balance : 0;
            $forwardBalance = 0;
//
            $loanAnalyzed = new LoanAnalyzed($employee);
//
            $loanAnalyzed->setLoanId($lastLoan->loan_id);
            $loanAnalyzed->setEmployee($employee->name);
            $loanAnalyzed->setPrincipal($principal);
            $loanAnalyzed->setPrevious($balance);
            $loanAnalyzed->setBalance($lastBalance  );
            $loanAnalyzed->setPayments($lastPayment);
            $loanAnalyzed->setRecieved($amountReceived);
            $loanAnalyzed->setForward($forwardBalance);
            $loanAnalyzed->setDescription($lastLoan->description);
            $loanAnalyzed->setDate($lastLoan->date_created);
            $loanAnalyzed->setTimes(count($loans));

            $records[] = $loanAnalyzed;
        }

        return $records;
    }

    public function GetOverAllLoanBalanceOfEmployee($id)
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->LOAN_CONTROL;
        $paymentControl = $APPLICATION->FUNCTIONS->LOAN_PAYMENT_CONTROL;

        try {

            $overallLoan = array_reduce(array_column($control->filterRecords(['employee_id' => $id],false), 'balance'), function($a, $b) {
                $a += $b;
                return $a;
            });

            $overallPayment = array_reduce(array_column($paymentControl->filterRecords(['employee_id' => $id], false), 'amount'), function($a, $b) {
                $a += $b;
                return $a;
            });


            return $overallLoan - $overallPayment;
        } catch (Exception $exception) {}

        return  0;
    }

    private function getAllEmployeesHaveLoan()
    {
        global $CONNECTION, $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->EMPLOYEE_CONTROL;
        $loanControl = $APPLICATION->FUNCTIONS->LOAN_CONTROL;
        $paymentControl = $APPLICATION->FUNCTIONS->LOAN_PAYMENT_CONTROL;
        $query = "SELECT DISTINCT(employee_id) FROM loans";

        $employees = $CONNECTION->Query($query, true);

        return array_map(function ($row) use ($control, $loanControl, $paymentControl) {
            return [
                "employee" => $control->get($row["employee_id"], true),
                "loans" => $loanControl->filterRecords(['employee_id' => $row["employee_id"]], true),
                "payments" => $paymentControl->filterRecords(['employee_id' => $row["employee_id"]], true)
            ];
        }, $employees);
    }
}