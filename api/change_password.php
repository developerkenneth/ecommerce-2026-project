<?php
require_once __DIR__ . "/../vendor/autoload.php";

use App\Core\Auth;
use App\Model\User;
use App\Utilities\Helper;
use App\Utilities\Response;

$response = new Response();


if (!Auth::isLoggedIn()) {

    $response->statusCode(401)->jsonResponse([
        "message" => "authorization failed",
        "success" => false
    ]);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === "PATCH") {

    // get datas 
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    // check if password is empty

    if (empty($data)) {
        $response->statusCode(400)->jsonResponse([
            "message" => "please fill in the required fields: password, old password, confirm password",
            "success" => false
        ]);
        exit;
    }


    // check if password match
    if (!isset($data['id'])  || empty($data['id'])) {
        $response->statusCode(400)->jsonResponse([
            "message" => "user id is required",
            "success" => false
        ]);
        exit;
    }


    // check if password is empty

    if (!isset($data['password']) || empty($data['password'])) {
        $response->statusCode(400)->jsonResponse([
            "message" => "password is required ",
            "success" => false
        ]);
        exit;
    }


    // check if confirm password is empty

    if (!isset($data['confirm_password']) || empty($data['confirm_password'])) {
        $response->statusCode(400)->jsonResponse([
            "message" => "confirm_password is required ",
            "success" => false
        ]);
        exit;
    }


    // check if old password is empty
    if (!isset($data['old_password']) || empty($data['old_password'])) {
        $response->statusCode(400)->jsonResponse([
            "message" => "old_password is required ",
            "success" => false
        ]);
        exit;
    }

    // check if password match
    if ($data['password'] !== $data['confirm_password']) {
        $response->statusCode(400)->jsonResponse([
            "message" => "password does not match",
            "success" => false
        ]);
        exit;
    }


    // get user from data base 
    $user = User::find(['id' => $data['id']]);

    // check if id is valid
    if (empty($user)) {
        $response->statusCode(404)->jsonResponse([
            "message" => "invalid user id",
            "success" => false
        ]);
        exit;
    }


    if (!Helper::verifyPassword($data['old_password'], $user->password )) {
        $response->statusCode(400)->jsonResponse([
            "message" => "current password does not match",
            "success" => false
        ]);
        exit;
    }

    try {

        $passwordHashed = Helper::hasPassword($data['password']);
        User::update($data['id'], ['password' => $passwordHashed]);
        // send email to user
        $response->statusCode(201)->jsonResponse([
            "message" => "password has been changed successfully.",
            "success" => true
        ]);
        exit;
    } catch (\PDOException $error) {
        $response->statusCode(500)->jsonResponse([
            "message" => "oops! failed to change password, something went wrong.",
            "success" => false
        ]);
        exit;
    }
}


$response->statusCode(404)->jsonResponse("page not found");
