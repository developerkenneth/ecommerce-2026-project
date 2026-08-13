<?php

namespace App\Utilities;

require_once __DIR__ . "/../Core/config.php";
class Helper
{

    public static function sanitize($string)
    {
        return htmlspecialchars(trim($string));
    }

    public static function getOld($fieldName)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            if (isset($_GET[$fieldName]) && !empty($_GET[$fieldName])) {
                return $_GET[$fieldName];
            }
        } else if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST[$fieldName]) && !empty($_POST[$fieldName])) {
                return $_POST[$fieldName];
            }
        }
    }

    public static function hasPassword($passwordString)
    {
        // hash the password 
        $hashedPassword = password_hash($passwordString, PASSWORD_DEFAULT);
        return $hashedPassword;
    }

    public static function verifyPassword($passwordString, $hashedPassword)
    {
        return password_verify($passwordString, $hashedPassword);
    }

    public static function redirect($url)
    {
        header("location:" . WWW_ROOT . "/$url");
    }

    public static function isLargeFile($file_size)
    {
        return $file_size > 4000000 ? true : false;
    }

    public static function isEmail($emailString)
    {
        return filter_var($emailString, FILTER_VALIDATE_EMAIL);
    }
}
