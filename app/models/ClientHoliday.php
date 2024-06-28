<?php

namespace Application\models;

use Application\abstracts\ClientholidayAbstract;


class ClientHoliday extends ClientholidayAbstract
{
    protected $CONNECTION;

    public $holiday;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, ClientholidayAbstract::class);
        $this->init();
    }

    private function init(): void
    {
        global $APPLICATION;

        $this->holiday = $APPLICATION->FUNCTIONS->HOLIDAY_CONTROL->get($this->holiday_id, true);
    }
}