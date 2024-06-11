<?php

namespace Application\models;



use Application\abstracts\DisbursementAbstract;


class Disbursement extends DisbursementAbstract
{
    protected $CONNECTION;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, DisbursementAbstract::class);
        $this->init();
    }

    private function init(): void
    {

    }
}