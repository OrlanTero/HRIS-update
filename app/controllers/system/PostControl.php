<?php

class PostControl
{
    public function GetEmployee() {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->EMPLOYEE_CONTROL;

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

    public function GetEmployment() {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->EMPLOYMENT_CONTROL;

        $id = $_POST["id"];

        return $control->get($id, true);
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

    public function run($request) {
        return $this->$request();
    }
}