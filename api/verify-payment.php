<?php

use App\Core\Auth;
use App\Model\Cart;
use App\Utilities\Response;

require_once __DIR__ . "/../vendor/autoload.php";

session_start();

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$response = new Response();


/*
|--------------------------------------------------------------------------
| OPTIONS
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

    http_response_code(204);

    exit;
}


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

if (!Auth::isLoggedIn()) {

    $response->statusCode(401)->jsonResponse([
        'success' => false,
        'message' => 'Please login before verifying payment.'
    ]);

    exit;
}


$userId = Auth::userId();


// | METHOD



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    $response->statusCode(405)->jsonResponse([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);

    exit;
}


// | READ REQUEST


$rawData =
    file_get_contents("php://input");


$data =
    json_decode(
        $rawData,
        true
    );


$reference =
    trim(
        $data['reference'] ?? ''
    );


if ($reference === '') {

    $response->statusCode(400)->jsonResponse([
        'success' => false,
        'message' => 'Payment reference is required.'
    ]);

    exit;
}


// PAYSTACK SECRET KEY


$secretKey = null;


if (
    defined('PAYSTACK_SECRET_KEY') &&
    PAYSTACK_SECRET_KEY
) {

    $secretKey =
        PAYSTACK_SECRET_KEY;
}


if (!$secretKey) {

    $secretKey =
        getenv('PAYSTACK_SECRET_KEY');
}


if (!$secretKey) {

    $response->statusCode(500)->jsonResponse([
        'success' => false,
        'message' =>
        'Paystack secret key is not configured on the server.'
    ]);

    exit;
}


// | GET CURRENT CART


try {

    $cartItems =
        Cart::getUserCart(
            $userId
        );


    if (empty($cartItems)) {

        $response->statusCode(400)->jsonResponse([
            'success' => false,
            'message' =>
            'Your cart is empty.'
        ]);

        exit;
    }


    $expectedAmount = 0;


    foreach ($cartItems as $item) {

        $price =
            (float) $item->price;


        $discount =
            (float) (
                $item->discount_percentage ?? 0
            );


        $unitPrice =
            $price;


        if ($discount > 0) {

            $unitPrice =
                $price -
                (
                    $price *
                    ($discount / 100)
                );
        }


        $quantity =
            (int) $item->quantity;


        $expectedAmount +=
            $unitPrice * $quantity;
    }


  
    //  * Paystack expects amounts in
    //  * the currency subunit.
    //  *
    //  * For NGN:
    //  * ₦1 = 100 kobo.
    

    $expectedPaystackAmount =
        (int) round(
            $expectedAmount * 100
        );
} catch (\Exception $error) {

    $response->statusCode(500)->jsonResponse([
        'success' => false,
        'message' =>
        'Unable to calculate your cart total.'
    ]);

    exit;
}


// | VERIFY WITH PAYSTACK


$verifyUrl =
    "https://api.paystack.co/transaction/verify/" .
    rawurlencode($reference);


$curl =
    curl_init(
        $verifyUrl
    );


curl_setopt_array(
    $curl,
    [
        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer {$secretKey}",
            "Content-Type: application/json",
            "Accept: application/json"
        ],

        CURLOPT_TIMEOUT => 30,

        CURLOPT_SSL_VERIFYPEER => true,

        CURLOPT_SSL_VERIFYHOST => 2
    ]
);


$paystackResponse =
    curl_exec($curl);


$curlError =
    curl_error($curl);


$httpCode =
    curl_getinfo(
        $curl,
        CURLINFO_HTTP_CODE
    );


curl_close($curl);


if ($paystackResponse === false) {

    $response->statusCode(502)->jsonResponse([
        'success' => false,
        'message' =>
        'Unable to connect to Paystack.'
    ]);

    exit;
}


$paystackData =
    json_decode(
        $paystackResponse,
        true
    );


if (!is_array($paystackData)) {

    $response->statusCode(502)->jsonResponse([
        'success' => false,
        'message' =>
        'Paystack returned an invalid response.'
    ]);

    exit;
}

// | PAYSTACK REQUEST FAILED

if (
    $httpCode < 200 ||
    $httpCode >= 300 ||
    empty($paystackData['status'])
) {

    $response->statusCode(400)->jsonResponse([
        'success' => false,
        'message' =>
        $paystackData['message'] ??
            'Payment verification failed.'
    ]);

    exit;
}



// | TRANSACTION DATA


$transaction =
    $paystackData['data']
    ?? null;


if (!is_array($transaction)) {

    $response->statusCode(400)->jsonResponse([
        'success' => false,
        'message' =>
        'Paystack returned no transaction data.'
    ]);

    exit;
}


$transactionStatus =
    $transaction['status']
    ?? null;


$transactionReference =
    $transaction['reference']
    ?? null;


$transactionAmount =
    (int) (
        $transaction['amount']
        ?? 0
    );


$transactionCurrency =
    $transaction['currency']
    ?? null;


// | VERIFY REFERENCE


if (
    $transactionReference !==
    $reference
) {

    $response->statusCode(400)->jsonResponse([
        'success' => false,
        'message' =>
        'Payment reference does not match.'
    ]);

    exit;
}

// verify status

if (
    $transactionStatus !==
    'success'
) {

    $response->statusCode(400)->jsonResponse([
        'success' => false,
        'message' =>
        'Payment was not successful.'
    ]);

    exit;
}


// verify currency

if (
    strtoupper($transactionCurrency) !==
    'NGN'
) {

    $response->statusCode(400)->jsonResponse([
        'success' => false,
        'message' =>
        'Unexpected payment currency.'
    ]);

    exit;
}


// verify payment

if (
    $transactionAmount !==
    $expectedPaystackAmount
) {

    $response->statusCode(400)->jsonResponse([
        'success' => false,
        'message' =>
        'Payment amount does not match the cart total.'
    ]);

    exit;
}



// payment sucess

try {

    Cart::clear(
        $userId
    );


    $response->statusCode(200)->jsonResponse([
        'success' => true,

        'message' =>
        'Payment verified successfully.',

        'payment' => [
            'reference' =>
            $transactionReference,

            'amount' =>
            $transactionAmount,

            'currency' =>
            $transactionCurrency,

            'status' =>
            $transactionStatus
        ]
    ]);

    exit;
} catch (\Exception $error) {

    $response->statusCode(500)->jsonResponse([
        'success' => false,
        'message' =>
        'Payment was verified, but your cart could not be cleared.'
    ]);

    exit;
}
