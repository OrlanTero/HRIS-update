<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\Mortuary;

class MortuaryControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = Mortuary::class;
    protected $TABLE_NAME = "mortuaries";
    protected $TABLE_PRIMARY_ID = "mortuary_id";
    protected $SEARCH_LOOKUP = ["mortuary_id", "period", "year"];
    protected $CATEGORY = \ActivityLogCategories::MORTUARY;

    public function add($data) {
        global $APPLICATION;

        $mortuary = $data['data'];
        $beneficiaries = $data['beneficiaries'];
        $control = $APPLICATION->FUNCTIONS->BENEFICIARY_CONTROL;

        $insert = $this->addRecordWithLog($mortuary);

        if ($insert->code == 200) {
            foreach ($beneficiaries as $beneficiary) {
                $beneficiary['mortuary_id'] = $insert->body['id'];

                unset($beneficiary['status']);

                $control->addRecordWithLog($beneficiary);
            }
        }

        return $insert;
    }

    public function edit($data) {
        global $APPLICATION;

        $mortuary = $data['data'];
        $id = $data['id'];
        $beneficiaries = $data['beneficiaries'];
        $control = $APPLICATION->FUNCTIONS->BENEFICIARY_CONTROL;

        $edit = $this->editRecordWithLog($id, $mortuary);

        if ($edit->code == 200) {
            foreach ($beneficiaries as $beneficiary) {
                $beneficiary['mortuary_id'] = $id;

                if ($beneficiary['status'] === 'created') {
                    unset($beneficiary['status']);

                    $control->addRecordWithLog($beneficiary);
                } else if ($beneficiary['status'] === 'edited') {
                    $id = $beneficiary['id'];

                    unset($beneficiary['status'], $beneficiary['id']);

                    $control->editRecordWithLog($id, $beneficiary);
                } else if ($beneficiary['status'] === 'deleted') {
                    $id = $beneficiary['id'];

                    $control->removeRecordWithLog($id);
                }
            }
        }
        return $edit;
    }
}