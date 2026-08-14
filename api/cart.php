<?php

use App\Core\Auth;
use App\Model\Cart;
use App\Model\Product;
use App\Utilities\Helper;
use App\Utilities\Response;

require_once __DIR__ . "/../vendor/autoload.php";

session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$response = new Response();

//   AUTHENTICATION


if (!Auth::isLoggedIn()) {

    $response->statusCode(401)->jsonResponse([
        'success' => false,
        'message' => 'Please login to use your cart.'
    ]);

    exit;
}

$userId = Auth::userId();


// ==========================================
// GET CART
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    try {
        $items = Cart::getUserCart($userId);

        $subtotal = 0;
        $totalItems = 0;

        foreach ($items as &$item) {

            $price = (float) $item['price'];

            $discount = (float) (
                $item['discount_percentage'] ?? 0
            );

            $finalPrice = $price;

            if ($discount > 0) {

                $finalPrice =
                    $price - (
                        $price * ($discount / 100)
                    );
            }

            $item['unit_price'] = $finalPrice;

            $item['line_total'] =
                $finalPrice * (int) $item['quantity'];

            $subtotal +=
                $item['line_total'];

            $totalItems +=
                (int) $item['quantity'];
        }

        $response->statusCode(200)->jsonResponse([
            'success' => true,
            'cart' => [
                'items' => $items,
                'total_items' => $totalItems,
                'subtotal' => $subtotal
            ]
        ]);

        exit;
    } catch (\Exception $error) {

        $response->statusCode(500)->jsonResponse([
            'success' => false,
            'message' => $error->getMessage()
        ]);

        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rawData = file_get_contents("php://input");

    $data = json_decode($rawData, true);

    $productUuid = $data['product_uuid'] ?? null;
    $quantity = (int) ($data['quantity'] ?? 1);


    if (!$productUuid) {

        $response->statusCode(400)->jsonResponse([
            'success' => false,
            'message' => 'Product UUID is required.'
        ]);

        exit;
    }


    if ($quantity < 1) {

        $response->statusCode(400)->jsonResponse([
            'success' => false,
            'message' => 'Quantity must be at least 1.'
        ]);

        exit;
    }


    $product = Product::find($productUuid);

    if (empty($product)) {

        $response->statusCode(404)->jsonResponse([
            'success' => false,
            'message' => 'Product not found.'
        ]);

        exit;
    }

    $product = (array) $product;

    $stock = (int) $product['stocks_available'];


    $existing = Cart::findItem(
        $userId,
        $productUuid
    );


    $requestedQuantity = $quantity;


    if ($existing) {

        $requestedQuantity =
            (int) $existing['quantity'] + $quantity;
    }


    if ($requestedQuantity > $stock) {

        $response->statusCode(400)->jsonResponse([
            'success' => false,
            'message' => "Only {$stock} items are available."
        ]);

        exit;
    }
    try {

        $saved = Cart::add(
            $userId,
            $productUuid,
            $quantity
        );

        $cartItem = Cart::findItem(
            $userId,
            $productUuid
        );


        if (!$saved) {

            $response->statusCode(500)->jsonResponse([
                'success' => false,
                'message' => 'The product could not be added to your cart.',
                'debug' => [
                    'user_id' => $userId,
                    'product_uuid' => $productUuid,
                    'quantity' => $quantity,
                    'saved' => $saved,
                    'cart_item' => $cartItem
                ]
            ]);

            exit;
        }


        $response->statusCode(201)->jsonResponse([
            'success' => true,
            'message' => 'Product added to cart.',
            'debug' => [
                'user_id' => $userId,
                'product_uuid' => $productUuid,
                'quantity' => $quantity,
                'saved' => $saved,
                'cart_item' => $cartItem
            ]
        ]);

        exit;
    } catch (\PDOException $error) {

        $response->statusCode(500)->jsonResponse([
            'success' => false,
            'message' => $error->getMessage()
        ]);

        exit;
    }
}


// ==========================================
// UPDATE QUANTITY
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $rawData =
        file_get_contents("php://input");

    $data =
        json_decode($rawData, true);

    $productUuid =
        $data['product_uuid'] ?? null;

    $quantity =
        (int) ($data['quantity'] ?? 0);


    if (!$productUuid || $quantity < 1) {

        $response->statusCode(400)->jsonResponse([
            'success' => false,
            'message' => 'Product UUID and valid quantity are required.'
        ]);

        exit;
    }


    $product =
        Product::find(
            Helper::sanitize($productUuid)
        );


    if (empty($product)) {

        $response->statusCode(404)->jsonResponse([
            'success' => false,
            'message' => 'Product not found.'
        ]);

        exit;
    }


    if (
        $quantity >
        (int) $product['stocks_available']
    ) {

        $response->statusCode(400)->jsonResponse([
            'success' => false,
            'message' =>
            "Only {$product['stocks_available']} items are available."
        ]);

        exit;
    }


    try {

        Cart::updateQuantity(
            $userId,
            $productUuid,
            $quantity
        );

        $response->statusCode(200)->jsonResponse([
            'success' => true,
            'message' => 'Cart quantity updated.'
        ]);

        exit;
    } catch (\Exception $error) {

        $response->statusCode(500)->jsonResponse([
            'success' => false,
            'message' => $error->getMessage()
        ]);

        exit;
    }
}

// ==========================================
// CLEAR CART
// ==========================================

if (
    $_SERVER['REQUEST_METHOD'] === 'DELETE'
    && isset($_GET['clear'])
) {

    Cart::clear($userId);

    $response->statusCode(200)->jsonResponse([
        'success' => true,
        'message' => 'Cart cleared successfully.'
    ]);

    exit;
}


$response->statusCode(405)->jsonResponse([
    'success' => false,
    'message' => 'Method not allowed.'
]);



// ==========================================
// REMOVE ITEM
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $rawData =
        file_get_contents("php://input");

    $data =
        json_decode($rawData, true);

    $productUuid =
        $data['product_uuid'] ?? null;


    if (!$productUuid) {

        $response->statusCode(400)->jsonResponse([
            'success' => false,
            'message' => 'Product UUID is required.'
        ]);

        exit;
    }


    try {

        Cart::remove(
            $userId,
            Helper::sanitize($productUuid)
        );

        $response->statusCode(200)->jsonResponse([
            'success' => true,
            'message' => 'Product removed from cart.'
        ]);

        exit;
    } catch (\Exception $error) {

        $response->statusCode(500)->jsonResponse([
            'success' => false,
            'message' => $error->getMessage()
        ]);

        exit;
    }
}
