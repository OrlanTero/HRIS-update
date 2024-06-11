<?php

namespace Application\abstracts;

abstract class PayrollComputationAbstract extends ModelDefaultFunctions
{
    public $payslip_id;

    public $employee_id;

    public $client_id;

    public $days_worked;

    public $ndw;

    public $nhw;

    public $basic_pay;

    public $nsd;

    public $nsd_basic_pay;

    public $nhw_sh;

    public $nhw_lh;

    public $lh_basic_pay;

    public $nhw_lhot;

    public $lhot_basic_pay;

    public $sh_basic_pay;

    public $nhw_shot;

    public $shot_basic_pay;

    public $gross_pay;

    public $sss;

    public $phil;

    public $insurance;

    public $part1;

    public $death;

    public $pagibig;

    public $part2;

    public $netpay;

    public $others;

    public $year;

    public $period;


    // hours

    public $rest_day;

    public $regular_hours;

    public $ot_hours;

    public $night_diff_hours;

    public $special_holiday_hours;

    public $special_holiday_ot_hours;

    public $legal_holiday_hours;

    public $legal_holiday_ot_hours;


    // end hours

    public $payslip_rates_id;

    public $date_created;

    public $db_status;

    /**
     * @return mixed
     */
    public function getNhwLh()
    {
        return $this->nhw_lh;
    }

    /**
     * @param mixed $nhw_lh
     */
    public function setNhwLh($nhw_lh): void
    {
        $this->nhw_lh = $nhw_lh;
    }

    /**
     * @return mixed
     */
    public function getLhBasicPay()
    {
        return $this->lh_basic_pay;
    }

    /**
     * @param mixed $lh_basic_pay
     */
    public function setLhBasicPay($lh_basic_pay): void
    {
        $this->lh_basic_pay = $lh_basic_pay;
    }

    /**
     * @return mixed
     */
    public function getNhwLhot()
    {
        return $this->nhw_lhot;
    }

    /**
     * @param mixed $nhw_lhot
     */
    public function setNhwLhot($nhw_lhot): void
    {
        $this->nhw_lhot = $nhw_lhot;
    }

    /**
     * @return mixed
     */
    public function getLhotBasicPay()
    {
        return $this->lhot_basic_pay;
    }

    /**
     * @param mixed $lhot_basic_pay
     */
    public function setLhotBasicPay($lhot_basic_pay): void
    {
        $this->lhot_basic_pay = $lhot_basic_pay;
    }


    /**
     * @return mixed
     */
    public function getLegalHolidayHours()
    {
        return $this->legal_holiday_hours;
    }

    /**
     * @param mixed $legal_holiday_hours
     */
    public function setLegalHolidayHours($legal_holiday_hours): void
    {
        $this->legal_holiday_hours = $legal_holiday_hours;
    }

    /**
     * @return mixed
     */
    public function getLegalHolidayOtHours()
    {
        return $this->legal_holiday_ot_hours;
    }

    /**
     * @param mixed $legal_holiday_ot_hours
     */
    public function setLegalHolidayOtHours($legal_holiday_ot_hours): void
    {
        $this->legal_holiday_ot_hours = $legal_holiday_ot_hours;
    }

    /**
     * @return mixed
     */
    public function getPayslipRatesId()
    {
        return $this->payslip_rates_id;
    }

    /**
     * @param mixed $payslip_rates_id
     */
    public function setPayslipRatesId($payslip_rates_id): void
    {
        $this->payslip_rates_id = $payslip_rates_id;
    }


    /**
     * @return mixed
     */
    public function getUniformRates()
    {
        return $this->uniform_rates;
    }

    /**
     * @param mixed $uniform_rates
     */
    public function setUniformRates($uniform_rates): void
    {
        $this->uniform_rates = $uniform_rates;
    }



    /**
     * @return mixed
     */
    public function getRegularHours()
    {
        return $this->regular_hours;
    }

    /**
     * @param mixed $regular_hours
     */
    public function setRegularHours($regular_hours): void
    {
        $this->regular_hours = $regular_hours;
    }

    /**
     * @return mixed
     */
    public function getOtHours()
    {
        return $this->ot_hours;
    }

    /**
     * @param mixed $ot_hours
     */
    public function setOtHours($ot_hours): void
    {
        $this->ot_hours = $ot_hours;
    }

    /**
     * @return mixed
     */
    public function getNightDiffHours()
    {
        return $this->night_diff_hours;
    }

    /**
     * @param mixed $night_diff_hours
     */
    public function setNightDiffHours($night_diff_hours): void
    {
        $this->night_diff_hours = $night_diff_hours;
    }

    /**
     * @return mixed
     */
    public function getSpecialHolidayHours()
    {
        return $this->special_holiday_hours;
    }

    /**
     * @param mixed $special_holiday_hours
     */
    public function setSpecialHolidayHours($special_holiday_hours): void
    {
        $this->special_holiday_hours = $special_holiday_hours;
    }

    /**
     * @return mixed
     */
    public function getSpecialHolidayOtHours()
    {
        return $this->special_holiday_ot_hours;
    }

    /**
     * @param mixed $special_holiday_ot_hours
     */
    public function setSpecialHolidayOtHours($special_holiday_ot_hours): void
    {
        $this->special_holiday_ot_hours = $special_holiday_ot_hours;
    }



    /**
     * @return mixed
     */
    public function getPayslipId()
    {
        return $this->payslip_id;
    }

    /**
     * @param mixed $payslip_id
     */
    public function setPayslipId($payslip_id): void
    {
        $this->payslip_id = $payslip_id;
    }

    /**
     * @return mixed
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * @param mixed $employee_id
     */
    public function setEmployeeId($employee_id): void
    {
        $this->employee_id = $employee_id;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id): void
    {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param mixed $period
     */
    public function setPeriod($period): void
    {
        $this->period = $period;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param mixed $date_created
     */
    public function setDateCreated($date_created): void
    {
        $this->date_created = $date_created;
    }



    /**
     * @return mixed
     */
    public function getDaysWorked()
    {
        return $this->days_worked;
    }

    /**
     * @param mixed $days_worked
     */
    public function setDaysWorked($days_worked): void
    {
        $this->days_worked = $days_worked;
    }

    /**
     * @return mixed
     */
    public function getNhw()
    {
        return $this->nhw;
    }

    /**
     * @param mixed $nhw
     */
    public function setNhw($nhw): void
    {
        $this->nhw = $nhw;
    }

    /**
     * @return mixed
     */
    public function getBasicPay()
    {
        return $this->basic_pay;
    }

    /**
     * @param mixed $basic_pay
     */
    public function setBasicPay($basic_pay): void
    {
        $this->basic_pay = $basic_pay;
    }

    /**
     * @return mixed
     */
    public function getNsd()
    {
        return $this->nsd;
    }

    /**
     * @param mixed $nsd
     */
    public function setNsd($nsd): void
    {
        $this->nsd = $nsd;
    }

    /**
     * @return mixed
     */
    public function getNsdBasicPay()
    {
        return $this->nsd_basic_pay;
    }

    /**
     * @param mixed $nsd_basic_pay
     */
    public function setNsdBasicPay($nsd_basic_pay): void
    {
        $this->nsd_basic_pay = $nsd_basic_pay;
    }

    /**
     * @return mixed
     */
    public function getNhwSh()
    {
        return $this->nhw_sh;
    }

    /**
     * @param mixed $nhw_sh
     */
    public function setNhwSh($nhw_sh): void
    {
        $this->nhw_sh = $nhw_sh;
    }

    /**
     * @return mixed
     */
    public function getShBasicPay()
    {
        return $this->sh_basic_pay;
    }

    /**
     * @param mixed $sh_basic_pay
     */
    public function setShBasicPay($sh_basic_pay): void
    {
        $this->sh_basic_pay = $sh_basic_pay;
    }

    /**
     * @return mixed
     */
    public function getNhwShot()
    {
        return $this->nhw_shot;
    }

    /**
     * @param mixed $nhw_shot
     */
    public function setNhwShot($nhw_shot): void
    {
        $this->nhw_shot = $nhw_shot;
    }

    /**
     * @return mixed
     */
    public function getShotBasicPay()
    {
        return $this->shot_basic_pay;
    }

    /**
     * @param mixed $shot_basic_pay
     */
    public function setShotBasicPay($shot_basic_pay): void
    {
        $this->shot_basic_pay = $shot_basic_pay;
    }

    /**
     * @return mixed
     */
    public function getGrossPay()
    {
        return $this->gross_pay;
    }

    /**
     * @param mixed $gross_pay
     */
    public function setGrossPay($gross_pay): void
    {
        $this->gross_pay = $gross_pay;
    }

    /**
     * @return mixed
     */
    public function getSss()
    {
        return $this->sss;
    }

    /**
     * @param mixed $sss
     */
    public function setSss($sss): void
    {
        $this->sss = $sss;
    }

    /**
     * @return mixed
     */
    public function getPhil()
    {
        return $this->phil;
    }

    /**
     * @param mixed $phil
     */
    public function setPhil($phil): void
    {
        $this->phil = $phil;
    }

    /**
     * @return mixed
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * @param mixed $insurance
     */
    public function setInsurance($insurance): void
    {
        $this->insurance = $insurance;
    }

    /**
     * @return mixed
     */
    public function getPart1()
    {
        return $this->part1;
    }

    /**
     * @param mixed $part1
     */
    public function setPart1($part1): void
    {
        $this->part1 = $part1;
    }

    /**
     * @return mixed
     */
    public function getDeath()
    {
        return $this->death;
    }

    /**
     * @param mixed $death
     */
    public function setDeath($death): void
    {
        $this->death = $death;
    }

    /**
     * @return mixed
     */
    public function getPagibig()
    {
        return $this->pagibig;
    }

    /**
     * @param mixed $pagibig
     */
    public function setPagibig($pagibig): void
    {
        $this->pagibig = $pagibig;
    }

    /**
     * @return mixed
     */
    public function getPart2()
    {
        return $this->part2;
    }

    /**
     * @param mixed $part2
     */
    public function setPart2($part2): void
    {
        $this->part2 = $part2;
    }

    /**
     * @return mixed
     */
    public function getNetpay()
    {
        return $this->netpay;
    }

    /**
     * @param mixed $netpay
     */
    public function setNetpay($netpay): void
    {
        $this->netpay = $netpay;
    }

    /**
     * @return mixed
     */
    public function getNdw()
    {
        return $this->ndw;
    }

    /**
     * @param mixed $ndw
     */
    public function setNdw($ndw): void
    {
        $this->ndw = $ndw;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRestDay()
    {
        return $this->rest_day;
    }

    /**
     * @param mixed $rest_day
     */
    public function setRestDay($rest_day): void
    {
        $this->rest_day = $rest_day;
    }

    /**
     * @return mixed
     */
    public function getDbStatus()
    {
        return $this->db_status;
    }

    /**
     * @param mixed $db_status
     */
    public function setDbStatus($db_status): void
    {
        $this->db_status = $db_status;
    }

    /**
     * @return mixed
     */
    public function getOthers()
    {
        return $this->others;
    }

    /**
     * @param mixed $others
     */
    public function setOthers($others): void
    {
        $this->others = $others;
    }



}