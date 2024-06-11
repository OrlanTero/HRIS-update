<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\Requisition;

class RequisitionControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = Requisition::class;
    protected $TABLE_NAME = "requisition";
    protected $TABLE_PRIMARY_ID = "requisition_id";
    protected $SEARCH_LOOKUP = ["remarks", "status", "amount"];
    protected $CATEGORY = \ActivityLogCategories::REQUISITION;

    public function add($data) {
        global $APPLICATION;

        $requisition = $data['data'];
        $requisition_info = $data['requisition'];
        $control = $APPLICATION->FUNCTIONS->REQUISITION_INFO_CONTROL;

        $insert = $this->addRecord($requisition);

        if ($insert->code == 200) {
            foreach ($requisition_info as $requisitions) {
                $requisitions['requisition_id'] = $insert->body['id'];
                unset($requisitions["status"]);
                $control->addRecord($requisitions);
            }
        }

        return $insert;
    }
    public function edit($data) {
        global $APPLICATION;

        $requisition = $data['data'];
        $id = $data['id'];
        $requisition_info = $data['requisition'];
        $control = $APPLICATION->FUNCTIONS->REQUISITION_INFO_CONTROL;

        $edit = $this->editRecord($id, $requisition);

        if ($edit->code == 200) {
            foreach ($requisition_info as $requisition) {
                $requisition['requisition_id'] = $id;

                if ($requisition['status'] === 'created') {
                    unset($requisition['status']);

                    $control->addRecord($requisition);
                } else if ($requisition['status'] === 'edited') {
                    $id = $requisition['id'];

                    unset($requisition['status'], $requisition['id']);

                    $control->editRecord($id, $requisition);
                } else if ($requisition['status'] === 'deleted') {
                    $id = $requisition['id'];

                    $control->removeRecord($id);
                }
            }
        }
        return $edit;
    }

    public function generateRequisitionID()
    {
        $id = EightDigitRandom();

        while ($this->isRequisitionIDExists($id)) {
            $id = EightDigitRandom();
        }

        return $id;
    }

    public function isRequisitionIDExists($voucher)
    {
        return $this->alreadyExists(['req_id' => $voucher])->code === 200;
    }

    public function setRequisitionStatus($id, $status)
    {
        return $this->editRecord($id, ['status' => $status]);
    }

    public function getTheMostFrequentlyExpensesType()
    {
        global $CONNECTION;

        $query = "SELECT DISTINCT (a.type), AVG(a.amount) as total FROM requisition_info as a WHERE a.requisition_id IN (SELECT b.requisition_id FROM requisition as b WHERE b.status = 'FINALIZED' ) ORDER BY total";

        $results = $CONNECTION->Query($query, true);

        return $results;
    }
}

