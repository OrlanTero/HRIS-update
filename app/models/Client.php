<?php

namespace Application\models;

use Application\abstracts\ClientAbstract;

class Client extends ClientAbstract
{
    protected $CONNECTION;


    public $deployed_employees;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, ClientAbstract::class);
        $this->init();
    }

    private function init(): void
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->DEPLOYED_EMPLOYEE_CONTROL;

        $this->deployed_employees = $control->filterRecords(['client_id' => $this->client_id], true);
    }

    public function getDeployedEmployee($employee_id)
    {
        foreach ($this->deployed_employees as $deployed_employee) {
            if ($deployed_employee['employee_id'] == $employee_id) {
                return $deployed_employee;
            }
        }

        return null;
    }
}