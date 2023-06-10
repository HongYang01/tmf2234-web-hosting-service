<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/test/paypal_1_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/test/paypal_2_accessToken.php");
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
$planInfo = array();
$uniqueid = md5(uniqid());

$access_token = getPayPalAccessToken();


if ($access_token == null) {
    echo "BYE";
    exit;
}

// Set product details
$prodInfo = [
    'name' => "Testing Name",
    'description' => "Testing Description",
    'type' => "SERVICE",
    'category' => "COMPUTER_AND_DATA_PROCESSING_SERVICES",
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/catalogs/products');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($prodInfo)); // must encode to JSON

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer ' . rawurlencode($access_token);
$headers[] = 'Paypal-Request-Id: ' . rawurlencode($uniqueid);

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // no need encode (need as ARRAY)

$result = curl_exec($ch);
$err = curl_errno($ch);
curl_close($ch);

if ($err) {
    echo 'cURL Error:' . $err;
} else {
    $response = json_decode($result);
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    header("location: paypal_4_createPlan.php?access_token=" . $access_token . "&product_id=" . $response->id);
}

exit;
