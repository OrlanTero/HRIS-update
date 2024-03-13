<?php

namespace Application\models;

use Application\abstracts\BankAccountAbstract;

class BankAccount extends BankAccountAbstract
{
    protected $CONNECTION;

    public $name;

    public $bank;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, BankAccountAbstract::class);
        $this->init();
    }

    private function init(): void
    {
        global $APPLICATION;

        $control = $APPLICATION->FUNCTIONS->BANK_CONTROL;

        $this->bank = $control->get($this->bank_id, true);
    }
}