<?php

namespace Application\models;



use Application\abstracts\AdjustmentAbstract;



class Adjustment extends AdjustmentAbstract
{
    protected $CONNECTION;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, AdjustmentAbstract::class);
        $this->init();
    }

    private function init(): void
    {

    }
}