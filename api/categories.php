<?php
require_once("../vendor/autoload.php");

use App\Model\Model;
use App\Utilities\Response;

$response = new Response();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $raw_data = file_get_contents("php://input");
    $data = json_decode($raw_data, true);

    $name = isset($data['name']) ? $data['name']  : '';
    if (empty($name)) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'name is required',
            'success' => false
        ]);
        exit;
    }

    // check if category already exist
    $category = Model::find(['name' => $data['name']], 'categories');
    if (!empty((array)$category)) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'category already exist',
            'success' => false
        ]);
        exit;
    }

    try {
        Model::create($data, "categories");
        $response->statusCode(201)->jsonResponse([
            'message' => 'category created successfully',
            'success' => true
        ]);
        exit;
    } catch (\PDOException $err) {
        $response->statusCode(500)->jsonResponse([
            'message' => $err->getMessage(),
            'success' => false
        ]);
        exit;
    }
}

// API END POINT FOR UPDATE SINGLE PRODUCT
if ($_SERVER['REQUEST_METHOD'] === "PUT") {
    // required fields

    // NOTE: work on verifying who is sending a particular request if it is the initial user that created it
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'please provide a category id',
            'success' => false
        ]);
        exit;
    }

    $id = $_GET['id'];

    // check if ID exist 
    $category = Model::find(['id' => $id], 'categories');

    if (empty($category)) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'invalid category ID, please check the category ID and try again',
            'success' => false
        ]);
        exit;
    }

    $emptyfields = '';
    $required_fields = ['name'];
    $required = implode(', ', $required_fields);


    // if a field is set
    $rawDatas =  file_get_contents("php://input");
    $datas = json_decode($rawDatas, true);
    $errors = [];

    foreach ($required_fields as $field) {
        if (!isset($datas[$field])) {
            $errors[] = "$field is required ";
        }
    }

    foreach ($datas as $field => $value) {
        if (in_array($field, $required_fields) && empty($value)) {
            $errors[] = "$field, cannot be empty ";
        }
    }

    // assignment
    // check the price if it is less than 0.5
    // and other things you deem necessary


    if (!empty($errors)) {
        $response->statusCode(400)->jsonResponse([
            'message' => $errors,
            'success' => false
        ]);
        exit;
    }

    try {
        Model::update($id, $datas, 'categories');
        $response->statusCode(201)->jsonResponse([
            'message' => 'category update was successful',
            'success' => true
        ]);
    } catch (\PDOException $error) {
        $response->statusCode(500)->jsonResponse(
            [
                'message' => $error->getMessage(),
                'success' => false
            ]
        );
        exit;
    }
}
