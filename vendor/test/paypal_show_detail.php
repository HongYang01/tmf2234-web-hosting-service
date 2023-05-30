<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/test/paypal_1_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/test/paypal_2_accessToken.php");

$access_token = getPayPalAccessToken();
$planId = "P-0GM50921FC832453RMR2XKDY";

if ($access_token == null) {
    echo "Cannot show plan details.";
    exit;
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/billing/plans/' . $planId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer ' . rawurlencode($access_token);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$err = curl_errno($ch);
curl_close($ch);

if ($err) {
    echo 'cURL Error:' . $err;
} else {
    $response = json_decode($result);
    echo "<pre>";
    print_r($response);
    echo "</pre>";
}
curl_close($ch);
