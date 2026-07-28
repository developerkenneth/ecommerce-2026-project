<?php

use App\Model\Product;
use App\Utilities\Helper;
use App\Utilities\Response;

require_once __DIR__ . "/../vendor/autoload.php";

session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

$response = new Response();


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    $response->statusCode(405)->jsonResponse([
        "success" => false,
        "message" => "Method not allowed"
    ]);

    exit;
}

if (!isset($_SESSION["id"])) {
    $response->statusCode(401)->jsonResponse([
        "success" => false,
        "message" => "Please login first."
    ]);

    exit;
}

    $requiredFields = ['price', 'name', 'description', 'brand', 'stocks_available'];
    $required = implode(', ', $requiredFields);
    $errors = [];

    foreach ($requiredFields as $field) {
        if (
            !isset($_POST[$field]) || empty(trim($_POST[$field]))
        ) {
            $errors[] = "$field is required.";
        }
    }


if (!empty($emptyfields)) {

    $response->statusCode(400)->jsonResponse([
        "success" => true,
        "message" => "fill in the following $emptyfields"
    ]);
    $errors = "the following fields: $emptyfields cannot be empty";
}

$_POST["name"] = Helper::sanitize($_POST["name"]);
$_POST["brand"] = Helper::sanitize($_POST["brand"]);
$_POST["price"] = Helper::sanitize($_POST["price"]);
$_POST["description"] = Helper::sanitize($_POST["description"]);
$_POST["stocks_available"] = Helper::sanitize($_POST["stocks_available"]);
$_POST ["category"] = Helper::sanitize($_POST ["category"]);
if (is_numeric($_POST["price"]) &&  (float)$_POST["price"] > 0  && (float)$_POST['price'] < 0.5) {

    $errors[] = 'price must be at least 0.5';
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $errors
    ]);
    exit;
}


if (is_numeric($_POST["stocks_available"]) &&   (int) $_POST["stocks_available"] < 1) {

    $errors[] = 'stocks_available should`nt be less 1';
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $errors
    ]);
    exit;


} 

    


if (isset($_FILES['photos'])) {
    $photos = $_FILES['photos'];


    $acceptedFiles = ['jpeg', 'png', "jpg"];
    $fileExtentions = [];
    $badFileType = false;
    // check if it is an image
    foreach ($photos['name'] as $name) {

        $nameArray = explode(".", $name);
        $extension = strtolower(end($nameArray));
        $fileExtentions[] = $extension;
        $fileType = $extension;

        if (!in_array($fileType, $acceptedFiles)) {
            $badFileType = true;
        }
    }

    if ($badFileType) {
        http_response_code(400);
        echo json_encode([
            'message' => 'only accepts "jpeg, png and jpg"',
            'success' => false
        ]);
        exit;
    }

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
        'success' => false,
        'error' => $errors
    ]);
    exit;
}

// go ahead and create the product

try {
    $files = [];
    if (isset($fileExtentions) && is_array($fileExtentions) && !empty($fileExtentions)) {
        if (isset($photos) && !empty($photos)) {
            $i = 0;
            foreach ($photos['tmp_name'] as $tmp) {
                // extentions
                $filePath = __DIR__ . "/../assets/photos/";
                $newFileName = \Ramsey\Uuid\v7();
                $newFilePath = $filePath . $newFileName . "." . $fileExtentions[$i];
                $photo = $newFileName . "." . $fileExtentions[$i];

                if (!move_uploaded_file($tmp, $newFilePath)) {

                    throw new \Exception("Failed to upload image.");
                }
                $files[] = $photo;
                $i++;
            }
            if (!empty($files)) {
                $_POST["photos"] = json_encode($files);
            
            }

            Product::create($_POST);
            http_response_code(201);
            echo json_encode([
                'message' => 'product have been created successfully',
                'success' => true
            ]);
            exit;
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'errors' => ['server_error' => $e->getMessage()],
        'success' => false
    ]);
}

exit;


// updating the product 