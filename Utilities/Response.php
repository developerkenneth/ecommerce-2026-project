<?php

namespace App\Utilities;

class Response
{
    public $staus = 200;
    public $data;

    public function statusCode($code)
    {
        $this->staus = $code;
        return $this;
    }

    public function jsonResponse($jsonData)
    {
        header("Content-Type:application/json");
        http_response_code($this->staus);
        echo json_encode($jsonData);
    }
}
