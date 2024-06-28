<?php

namespace Application\controllers\system;

use Application\models\PayrollAnalyzer;
use ReportTypes;

class ReportControl
{
    public $type;
    public function __construct($type) {
        $this->type = $type;
    }

    public function getReport($data)
    {
        switch ($this->type) {
            case ReportTypes::PAYSLIP_PER_CLIENT->value:
                return $this->getPlaySlipPerClient($data);
            case ReportTypes::LOAN_PAYMENTS->value:
                return $this->getLoanPayments($data);
            case ReportTypes::PAYSLIP_AZ->value:
                return $this->getPayslipAZ($data);
            case ReportTypes::MORTUARY->value:
                return $this->getMortuary($data);
            case ReportTypes::PAYSLIP_PER_CLIENT_INDIVIDUALLY->value:
                return  $this->getPlaySlipPerClientIndividually($data);
            case ReportTypes::TOTAL_BANK->value:
                return  $this->getTotalBank($data);
            case ReportTypes::PETTY_CASH_EXPENSES->value:
                return  $this->getPetty($data);
        }
    }

    private function getPlaySlipPerClient($data)
    {
        global $APPLICATION, $PER_CLIENT_TABLE_HEADER_TEXT, $PER_CLIENT_TABLE_BODY_KEY;

        $control = $APPLICATION->FUNCTIONS->ATTENDANCE_GROUP_CONTROL;
        $clientControl = $APPLICATION->FUNCTIONS->CLIENT_CONTROL;

        $finalData = [];

        $records = $control->filterRecords(["period" => $data['period'], "year" => $data['year']], true);

        $records = array_map(function ($record)  use ($clientControl) {
            $ANALYZER = new PayrollAnalyzer($record->attendance_group_id);

            $ANALYZER->init();

            $result = $ANALYZER->computeAll();

            $netpays = array_reduce($result, function ($carry, $item) {
                return $carry + $item->netpay;
            });

            $client = $clientControl->get($record->client_id, true);

            return [
                "client" => $client,
                "client_id" => $record->client_id,
                "netpays" => $netpays
            ];
        }, $records);

        foreach ($records as $record) {
            $exists = array_filter($finalData, function ($item) use ($record) {
                return $item['client_id'] == $record['client_id'];
            });

            if ($exists) {
                $finalData = array_map(function ($item) use ($record) {
                    if ($item['client_id'] == $record['client_id']) {
                        $item['total'] += $record['netpays'];
                    }

                    return $item;
                }, $finalData);
            } else {
                $finalData[] = [
                    "client_id" => $record['client_id'],
                    "client" => $record['client']->name,
                    "branch" => $record['client']->branch,
                    "total" => $record['netpays'],
                    "period" => $data['period'],
                    "year" => $data['year'],
                ];
            }
        }

        return CreateTable($PER_CLIENT_TABLE_HEADER_TEXT, $PER_CLIENT_TABLE_BODY_KEY, $finalData, "client_id", false, false);
    }

    private function getLoanPayments($data)
    {
        global $CONNECTION, $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->EMPLOYEE_CONTROL;

        if (isset($data['period']) && isset($data['year']) && isset($data['type'])) {
            $query = "SELECT * FROM loan_payments WHERE period = '{$data['period']}' AND year = '{$data['year']}' AND FIND_IN_SET(" . $data['type'] . ", loan_types)";
        } else if (isset($data['period']) && isset($data['year'])) {
            $query = "SELECT * FROM loan_payments WHERE period = '{$data['period']}' AND year = '{$data['year']}'";
        } else if (isset($data['year'])) {
            $query = "SELECT * FROM loan_payments WHERE year = '{$data['year']}'";
        } else if (isset($data['type'])) {
            $query = "SELECT * FROM loan_payments WHERE FIND_IN_SET(" . $data['type'] . ", loan_types)";
        } else if (isset($data['period'])) {
            $query = "SELECT * FROM loan_payments WHERE period = '{$data['period']}'";
        }

        $records = $CONNECTION->QUERY($query, true);

        return array_map(function ($record) use ($control) {
            $employee = $control->get($record['employee_id'], true);

            return [
                "id" => "",
                "employee" => $employee->name,
                "amount" => $record['amount'],
            ];
        }, $records);
    }

    private function getPayslipAZ($data)
    {
        global $CONNECTION;

        $id = $data['employee_id'];

        if ($id == 'all') {
//            $query = "SELECT a.* FROM attendance_groups as a WHERE a.period = '{$data['period']}' AND a.year = '{$data['year']}') ";
        } else {
            $query = "SELECT a.* FROM attendance_groups as a WHERE a.period = '{$data['period']}' AND a.year = '{$data['year']}' AND a.client_id IN (SELECT b.client_id FROM deployed_employees as b WHERE b.employment_id IN (SELECT c.employment_id FROM employments as c WHERE c.employee_id = '". $id ."')) ";
        }

        $records = $CONNECTION->Query($query, true);

        $records = array_map(function ($item) use ($id) {
            $analyzer = new PayrollAnalyzer($item['attendance_group_id']);

            $analyzer->init();

            $computation = $analyzer->computeAttendanceOf($id);

            $computation->save();

            return $computation;
        }, $records);

        return $records;
    }

    private function getMortuary($data)
    {
        global $CONNECTION, $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->EMPLOYEE_CONTROL;

        $query = "SELECT employee_id, SUM(death) as mortuary FROM `payslips` WHERE year = '{$data['year']}' AND period='{$data['period']}' GROUP BY employee_id";

        $records = $CONNECTION->Query($query, true);

        $records = array_map(function ($record) use ($control) {
            $employee = $control->get($record['employee_id'], true);
            return [
                "id" => "",
                "employee" => $employee->name,
                "amount" => $record['mortuary'],
            ];
        }, $records);

        return $records;
    }

    private function getPlaySlipPerClientIndividually($data)
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->ATTENDANCE_GROUP_CONTROL;


        $records = $control->filterRecords(["period" => $data['period'], "year" => $data['year'], "client_id" => $data['client']], true);

        if ($records > 0) {
            $analyzer = new PayrollAnalyzer($records[0]->attendance_group_id);

            $analyzer->init();

            $computation = $analyzer->computeAll();

//            return array_map(function ($item) {
//                return $item->save();
//            }, $computation);
            foreach ($computation as $item) {
                $item->save();
            }


            return $computation;
        }

        return [];

    }

    private function getPetty($data)
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->PETTY_CASH_REPORT_CONTROL;

        $records = $control->getAllRecords(true);

        return array_map(function ($item) use ($control) {
            return [
                "id" => "",
                "date" => $item->date_modify,
                "voucher" => $item->voucher,
                "type" => $item->type,
                "remarks" => $item->remarks,
                "in" => $item->cash_in,
                "out" => $item->cash_out,
            ];
        }, $records);
    }
}