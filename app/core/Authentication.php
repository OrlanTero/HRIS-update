<?php

namespace Application\core;

use Application\controllers\app\EmailControl;
use Application\controllers\app\Response;
use Application\controllers\system\UserAuthenticationControl;
use Application\controllers\system\UserProfileControl;

class Authentication
{
    protected $CONNECTION;
    /**
     * @type Connection
     */
    protected $APPLICATION;
    /**
     * @type Session
     */
    protected $SESSION;

    public function __construct()
    {
        global $CONNECTION;
        global $APPLICATION;
        global $SESSION;


        $this->CONNECTION = $CONNECTION;
        $this->APPLICATION = $APPLICATION;
        $this->SESSION = $SESSION;
    }

    public function LoginWithAuth($type, $data)
    {
        global $APPLICATION;
        $control = new UserAuthenticationControl();
        $userControl = new UserProfileControl();

        $data['auth_type'] = $type;

        $exists = $control->alreadyExists($data);

        if ($exists->code === 200) {
            if ($type == \UserAuthenticationTypes::EMAIL_AUTHENTICATION->value) {

                $emailControl = $APPLICATION->FUNCTIONS->EMAIL_CONTROL;

                $send =  $emailControl->sendVerificationInto("MAIN_PROFILE", $data['email_address']);

                if ($send) {
                    return new Response(200, "Successfully Verification Sent!");
                }

                return new Response(205, "Email not Found!");
            } else {
                $user = $userControl->getProfile();

                $this->SESSION->apply($user, true);
                $this->SESSION->start();

                return  new Response(200, "Successfully Login!");
            }
        }

        return new Response(204, "Login Failed!");
    }
}