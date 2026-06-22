<?php

namespace App\Core;

class Session
{
    public static function csrf()
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
