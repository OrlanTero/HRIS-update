<?php

namespace Application\models;

use Application\abstracts\UserAuthenticationAbstract;

class UserAuthentication extends UserAuthenticationAbstract
{
    protected $CONNECTION;

    public function __construct($userData = [])
    {
        global $CONNECTION;

        $this->CONNECTION = $CONNECTION;
        $this->applyData($userData, UserAuthenticationAbstract::class);
        $this->init();
    }

    private function init(): void
    {

    }
}