<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\PettyCashReport;
use Application\models\Requisition;

class PettyCashReportControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = PettyCashReport::class;
    protected $TABLE_NAME = "petty_cash_reports";
    protected $TABLE_PRIMARY_ID = "petty_cash_report_id";
    protected $SEARCH_LOOKUP = [];
    protected $CATEGORY = \ActivityLogCategories::PETTY_CASH;
}

