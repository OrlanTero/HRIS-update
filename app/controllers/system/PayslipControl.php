<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\LoanPayment;
use Application\models\PayrollComputation;

class PayslipControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = PayrollComputation::class;
    protected $TABLE_NAME = "payslips";
    protected $TABLE_PRIMARY_ID = "payslip_id";
    protected $SEARCH_LOOKUP = [];

    protected $CATEGORY = \ActivityLogCategories::PAYROLL;
}