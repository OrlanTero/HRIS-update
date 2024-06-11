<?php

namespace Application\models;

use Application\abstracts\LoanAbstract;

class Loan extends LoanAbstract
{
    protected $CONNECTION;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, LoanAbstract::class);
        $this->init();
    }

    private function init(): void
    {

    }
}