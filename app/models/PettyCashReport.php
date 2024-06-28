<?php

namespace Application\models;



use Application\abstracts\PettyCashReportAbstract;

class PettyCashReport extends PettyCashReportAbstract
{
    protected $CONNECTION;


    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, PettyCashReportAbstract::class);
        $this->init();
    }

    private function init(): void
    {


    }

}