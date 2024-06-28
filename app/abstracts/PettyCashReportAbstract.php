<?php

namespace Application\abstracts;

abstract class PettyCashReportAbstract extends ModelDefaultFunctions
{
    public $petty_cash_report_id;

    public $voucher;

    public $type;

    public $remarks;

    public $date_modify;

    public $cash_in;

    public $cash_out;

    public $date_created;

    public $db_status;


}