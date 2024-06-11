<?php

namespace Application\models;


use Application\abstracts\PettycashAbstract;

class Pettycash extends PettycashAbstract
{
    protected $CONNECTION;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, PettycashAbstract::class);
        $this->init();
    }

    private function init(): void
    {

    }
}