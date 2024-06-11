<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\controllers\app\Response;
use Application\models\Disbursement;


class DisbursementControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = Disbursement::class;
    protected $TABLE_NAME = "disbursement";
    protected $TABLE_PRIMARY_ID = "disbursement_id";
    protected $SEARCH_LOOKUP = ["voucher", "payments", "paid_to", "type", "remarks", "amount"];
    protected $CATEGORY = \ActivityLogCategories::DISBURSEMENT;

    public function generateVoucherID()
    {
        $voucher = EightDigitRandom();

        while ($this->isVoucherIDExists($voucher)) {
            $voucher = EightDigitRandom();
        }

        return $voucher;
    }

    public function isVoucherIDExists($voucher)
    {
        return $this->alreadyExists(['voucher' => $voucher])->code === 200;
    }

    public function getTotalDisbursements()
    {
        $total = 0;

        $records = $this->getAllRecords(true);

        foreach ($records as $record) {
            $total += $record->amount;
        }

        return $total;
    }

    public function addDisbursement($record)
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->REQUISITION_CONTROL;
        $controlReport = $APPLICATION->FUNCTIONS->PETTY_CASH_REPORT_CONTROL;

        $balance  = $APPLICATION->FUNCTIONS->PETTYCASH_CONTROL->getBalance();

        $totalAmount = $record['amount'];

        if ($balance >= $totalAmount) {
            $id = $record['requisition_id'];

            $requisition = $control->get($id, true);

            $control->setRequisitionStatus($id, \RequisitionStatusType::FINALIZED->value);

            $insert = $this->addRecord($record);

            if ($insert->code == 200) {
                $controlReport->addRecord([
                    "voucher" => $record['voucher'],
                    "type" => $requisition->type,
                    "remarks" => $requisition->remarks,
                    "cash_out" => $requisition->amount,
                    "date_modify" => $record['date']
                ]);
            }

            return $insert;
        }

        return new Response(403, "Petty Cash doesn't have enough funds!");
    }
}