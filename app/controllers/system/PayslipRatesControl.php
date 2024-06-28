<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\PayslipRates;
use Application\models\SystemType;

class PayslipRatesControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = PayslipRates::class;
    protected $TABLE_NAME = "payslip_rates";
    protected $TABLE_PRIMARY_ID = "rate_id";
    protected $SEARCH_LOOKUP = [];
    protected $CATEGORY = \ActivityLogCategories::PAYROLL;
}