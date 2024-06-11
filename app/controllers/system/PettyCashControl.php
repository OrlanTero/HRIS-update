<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\Pettycash;

class PettyCashControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = Pettycash::class;
    protected $TABLE_NAME = "pettycash";
    protected $TABLE_PRIMARY_ID = "pettycash_id";
    protected $SEARCH_LOOKUP = ["requested_by", "remarks", "amount"];
    protected $CATEGORY = \ActivityLogCategories::PETTY_CASH;

    public function add($record)
    {
        global $APPLICATION;

        $controlReport = $APPLICATION->FUNCTIONS->PETTY_CASH_REPORT_CONTROL;

        $insert = $this->addRecordWithLog($record);

        if ($insert->code == 200) {
            $controlReport->addRecord([
                "remarks" => $record['remarks'],
                "cash_in" => $record['amount']
            ]);
        }

        return $insert;
    }
    public function getPettyCashCredit()
    {
        $records = $this->getAllRecords(true);

        $total = 0;

        foreach ($records as $record) {
            $total += $record->amount;
        }

        return $total;
    }

    public function getBalance()
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->DISBURSEMENT_CONTROL;

        $disbursements = $control->getTotalDisbursements();

        $pettyCash = $this->getPettyCashCredit();

        return  $pettyCash - $disbursements;
    }
}