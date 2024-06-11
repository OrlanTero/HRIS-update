<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\ServiceDeduction;

class ServiceDeductionControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = ServiceDeduction::class;
    protected $TABLE_NAME = "service_deductions";
    protected $TABLE_PRIMARY_ID = "service_deduction_id";
    protected $SEARCH_LOOKUP = [];
    protected $CATEGORY = \ActivityLogCategories::DATA_MANAGEMENT;


    public function getDeductionOf($GP, $type)
    {
        global $CONNECTION;

        if ($GP <= 0) {
          return null;
        }

        try {
            $query = "SELECT * FROM $this->TABLE_NAME WHERE category = '".$type."' AND $GP BETWEEN price_from AND price_to";

            $result = $CONNECTION->Query($query);

            return $result ? $this->newInstanceOfModel($result) : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}