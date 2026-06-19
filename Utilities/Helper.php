<?php

namespace App\Utilities;

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
}
