<?php

namespace Application\core;

use Application\controllers\app\GlobalFunctions;
use Application\controllers\system\ActivityLogControl;
use Application\controllers\system\RequisitionControl;

class Application
{
    protected $AUTHENTICATION;
    protected $SESSION;
    protected $ROUTES;
    public $FUNCTIONS;

    public function __construct() {
        global $SESSION;

        $this->SESSION = $SESSION;
        $this->ROUTES = new Routes($this); // routes
        $this->AUTHENTICATION = new Authentication(); // auth // login | register
        $this->FUNCTIONS = new GlobalFunctions($SESSION);
    }

    public function run()
    {
        // Load Routes
        $this->ROUTES->loadRoutes();
    }

    public function GetDashboardData()
    {
        $expensesControl = $this->FUNCTIONS->REQUISITION_CONTROL;
        $employeeControl = $this->FUNCTIONS->EMPLOYEE_CONTROL;
        $deployControl = $this->FUNCTIONS->DEPLOYED_EMPLOYEE_CONTROL;
        $clientControl = $this->FUNCTIONS->CLIENT_CONTROL;
        $pettyCashControl = $this->FUNCTIONS->PETTYCASH_CONTROL;
        $requisitionControl = $this->FUNCTIONS->REQUISITION_CONTROL;

        $activityControl = new ActivityLogControl();

        $theMost = $expensesControl->getTheMostFrequentlyExpensesType();
        $em = $employeeControl->countRecords(null);
        $deployed = $deployControl->countDeployed();
        $notdeployed = $deployControl->countNotDeployed();
        $clients = $clientControl->countRecords(null);

        $cash = $pettyCashControl->getPettyCashCredit();
        $balance = $pettyCashControl->getBalance();

        $fiveLatest = $activityControl->getLatestRecords( 5, true);
        $requisitions = $requisitionControl->getLatestRecords(5, true, [["status", "=", "DRAFT"]], "req_date");

        return [
            "expenses" => [
                "most_expensive" => $theMost
            ],
            "employees" => [
                "total" => $em,
                "deployed" => $deployed,
                "not_deployed" => $notdeployed
            ],
            "clients" => [
                "total" => $clients
            ],
            "petty_cash" => [
                "cash" =>  $cash,
                "balance" =>  $balance
            ],
            "activities" => $fiveLatest,
            "requisitions" => $requisitions
        ];
    }
}