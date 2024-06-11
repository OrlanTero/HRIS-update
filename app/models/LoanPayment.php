<?php

namespace Application\models;

use Application\abstracts\LoanPaymentAbstract;

class LoanPayment extends LoanPaymentAbstract
{
    protected $CONNECTION;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, LoanPaymentAbstract::class);
        $this->init();
    }

    private function init(): void
    {

    }
}