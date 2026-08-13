<?php

require_once("../vendor/autoload.php");

use App\Core\Auth;
use App\Model\User;
use App\Utilities\Helper;
use App\Utilities\Response;

$response = new Response();
$user = new User();
$errors = [];
// UPDATE USER API END POINT
if ($_SERVER['REQUEST_METHOD'] == "PUT") {


    // check if user is logged in
    if (!Auth::isLoggedIn()) {
        $response->statusCode(401)->jsonResponse(
            [
                'error' => 'unauthorized request',
                'success' => false
            ]
        );
        exit;
    }


    $requestData = file_get_contents("php://input");
    $datas = json_decode($requestData, true);

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $response->statusCode(400)->jsonResponse(
            [
                'error' => 'please provide a valid user id',
                'success' => false
            ]
        );
        exit;
    }


    $userId = $_GET['id'];


    // check if user request id matches auth id
    if (Auth::userId() !== $userId) {
        $response->statusCode(401)->jsonResponse(
            [
                'error' => 'unauthorized request',
                'success' => false
            ]
        );
        exit;
    }

    $userData  = $user->findUserById($userId);



    if (!$userData) {
        $response->statusCode(400)->jsonResponse(
            [
                'error' => 'please provide a valid  user id',
                'success' => false
            ]
        );
        exit;
    }

    $requiredFields = ['email', 'name'];

    if (empty($datas)) {

        $response->statusCode(400)->jsonResponse(
            [
                'error' => 'fields cannot be empty',
                'success' => false
            ]
        );
        exit;
    }


    foreach ($requiredFields as $field) {
        if (!isset($datas[$field])) {
            $errors[] = "$field is required ";
        }
    }


    foreach ($datas as $data => $value) {
        if (in_array($data, $requiredFields) && empty($value)) {
            $errors[] = "$data cannot be empty";
        }
    }


    if (!empty($errors)) {
        $response->statusCode(400)->jsonResponse([
            'error' => $errors,
            'success' => false
        ]);

        exit;
    }

    if (!Helper::isEmail($datas['email'])) {
        $response->statusCode(400)->jsonResponse([
            'error' => "invalid email",
            'success' => false
        ]);
        exit;
    }


    if (User::emailExist($datas['email']) && $userData['email'] !== $datas['email']) {
        $response->statusCode(400)->jsonResponse([
            'error' => "email already exist",
            'success' => false

        ]);
        exit;
    }


    try {

        User::update($userId, $datas);
        $response->statusCode(200)->jsonResponse([
            'message' => "user account has been updated successfully",
            'success' => false
        ]);
        exit;
    } catch (\PDOException) {
        $response->statusCode(500)->jsonResponse([
            'error' => "oops! something went wrong",
            'success' => false
        ]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);
    if (!isset($data['user_id'])) {
        $response->statusCode(404)->jsonResponse([
            'message' => 'please provide a valid user id',
            'success' => false
        ]);
        exit;
    }
    // colect user from the data base 
    $user = User::find(['id' => $data['user_id']]);

    if (empty($user)) {
        $response->statusCode(404)->jsonResponse([
            'message' => 'invalid user id',
            'success' => false
        ]);
        exit;
    }
    try {
        User::destroy($data['user_id']);
        $response->statusCode(204)->jsonResponse([
            'message' => "user has been deleted successfully",
            'success' => true
        ]);
        exit;
    } catch (\PDOException $err) {
        $response->statusCode(404)->jsonResponse([
            'message' => $err->getMessage(),
            'success' => false
        ]);
    }

    exit;
}


$response->statusCode(404)->jsonResponse("page not found");
