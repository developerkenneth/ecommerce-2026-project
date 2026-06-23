<?php

use App\Model\Product;

require_once __DIR__ . "/../vendor/autoload.php";

header('Access-Control-Allow-Origin:*');
header("Content-Type: application/json");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');


if ($_SERVER['REQUEST_METHOD'] === "GET") {


    try {

        // show products
        http_response_code(200);
        $products = Product::getAll();
        echo json_encode([
            'message' => 'successfull',
            'success' => true,
            'products' => $products
        ]);
    } catch (\Exception $error) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => $error->getMessage()
        ]);
    }
}
