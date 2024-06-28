<?php

namespace Application\models;

use Application\abstracts\LoanAnalyzedAbstract;

class LoanAnalyzed extends LoanAnalyzedAbstract
{
    protected $CONNECTION;

    public function __construct($employee)
    {
        $this->employee  = $employee;
    }

    private function init(): void
    {

    }
}