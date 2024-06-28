<?php

namespace Application\abstracts;

abstract class ActivityLogAbstract extends ModelDefaultFunctions
{
    public $log_id;

    public $category;

    public $action;

    public $status;

    public $user;

    public $message;

    public $id;

    public $db_status;

    public $date_created;
}