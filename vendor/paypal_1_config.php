<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/PayPal-PHP-SDK/autoload.php");

// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;

// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
$paypalConfig = [
    'client_id' => 'AcGiJABvQOLZrBw6RVcGvIRfjb7hUqlsbBVjvmake2oKdTjC3RtPMfvFI2wv0u99rKmkZpgTddQyva1v',
    'client_secret' => 'EMgusAapAohRmqlHBxQSuBJaO5BV9zJL2hZwMzk3LyRLsxiH4NYQqwqGpHTL8kGeksPiLWAah5fUgvwo',
    'return_url' => 'http://localhost/vendor/paypal_3_response.php',
    'cancel_url' => 'http://localhost/vendor/paypal_5_failed.php'
];

// Database settings. Change these for your database configuration.
$dbConfig = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'name' => 'id20654951_semicolonix'
];

$apiContext = getApiContext($paypalConfig['client_id'], $paypalConfig['client_secret'], $enableSandbox);
$apiContext->addRequestHeader('Accept-Language', 'en_GB'); // only in Great Britain english\


/**
 * Set up a connection to the API
 *
 * @param string $clientId
 * @param string $clientSecret
 * @param bool   $enableSandbox Sandbox mode toggle, true for test payments
 * @return \PayPal\Rest\ApiContext
 */
function getApiContext($clientId, $clientSecret, $enableSandbox = false)
{
    $apiContext = new ApiContext(
        new OAuthTokenCredential($clientId, $clientSecret)
    );

    $apiContext->setConfig([
        'mode' => $enableSandbox ? 'sandbox' : 'live'
    ]);

    return $apiContext;
}
