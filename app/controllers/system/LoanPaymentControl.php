<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\LoanPayment;

class LoanPaymentControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = LoanPayment::class;
    protected $TABLE_NAME = "loan_payments";
    protected $TABLE_PRIMARY_ID = "payment_id";
    protected $SEARCH_LOOKUP = [];

    protected $CATEGORY = \ActivityLogCategories::LOAN_MANAGER;


    public function pay($data)
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->LOAN_CONTROL;
        $employeeControl = $APPLICATION->FUNCTIONS->EMPLOYEE_CONTROL;

        $employee = $employeeControl->get($data['employee_id'], true);

        $loans = array_map(function ($loanID) use ($control) {
            return $control->get($loanID, true);
        }, explode(',', $data['loans']));

        $amount = (float) $data['amount'];

        $toEdit = [];

        foreach ($loans as $loan) {
            if ($amount >= (float)$loan->balance) {
                $amount = $amount - (float) $loan->balance;
                $loan->balance = 0;

                $toEdit[] = ["loan_id" => $loan->loan_id, "balance" => 0];
            } else {
                $loan->balance = (float)$loan->balance - $amount;
                $amount = 0;

                $toEdit[] = ["loan_id" => $loan->loan_id, "balance" => (float)$loan->balance];
            }
        }

        foreach ($toEdit as $loan) {
            $control->editRecord($loan['loan_id'], ['balance' => $loan['balance']]);
        }

        return $this->addRecordWithLog($data, $employee->name . ' Loan Payment received: ' . $data['amount']);
    }
}