<?php

namespace App\Core;

require_once("config.php");

use App\Utilities\Helper;
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

    // checks if user is lofgged in or not
    public static function isLoggedIn()
    {

        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public static function isAdmin()
    {
        if (!self::isLoggedIn() === true) {
            return false;
        }

        if ($_SESSION['user']->user_type === "admin") {
            return true;
        }

        return false;
    }

    //redirect a user to login page if the user is not logged in
    public static function loggedOutRedirect()
    {
        if (!self::isLoggedIn()) {
            Helper::redirect("login.php");
            return;
        }

        return;
    }


    public static function user()
    {
        return $_SESSION['user'];
    }

    public static function userId()
    {
        return $_SESSION['user_id'];
    }
}
