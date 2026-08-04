<?php

use App\Model\User;
use App\Utilities\Helper;
use App\Utilities\Response;

require_once __DIR__ . "/../vendor/autoload.php";


$response = new Response();

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    if (!isset($_GET['email'])  || empty($_GET['email'])) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'email cannot be empty',
            'success' => false
        ]);
        exit;
    }

    $email = $_GET['email'];

    if (!Helper::isEmail($email)) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'invalid email.',
            'success' => false
        ]);
        exit;
    }

    $user = User::find(['email' => $email]);

    if (empty($user)) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'no record found with this email',
            'success' => false
        ]);
        exit;
    }
    Mailer::sendMail("here is the link to your password ......", "another link /......", "forgot password");
    $response->statusCode(200)->jsonResponse([
        'message' => 'an email has been sent to your email',
        'success' => true
    ]);
    exit;
}
