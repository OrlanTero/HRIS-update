<?php

namespace Application\models;

use AttendanceTypes;

class PayrollAnalyzer
{
    public $group_id;

    public $group;

    public $computation;

    public $attendances;


    public function __construct($group_id)
    {
        $this->group_id = $group_id;
    }

    public function init()
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->ATTENDANCE_GROUP_CONTROL;

        $this->group = $control->get($this->group_id, true);

        $this->attendances = $this->group->getAttedanceOfEachEmployee();
    }

    public function computeAttendanceOf($id)
    {
        return $this->compute($this->group->getAttendanceOfEmployee($id));
    }

    public function compute($AI) {
        global $APPLICATION;

        // CONTROLLERS
        $control = $APPLICATION->FUNCTIONS->SERVICE_DEDUCTION_CONTROL;
        $adjustmentControl = $APPLICATION->FUNCTIONS->ADJUSTMENT_CONTROL;

        /**
         * @type Client $client
         * @type ServiceDeduction $SSS_DEDUCTION_OBJ
         * @type ServiceDeduction $PHIL_DEDUCTION_OBJ
         * @type ServiceDeduction $PAGIBIG_DEDUCTION_OBJ
         */
        $client = $this->group->client;
        $employee = $AI['employee'];
        $attendance = $AI['attendance'];
        $ndw = $AI['ndw'];

        // $ADJUSTMENTS
        $ADJUSTMENT = $adjustmentControl->filterRecords(['employee_id' => $employee->employee_id], false);
        $TOTAL = count($ADJUSTMENT) > 0 ? array_sum(array_column($ADJUSTMENT, "amount")) : 0;

//        RATESSSSSSSSSSSSSSSSSSSSSSSS

        $_REGULAR_RATE = $client->regular_2 ?? 0;
        $_REGULAR_OT_RATE = $client->overtime_2 ?? 0;
        $_SPECIAL_HOLIDAY_RATE = $client->special_holiday ?? 0;
        $_SPECIAL_HOLIDAY_OT = $client->special_holiday_ot ?? 0 ;
        $_LEGAL_HOLIDAY_RATE = $client->legal_holiday ?? 0 ;
        $_LEGAL_HOLIDAY_OT_RATE = $client->legal_holiday_ot ?? 0;
        $_NIGHT_DIFF_RATE = $client->nightdiff ?? 0;
        $_REST_DAY_RATE = $client->restday ?? 0;

        // non attendance
        $_UNIFORM_RATE = $client->uniform ?? 0;
        $_SEA_RATE = $client->sea ?? 0;
        $_ALLOWANCE_RATE = $client->allowance ?? 0;
        $_HEAD_GUARD_ALLOWANCE_RATE = $client->head_guard_allowance ?? 0;
        $_CTPA_RATE = $client->ctpa ?? 0;
        $_COLA_RATE = $client->cola ?? 0;

        $_LEAVE_RATE = $client->leave_1 ?? 0;

        // COMPUTATIONS

        // regular hours
        $REGULAR = $this->computeTotalOf($attendance, \AttendanceTypes::REGULAR->value);
        // ot hours
        $OT = $this->computeTotalOf($attendance, \AttendanceTypes::OT->value);
        // rest day hours
        $R = $this->computeTotalOf($attendance, \AttendanceTypes::REST_DAY->value);
        // legal holiday hours
        $NHWLH = $this->computeTotalOf($attendance, AttendanceTypes::LEGAL_HOLIDAY->value);
        // legal holiday ot hours
        $NHWLHOT = $this->computeTotalOf($attendance, AttendanceTypes::LEGAL_HOLIDAY_OT->value);
        // night difference hours
        $NSD = $this->computeTotalOf($attendance, \AttendanceTypes::NIGHT_DIFF->value);
        // special holiday hours
        $NHWSH = $this->computeTotalOf($attendance, \AttendanceTypes::SPECIAL_HOLIDAY->value);
        // special holiday ot hours
        $SHOT = $this->computeTotalOf($attendance, \AttendanceTypes::SPECIAL_HOLIDAY_OT->value);

        $ALL_HOURS = $REGULAR + $OT + $R + $NHWLH + $NHWLHOT + $NHWSH + $SHOT;

        $OTR = ($OT * $_REGULAR_OT_RATE);

        // number of hours work
        $NHW = $REGULAR + $OT;
        // basic pay
        $BP = ($REGULAR * $_REGULAR_RATE) + $OTR;

        $RR = ($R * $_REST_DAY_RATE);

        $NSDBP = $_NIGHT_DIFF_RATE * $NSD;
        $NHWSHBP = $_SPECIAL_HOLIDAY_RATE * $NHWSH;
        $SHOTBP = $_SPECIAL_HOLIDAY_OT * $SHOT;
        $NHWLHBP = $_LEGAL_HOLIDAY_RATE * $NHWLH;
        $LHOTBP = $_LEGAL_HOLIDAY_OT_RATE * $NHWLHOT;
        
        // gross pay
        $GP = $BP  + $NSDBP + $NHWSHBP + $SHOTBP + $NHWLHBP + $LHOTBP + $RR + $_ALLOWANCE_RATE + $_HEAD_GUARD_ALLOWANCE_RATE + $TOTAL;

        $SSS_DEDUCTION_OBJ = $control->getDeductionOf($GP, \ServiceDeductionTypes::SSS->value);
        $PHIL_DEDUCTION_OBJ = $control->getDeductionOf($GP, \ServiceDeductionTypes::PHILHEALTH->value);
        $PAGIBIG_DEDUCTION_OBJ = $control->getDeductionOf($GP, \ServiceDeductionTypes::PAGIBIG->value);

////        DEDUCTIONS

//        // PART 1
        $_UNIFORM_DEDUCTION = max($_UNIFORM_RATE, 0);
        $_OTHERS = $_UNIFORM_DEDUCTION + $_SEA_RATE + $_CTPA_RATE + $_COLA_RATE;
        $_INSURANCE = 20;
        $_SSS = $SSS_DEDUCTION_OBJ ? $SSS_DEDUCTION_OBJ->ee : 0;
        $_PHIL = $PHIL_DEDUCTION_OBJ ? $PHIL_DEDUCTION_OBJ->ee : 0;
        $_PART1 = $_SSS + $_PHIL + $_INSURANCE + $_OTHERS;

//        // PART 2
        $_DEATH = 150;
        $_PAGIBIG = ($PAGIBIG_DEDUCTION_OBJ ? $PAGIBIG_DEDUCTION_OBJ->ee : 0);
        $_PART2 = $_DEATH + $_PAGIBIG;

        $_NETPAY = $GP - ($_PART1 + $_PART2);

        $COMPUTATION = new PayrollComputation($this->group, $employee);

        $RATES = new PayslipRates();

        // set hours
        $COMPUTATION->setRegularHours($REGULAR);
        $COMPUTATION->setOTHours($OT);
        $COMPUTATION->setNightDiffHours($NSD);
        $COMPUTATION->setSpecialHolidayHours($NHWSH);
        $COMPUTATION->setSpecialHolidayOtHours($SHOT);
        $COMPUTATION->setLegalHolidayHours($NHWLH);
        $COMPUTATION->setLegalHolidayOtHours($NHWLHOT);

        $COMPUTATION->setTotalHours($ALL_HOURS);

        // set rates

        $COMPUTATION->setRestDay($RR);
        $COMPUTATION->setNdw($ndw);
        $COMPUTATION->setNhw($NHW);
        $COMPUTATION->setBasicPay($BP);
        $COMPUTATION->setNsd($NSD);
        $COMPUTATION->setNsdBasicPay($NSDBP);
        $COMPUTATION->setNhwLh($NHWLH);
        $COMPUTATION->setLhBasicPay($NHWLHBP);
        $COMPUTATION->setNhwLhot($NHWLHOT);
        $COMPUTATION->setLhotBasicPay($LHOTBP);
        $COMPUTATION->setNhwSh($NHWSH);
        $COMPUTATION->setShBasicPay($NHWSHBP);
        $COMPUTATION->setNhwShot($SHOT);
        $COMPUTATION->setShotBasicPay($SHOTBP);
        $COMPUTATION->setGrossPay($GP);
        $COMPUTATION->setSss($_SSS);
        $COMPUTATION->setPhil($_PHIL);
        $COMPUTATION->setInsurance($_INSURANCE);
        $COMPUTATION->setPart1($_PART1);
        $COMPUTATION->setDeath($_DEATH);
        $COMPUTATION->setPagibig($_PAGIBIG);
        $COMPUTATION->setPart2($_PART2);
        $COMPUTATION->setNetpay($_NETPAY);
        $COMPUTATION->setOthers($_OTHERS);

        $COMPUTATION->setYear($this->group->year);
        $COMPUTATION->setPeriod($this->group->period);

        $RATES->byClient($client);

        $COMPUTATION->setPayslipRates($RATES);

        return $COMPUTATION;
    }

    public function computeTotalOf($attendances, $type) {
        $total = 0;

        foreach ($attendances as $attendance) {
            $col = array_column(\AttendanceTypes::cases(), "value");

            if ($col[(int) $attendance->type] == $type) {
                $total += $attendance->hours;
            }
        }

        return $total;
    }

    public function computeAll()
    {
        $ALL = [];

        foreach ($this->attendances as $attendance) {
            $ALL[] = $this->compute($attendance);
        }

        return $ALL;
    }
}