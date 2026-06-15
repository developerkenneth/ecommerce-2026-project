<?php

namespace App\Utilities;

class Helper
{

    public static function sanitize($string)
    {
        return htmlspecialchars(trim($string));
    }
}
