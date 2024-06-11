<?php

namespace Application\models;



use Application\abstracts\RequisitionAbstract;

class Requisition extends RequisitionAbstract
{
    protected $CONNECTION;

    public $requisition_info;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, RequisitionAbstract::class);
        $this->init();
    }

    private function init(): void
    {
    global $APPLICATION;
    $this->requisition_info = $APPLICATION->FUNCTIONS->REQUISITION_INFO_CONTROL->filterRecords(["requisition_id"=>$this->requisition_id],true);
    $this->amount= $this->computeAmount($this->requisition_info);
    }

    private function computeAmount($requisition_info) {
        $total = 0;

        foreach ($requisition_info as $requisition) {
            $total += $requisition->amount;
        }

        return $total;
    }
}