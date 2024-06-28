<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\RequisitionInfo;

class RequisitionInfoControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = RequisitionInfo::class;
    protected $TABLE_NAME = "requisition_info";
    protected $TABLE_PRIMARY_ID = "requisition_info_id";
    protected $SEARCH_LOOKUP = [];
}