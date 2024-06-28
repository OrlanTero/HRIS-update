<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\UserProfile;

class UserProfileControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = UserProfile::class;
    protected $TABLE_NAME = "user_profile";
    protected $TABLE_PRIMARY_ID = "id";
    protected $SEARCH_LOOKUP = [];
    protected $CATEGORY = \ActivityLogCategories::PROFILE;

    public function getProfile()
    {
        $id = "MAIN_PROFILE";

        return $this->get($id, true);
    }

    public function edit($data)
    {
        return $this->editRecord("MAIN_PROFILE", $data);
    }
}