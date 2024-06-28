<?php

namespace Application\abstracts;

abstract class PayslipRatesAbstract extends ModelDefaultFunctions
{

    public $rate_id;

    public $client_id;

    public $regular;

    public $ot;

    public $night_diff;

    public $special_holiday;

    public $special_holiday_ot;

    public $uniform;

    public $rest_day;

    public $sea;

    public $cola;

    public $leave_rate;

    public $allowance;

    public $head_guard_allowance;

    public $ctpa;

    public $legal_holiday;

    public $legal_holiday_ot;

    public $date_created;

    public $db_status;

    /**
     * @return mixed
     */
    public function getRegular()
    {
        return $this->regular;
    }

    /**
     * @param mixed $regular
     */
    public function setRegular($regular): void
    {
        $this->regular = $regular;
    }

    /**
     * @return mixed
     */
    public function getOt()
    {
        return $this->ot;
    }

    /**
     * @param mixed $ot
     */
    public function setOt($ot): void
    {
        $this->ot = $ot;
    }

    /**
     * @return mixed
     */
    public function getNightDiff()
    {
        return $this->night_diff;
    }

    /**
     * @param mixed $night_diff
     */
    public function setNightDiff($night_diff): void
    {
        $this->night_diff = $night_diff;
    }

    /**
     * @return mixed
     */
    public function getSpecialHoliday()
    {
        return $this->special_holiday;
    }

    /**
     * @param mixed $special_holiday
     */
    public function setSpecialHoliday($special_holiday): void
    {
        $this->special_holiday = $special_holiday;
    }

    /**
     * @return mixed
     */
    public function getSpecialHolidayOt()
    {
        return $this->special_holiday_ot;
    }

    /**
     * @param mixed $special_holiday_ot
     */
    public function setSpecialHolidayOt($special_holiday_ot): void
    {
        $this->special_holiday_ot = $special_holiday_ot;
    }

    /**
     * @return mixed
     */
    public function getUniform()
    {
        return $this->uniform;
    }

    /**
     * @param mixed $uniform
     */
    public function setUniform($uniform): void
    {
        $this->uniform = $uniform;
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
    public function getSea()
    {
        return $this->sea;
    }

    /**
     * @param mixed $sea
     */
    public function setSea($sea): void
    {
        $this->sea = $sea;
    }

    /**
     * @return mixed
     */
    public function getCola()
    {
        return $this->cola;
    }

    /**
     * @param mixed $cola
     */
    public function setCola($cola): void
    {
        $this->cola = $cola;
    }

    /**
     * @return mixed
     */
    public function getLeave()
    {
        return $this->leave;
    }

    /**
     * @param mixed $leave
     */
    public function setLeave($leave): void
    {
        $this->leave = $leave;
    }

    /**
     * @return mixed
     */
    public function getAllowance()
    {
        return $this->allowance;
    }

    /**
     * @param mixed $allowance
     */
    public function setAllowance($allowance): void
    {
        $this->allowance = $allowance;
    }

    /**
     * @return mixed
     */
    public function getHeadGuardAllowance()
    {
        return $this->head_guard_allowance;
    }

    /**
     * @param mixed $head_guard_allowance
     */
    public function setHeadGuardAllowance($head_guard_allowance): void
    {
        $this->head_guard_allowance = $head_guard_allowance;
    }

    /**
     * @return mixed
     */
    public function getCtpa()
    {
        return $this->ctpa;
    }

    /**
     * @param mixed $ctpa
     */
    public function setCtpa($ctpa): void
    {
        $this->ctpa = $ctpa;
    }

    /**
     * @return mixed
     */
    public function getLegalHoliday()
    {
        return $this->legal_holiday;
    }

    /**
     * @param mixed $legal_holiday
     */
    public function setLegalHoliday($legal_holiday): void
    {
        $this->legal_holiday = $legal_holiday;
    }

    /**
     * @return mixed
     */
    public function getLegalHolidayOt()
    {
        return $this->legal_holiday_ot;
    }

    /**
     * @param mixed $legal_holiday_ot
     */
    public function setLegalHolidayOt($legal_holiday_ot): void
    {
        $this->legal_holiday_ot = $legal_holiday_ot;
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


}