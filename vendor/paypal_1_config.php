<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/dotenv/vendor/autoload.php";

use Dotenv\Dotenv as Dotenv;

// Get dotenv
try {

    $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
    $dotenv->load();
} catch (Exception $e) {
    // Connection error occurred
    header("Location: /Error/404.php");
    exit;
}

// Paypal API Credentials
define("CLIENT_ID", $_ENV['PAYPAL_CLIENT_ID']);
define("CLIENT_SECRET", $_ENV['PAYPAL_CLIENT_SECRET']);
define("SUCCESS_URL", "/vendor/paypal_payment_success.php");
define("ERR_URL", "/vendor/paypal_payment_error.php");

function PAYPAL_HTTP_ERR_MSG(int $http_code)
{

    $message = "";

    switch ($http_code) {
        case 400:
            $message = "Request is not well-formed, check cURL format";
            break;
        case 401:
            $message = "PayPal credentials not match";
            break;
        case 404:
            $message = "The specified resource not found";
            break;
        case 405:
            $message = "Method not allowed";
            break;
        case 406:
            $message = "Media type not acceptable, check [Accept] in header";
            break;
        case 409:
            $message = "Threre are onflicts with another request";
            break;
        case 415:
            $message = "Unsupported media type, check [Content-Type] in header";
            break;
        case 422:
            $message = "Request action cannot be process";
            break;
        case 429:
            $message = "Too many requests / token exceeds a predefined value";
            break;
        case 500:
            $message = "PayPal internal server error, try again later";
            break;
        case 503:
            $message = "PayPal service unavailable, try again later";
            break;
        default:
            $message = "PayPal Uncaught Error";
    }

    return $message;
}
