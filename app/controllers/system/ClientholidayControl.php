<?php

namespace Application\controllers\system;

use Application\abstracts\ClientholidayAbstract;
use Application\abstracts\ControlDefaultFunctions;
use Application\models\ClientHoliday;


class ClientholidayControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = ClientHoliday::class;
    protected $TABLE_NAME = "client_holidays";
    protected $TABLE_PRIMARY_ID = "client_holiday_id";
    protected $SEARCH_LOOKUP = [];

    protected $CATEGORY = \ActivityLogCategories::CLIENT_HOLIDAY;

}