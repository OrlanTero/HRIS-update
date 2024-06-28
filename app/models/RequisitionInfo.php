<?php

namespace Application\models;




use Application\abstracts\RequisitioninfoAbstract;

class RequisitionInfo extends RequisitioninfoAbstract
{
    protected $CONNECTION;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, RequisitioninfoAbstract::class);
        $this->init();
    }

    private function init(): void
    {

    }
}