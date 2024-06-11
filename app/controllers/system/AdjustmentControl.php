<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\Adjustment;

class AdjustmentControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = Adjustment::class;
    protected $TABLE_NAME = "adjustment";
    protected $TABLE_PRIMARY_ID = "adjustment_id";
    protected $SEARCH_LOOKUP = [[
        "table" => "employees",
        "primary" => "employee_id",
        "into" => ['firstname', 'lastname', 'middlename']], "amount"];

    protected $CATEGORY = \ActivityLogCategories::ADJUSTMENTS;
}