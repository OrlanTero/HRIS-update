<?php

namespace Application\controllers\system;

use Application\abstracts\ClientholidayAbstract;
use Application\abstracts\ControlDefaultFunctions;


class ClientholidayControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = ClientholidayAbstract::class;
    protected $TABLE_NAME = "client_holidays";
    protected $TABLE_PRIMARY_ID = "client_holiday_id";
    protected $SEARCH_LOOKUP = [];

    protected $CATEGORY = \ActivityLogCategories::CLIENT_HOLIDAY;

}