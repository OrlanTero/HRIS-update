<?php

namespace Application\abstracts;

 abstract class BankAccountAbstract extends ModelDefaultFunctions
{
    public $bank_account_id;

    public $employee_id;

    public $bank_id;

    public $account_number;

    public $active;

    public $db_status;

}