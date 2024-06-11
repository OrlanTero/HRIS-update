<?php

namespace Application\abstracts;

abstract class LoanAbstract extends ModelDefaultFunctions
{
    public $loan_id;

    public $employee_id;

    public $amount;
    public $balance;

    public $target_date;

    public $loan_type;

    public $description;

    public $status;

    public $date_created;

    public $db_status;

}