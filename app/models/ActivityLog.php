<?php

namespace Application\models;

use Application\abstracts\ActivityLogAbstract;

class ActivityLog extends ActivityLogAbstract
{
    protected $CONNECTION;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, ActivityLogAbstract::class);
        $this->init();
    }

    private function init(): void
    {

    }
}