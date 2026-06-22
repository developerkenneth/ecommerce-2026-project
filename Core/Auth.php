<?php

namespace App\Core;

use Exception;

class Auth
{
    public static function login($user)
    {
        try {
            $_SESSION['user_id'] = $user->id;
            unset($user->password);
            $_SESSION['user'] = $user;
            return true;
        } catch (\Exception $error) {
            return false;
        }
    }
}
