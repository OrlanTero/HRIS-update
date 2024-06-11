<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\abstracts\HolidayAbstract;
use Application\models\Holiday;

class HolidayControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = Holiday::class;
    protected $TABLE_NAME = "holidays";
    protected $TABLE_PRIMARY_ID = "holiday_id";
    protected $SEARCH_LOOKUP = ["holiday_id", "holiday"];

    protected $CATEGORY = \ActivityLogCategories::HOLIDAYS;

}