<?php

use Application\controllers\app\EmailControl;
use Application\controllers\app\Response;
use Application\controllers\system\ReportControl;
use Application\controllers\system\UserAuthenticationControl;
use Application\controllers\system\UserProfileControl;
use Application\core\Authentication;
use Application\models\LoanAnalyzer;
use Application\models\PayrollAnalyzer;

class PostControl
{
    public function GetEmployee() {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->EMPLOYEE_CONTROL;

        $id = $_POST["id"];

        return $control->get($id, true);
    }
    public function GetRequisition() {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->REQUISITION_CONTROL;

        $id = $_POST["id"];

        return $control->get($id, true);
    }
    public function GetClient() {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->CLIENT_CONTROL;

        $id = $_POST["id"];

        return $control->get($id, true);
    }

    public function GetBank() {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->BANK_CONTROL;

        $id = $_POST["id"];

        return $control->get($id, true);
    }

    public function GetHoliday() {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->HOLIDAY_CONTROL;

        $id = $_POST["id"];

        return $control->get($id, true);
    }

    public function GetEmployment() {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->EMPLOYMENT_CONTROL;

        $id = $_POST["id"];

        return $control->get($id, true);
    }

    public function GetOverAllLoanBalanceOfEmployee() {
        $control = new LoanAnalyzer();

        $id = $_POST["id"];

        return $control->GetOverAllLoanBalanceOfEmployee($id);
    }

    public function GetAvailablePeriodAttendance() {
        global $APPLICATION, $CONNECTION;

        $control = $APPLICATION->FUNCTIONS->ATTENDANCE_GROUP_CONTROL;

        $client_id = $_POST["client"];

        $query = "SELECT DISTINCT(a.period) as temp, a.*  FROM `attendance_groups` as a WHERE a.year IN (SELECT DISTINCT(a.year) FROM `attendance_groups` WHERE a.client_id = '".$client_id."')" ;
//

        $results = $CONNECTION->Query($query, true);
//
        return $control->NewArrayInstance($results, true);

//        return $control->get($id, true);
    }

    public function GetVatValues() {
        global $VAT_VALUES,$NONVAT_VALUES;

        $vatOrNot = $_POST["vat_or_not"];

        return json_encode(filter_var($vatOrNot, FILTER_VALIDATE_BOOLEAN) === true ? $VAT_VALUES : $NONVAT_VALUES);
    }

    public function GetColumnsTable() {
        global $APPLICATION;

        $header = $_POST["tableHeader"];
        $body =  $_POST["tableBody"];

        global ${$header}, ${$body};

        return [
            "header" => array_map(function($a) {
                return strtolower($a) === "no" ? "ID" : $a;
            }, ${$header}),
            "body" => array_map(function($a) {
                return is_array($a) ? $a['primary'] : (strtolower($a) === "no" ? "id" : $a);
            }, ${$body}),
        ];
    }

    public function GetLoans()
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->LOAN_CONTROL;

        $ids = json_decode($_POST["ids"], true);

        return array_map(function ($id)  use ($control) {
            return $control->get($id, true);
        }, $ids);
    }

    public function GetReports()
    {
        global $APPLICATION, $PER_CLIENT_TABLE_HEADER_TEXT, $PER_CLIENT_TABLE_BODY_KEY;

        $control = $APPLICATION->FUNCTIONS->ATTENDANCE_GROUP_CONTROL;
        $clientControl = $APPLICATION->FUNCTIONS->CLIENT_CONTROL;

        $type = $_POST['type'];
        $data = json_decode($_POST["data"], true);

        $reportControl = new ReportControl($type);

        return $reportControl->getReport($data);
    }

    public function run($request) {
        return $this->$request();
    }

    public function SetAuthentication()
    {
        $control = new UserAuthenticationControl();

        $type = $_POST['type'];
        $data = json_decode($_POST['data'], true);

        return $control->SetAuthentication($type, $data);
    }

    public function TryAuthenticate()
    {
        $authControl = new Authentication();

        $type = $_POST['type'];
        $data = json_decode($_POST['data'], true);

        return $authControl->LoginWithAuth($type, $data);
    }

    public function ConfirmAuthenticationVerification()
    {
        global $SESSION;

        $control = new EmailControl();
        $userControl = new UserProfileControl();

        $verification = $_POST['verification'];

        $verify = $control->confirmVerificationToUser("MAIN_PROFILE", $verification);

        if ($verify) {
            $user = $userControl->getProfile();

            $SESSION->apply($user, true);
            $SESSION->start();
        }

        return new Response($verify ? 200 : 204, $verify ? "Successfully Login" : "Failed to Verify!");
    }
}