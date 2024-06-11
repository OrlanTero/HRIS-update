<?php

namespace Application\models;

use Application\abstracts\EmploymentAbstract;

class Employment extends EmploymentAbstract
{
    protected $CONNECTION;

    public $employee;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, EmploymentAbstract::class);
        $this->init();
    }

    private function init(): void
    {
        global $APPLICATION;

        $this->employee = $APPLICATION->FUNCTIONS->EMPLOYEE_CONTROL->get($this->employee_id, true);

    }
}