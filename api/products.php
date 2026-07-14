<?php

use App\Model\Product;
use App\Utilities\Helper;

require_once __DIR__ . "/../vendor/autoload.php";

header('Access-Control-Allow-Origin:*');
header("Content-Type: application/json");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');




if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id']) && !empty($_GET['id'])) {
    $uuid = Helper::sanitize($_GET['id']);
    try {

        // show products
        http_response_code(200);
        $product = Product::find($uuid);
        echo json_encode([
            'message' => 'successful',
            'success' => true,
            'product' => $product
        ]);
        exit;
    } catch (\Exception $error) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => $error->getMessage()
        ]);

        exit;
    }
}



if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $filters = [];

    if (isset($_GET['max_price'])) $filters['max_price'] = $_GET['max_price'];
    if (isset($_GET['search'])) $filters['search'] = $_GET['search'];
    if (isset($_GET['min_price'])) $filters['min_price'] = $_GET['min_price'];


    try {

        // show products
        http_response_code(200);
        $products = Product::getAll($filters);
        echo json_encode([
            'message' => 'successfull',
            'success' => true,
            'products' => $products
        ]);
        exit;
    } catch (\Exception $error) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => $error->getMessage()
        ]);
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // required fields

    $emptyfields = '';
    $required_fields = ['price', 'name', 'description', 'brand', 'stocks_available'];
    $required = implode(', ', $required_fields);

    $errors = [];



    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            $errors[] = "$field is required ";
        }
    }


    if (!empty($emptyfields)) {
        $errors[] = "the following fields: $emptyfields cannot be empty";
    }

    foreach ($_POST as $field => $value) {
        if (empty($value) && in_array($field, $required_fields)) {
            $emptyfields .= "$field, ";
        }
    }


    if (isset($_FILES['photos'])) {
        $photos = $_FILES['photos'];
        $failSizeCheck = false;

        foreach ($photos['size'] as $fileSize) {
            if (Helper::isLargeFile($fileSize)) {
                $failSizeCheck = true;
            }
        }


        if ($failSizeCheck) {
            $errors['large_file'] = "file too large";

            echo json_encode(
                [
                    'errors' => $errors,
                    'success' => false
                ]
            );
            http_response_code(400);
            exit;
        }
    }



    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode([
            "errors" => $errors,
            "success" => false
        ]);
        exit;
    }



    if (is_numeric($_POST['price']) && (int) $_POST['price'] < 0.5) {
        $errors[] = "price should not be less than 0.5";
        http_response_code(400);
        echo json_encode([
            "errors" => $errors,
            "success" => false
        ]);
        exit;
    }

    if (is_numeric($_POST['stocks_available']) && (int) $_POST['stocks_available'] < 1) {
        $errors[] = "stocks_available should not be less than 1";
        http_response_code(400);
        echo json_encode([
            "errors" => $errors,
            "success" => false
        ]);
        exit;
    }


    // go ahead to create new product
    try {
        Product::create($_POST);
        http_response_code(201);
        echo json_encode([
            'message' => 'product have been created successfully',
            'success' => true
        ]);
        exit;
    } catch (\Exception $error) {
        echo json_encode([
            'errors' => ['server_error' => $error->getMessage()],
            'success' => true
        ]);
        exit;
    }
}
