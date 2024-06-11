<?php

namespace Application\abstracts;

abstract class LoanPaymentAbstract extends ModelDefaultFunctions
{
    public $payment_id;

    public $employee_id;

    public $loans;
    public $loan_types;

    public $note;

    public $to_pay;

    public $period;

    public $year;

    public $date_created;

    public $db_status;


}