<?php

namespace Application\models;

use Application\abstracts\DeployedEmployeeAbstract;

class DeployedEmployee extends DeployedEmployeeAbstract
{
    protected $CONNECTION;

    public $employment;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, DeployedEmployeeAbstract::class);
        $this->init();
    }

    private function init(): void
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->EMPLOYMENT_CONTROL;

        $this->employment = $control->get($this->employment_id, false);
    }
}