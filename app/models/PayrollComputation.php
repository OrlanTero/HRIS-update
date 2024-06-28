<?php

namespace Application\models;

use Application\abstracts\PayrollComputationAbstract;

class PayrollComputation extends PayrollComputationAbstract
{
    public $group;

    public $name;

    public $employee;

    public $payslip_rates;

    public $total_hours;

    public function __construct($group, $employee)
    {
        $this->group = $group;
        $this->employee = $employee;
        $this->name = $employee->name;

        $this->employee_id = $employee->employee_id;
        $this->client_id = $this->group->client->client_id;
    }

    public function save()
    {
        global $APPLICATION, $CONNECTION;

        $control = $APPLICATION->FUNCTIONS->PAYSLIP_CONTROL;
//
        $existed = $control->alreadyExists([
            'employee_id' => $this->employee_id,
            'client_id' => $this->client_id,
            'year' => $this->year,
            'period' => $this->period,
        ]);

        $rateSave = $this->payslip_rates->save();

        if ($rateSave->code == 200) {
            $this->setPayslipRatesId($rateSave->body['id']);
        }

        $copy = $this;

        unset($copy->payslip_rates, $copy->group, $copy->employee, $this->name, $this->payslip_id, $this->date_created, $this->days_worked, $this->db_status);

//        return $copy;
        if ($existed->code == 200) {
            return $control->editRecord($existed->body['id'], (Array) $copy);
        } else {
            return $control->addRecord( (Array) $copy);
        }
    }

    public function setPayslipRates(PayslipRates $RATES)
    {
        $this->payslip_rates = $RATES;
    }

    /**
     * @return mixed
     */
    public function getTotalHours()
    {
        return $this->total_hours;
    }

    /**
     * @param mixed $total_hours
     */
    public function setTotalHours($total_hours): void
    {
        $this->total_hours = $total_hours;
    }


}