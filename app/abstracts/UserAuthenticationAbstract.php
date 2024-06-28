<?php

namespace Application\abstracts;

class UserAuthenticationAbstract extends ModelDefaultFunctions
{
    public $id;

    public $auth_type;

    public $username;

    public $password;

    public $pin;

    public $email_address;

    public $active;

    public $db_status;

}