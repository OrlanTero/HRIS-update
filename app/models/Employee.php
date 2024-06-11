<?php

namespace Application\models;

use Application\abstracts\EmployeeAbstract;

 class Employee extends EmployeeAbstract
{
    protected $CONNECTION;

    public $name;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, EmployeeAbstract::class);
        $this->init();
    }

    private function init(): void
    {

        $this->name = $this->lastname . ", " . $this->firstname . " " . $this->middlename[0];

    }

     public function getBanks()
     {
         global $APPLICATION;

         return $APPLICATION->FUNCTIONS->BANK_ACCOUNT_CONTROL->filterRecords(["employee_id" => $this->employee_id], true);
     }

     public  function getBeneficiary($period, $year)
     {
        global $CONNECTION;

        $id = $this->employee_id;

        $query = "SELECT a.* FROM `beneficiaries` as a WHERE a.employee_id = '". $id ."' AND a.mortuary_id IN (SELECT b.mortuary_id FROM mortuaries as b WHERE b.period = '". $period ."' AND b.year = '". $year ."')";

        return $CONNECTION->Query($query);
     }
 }