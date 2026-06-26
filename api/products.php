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
