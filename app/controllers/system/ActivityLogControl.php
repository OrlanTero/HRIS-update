<?php

namespace Application\controllers\system;

use ActivityLogStatus;
use Application\abstracts\ControlDefaultFunctions;
use Application\models\ActivityLog;

class ActivityLogControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = ActivityLog::class;
    protected $TABLE_NAME = "activity_logs";
    protected $TABLE_PRIMARY_ID = "log_id";
    protected $SEARCH_LOOKUP = [];

    public function insert($category, $action, $status, $id="", $message = "")
    {
        global $SESSION;

        $data = [
            "category" => $category->value,
            "action" => $action->value,
            "status" => $status == 200 ? \ActivityLogStatus::SUCCESS->value : ActivityLogStatus::FAILED->value,
            "user" => $SESSION->id,
            "message" => $message,
            "id" => $id
        ];

        return $this->addRecord($data);
    }
}