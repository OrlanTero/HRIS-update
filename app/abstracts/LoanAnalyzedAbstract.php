<?php

namespace Application\abstracts;

abstract class LoanAnalyzedAbstract extends ModelDefaultFunctions
{
    public $loan_id;
    public $employee;

    public $date;

    public $description;

    public $times;

    /**
     * @return mixed
     */
    public function getTimes()
    {
        return $this->times;
    }


    public $principal;

    public $previous;

    public $forward;

    public $payments;

    public $recieved;

    public $balance;

    public $status;

    /**
     * @param mixed $times
     */
    public function setTimes($times): void
    {
        $this->times = $times;
    }
    /**
     * @return mixed
     */
    public function getLoanId()
    {
        return $this->loan_id;
    }

    /**
     * @param mixed $loan_id
     */
    public function setLoanId($loan_id): void
    {
        $this->loan_id = $loan_id;
    }



    /**
     * @return mixed
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param mixed $employee
     */
    public function setEmployee($employee): void
    {
        $this->employee = $employee;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * @param mixed $principal
     */
    public function setPrincipal($principal): void
    {
        $this->principal = $principal;
    }

    /**
     * @return mixed
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @param mixed $previous
     */
    public function setPrevious($previous): void
    {
        $this->previous = $previous;
    }

    /**
     * @return mixed
     */
    public function getForward()
    {
        return $this->forward;
    }

    /**
     * @param mixed $forward
     */
    public function setForward($forward): void
    {
        $this->forward = $forward;
    }

    /**
     * @return mixed
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param mixed $payments
     */
    public function setPayments($payments): void
    {
        $this->payments = $payments;
    }

    /**
     * @return mixed
     */
    public function getRecieved()
    {
        return $this->recieved;
    }

    /**
     * @param mixed $recieved
     */
    public function setRecieved($recieved): void
    {
        $this->recieved = $recieved;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public $db_status;

}