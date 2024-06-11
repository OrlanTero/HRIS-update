<?php

namespace Application\core;

use Application\abstracts\UserAbstract;
use Application\abstracts\UserProfileAbstract;
use Application\models\User;

class Session extends UserProfileAbstract
{
    public $hasUser = false;
    public $isAdmin = false;
    public $photoURL;

    public function __construct()
    {
        $this->hasUser = isset($_SESSION['user_id']);
    }

    public function apply($user): void
    {
        global $USER_TYPES_TEXT;

        $vars = get_class_vars(UserProfileAbstract::class);

        foreach (array_keys($vars) as $var) {
            if (property_exists($user, $var)) {
                $this->{$var} = $user->{$var};
            }
        }

//        $this->photoURL = $user->photoURL;
    }

    public function start(): void
    {
        $_SESSION["user_id"] = $this->id;
        $_SESSION["is_admin"] = true;
        $_SESSION["session"] = $this;

        $this->isAdmin = $_SESSION["is_admin"];
        $this->hasUser = isset($_SESSION["user_id"]);
    }

    public function logout()
    {
        global $KLEIN;

        $_SESSION['session'] = null;

        session_destroy();

        $KLEIN->response()->redirect('/login');
    }
}