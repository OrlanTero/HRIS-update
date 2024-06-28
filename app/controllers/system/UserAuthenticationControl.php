<?php

namespace Application\controllers\system;

use Application\abstracts\ControlDefaultFunctions;
use Application\models\UserAuthentication;

class UserAuthenticationControl extends ControlDefaultFunctions
{
    protected $MODEL_CLASS = UserAuthentication::class;
    protected $TABLE_NAME = "user_authentication";
    protected $TABLE_PRIMARY_ID = "id";
    protected $SEARCH_LOOKUP = [];

    protected $CATEGORY = \ActivityLogCategories::AUTHENTICATION;
    public function SetAuthentication($type, $auth)
    {
        if ($type == \UserAuthenticationTypes::NO_AUTHENTICATION->value) {
            return $this->SetAuthenticationActive($type);
        }

        $this->SetAuthenticationActive($type);

        return $this->editRecordWhere(["auth_type" => $type], $auth);
    }

    public function SetAuthenticationActive($type)
    {
        $this->editRecordWhere(['active' => 2], ['active' => 1]);

        return $this->editRecordWhere(['auth_type' => $type], ['active' => 2]);
    }

    public function getCurrentUserAuthentication()
    {
        return $this->getOnlyRecord(['active' => 2], true);
    }
}