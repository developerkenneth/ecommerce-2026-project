<?php

use App\Model\Product;
use App\Utilities\Helper;
use App\Utilities\Response;

require_once __DIR__ . "/../vendor/autoload.php";

header('Access-Control-Allow-Origin:*');
header("Content-Type: application/json");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$response = new Response();



// API END POINT FOR FETCH SINGLE PRODUCT
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


// API END POINT FOR FETCH ALL PRODUCTS
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

// API END POINT FOR POST SINGLE PRODUCT
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


        $acceptedFiles = ['jpeg', 'png', "jpg"];
        $fileExtentions = [];
        $badFileType = false;
        // check if it is an image
        foreach ($photos['name'] as $name) {

            $nameArray = explode(".", $name);
            $fileExtentions[] = end($nameArray);
            $fileType = end($nameArray);

            if (!in_array(strtolower($fileType), $acceptedFiles)) {
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

        $files = [];
        if (isset($fileExtentions) && !empty($fileExtentions)) {
            if (isset($photos) && !empty($photos)) {
                $i = 0;
                foreach ($photos['tmp_name'] as $tmp) {
                    // extentions
                    $filePath = "../assets/photos/";
                    $newFileName = \Ramsey\Uuid\v7();
                    $newFilePath = $filePath . $newFileName . "." . $fileExtentions[$i];
                    $photo = $newFileName . "." . $fileExtentions[$i];

                    move_uploaded_file($tmp, $newFilePath);
                    $files[] = $photo;
                    $i++;
                }

                $encodedPhotos = json_encode($files);
                $_POST['photos'] = $encodedPhotos;
                Product::create($_POST);
                http_response_code(201);
                echo json_encode([
                    'message' => 'product have been created successfully',
                    'success' => true
                ]);
                exit;
            }
        }

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
            'message' => 'please provide a product id',
            'success' => false
        ]);
        exit;
    }

    $id = $_GET['id'];

    // check if ID exist 
    $product = Product::find($id);

    if (empty($product)) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'invalid product ID, please check the check the product ID and try again',
            'success' => false
        ]);
        exit;
    }

    $emptyfields = '';
    $required_fields = ['price', 'name', 'description', 'brand', 'stocks_available'];
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
        Product::update($id, $datas);
        $response->statusCode(201)->jsonResponse([
            'message' => 'product update was successful',
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

// API END POINT FOR DELETE SINGLE PRODUCT
if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    // required fields

    // NOTE: work on verifying who is sending a particular request if it is the initial user that created it
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'please provide a product id',
            'success' => false
        ]);
        exit;
    }

    $id = $_GET['id'];

    // check if ID exist 
    $product = Product::find($id);

    if (empty($product)) {
        $response->statusCode(400)->jsonResponse([
            'message' => 'invalid product ID, please check the check the product ID and try again',
            'success' => false
        ]);
        exit;
    }



    try {

        if (Product::delete($id)) {
            $response->statusCode(204)->jsonResponse([
                'message' => 'product has been deleted successfully',
                'success' => true
            ]);
        }
    } catch (\Exception $err) {
        $response->statusCode(204)->jsonResponse([
            'message' => $err->getMessage(),
            'success' => true
        ]);
    }
}
