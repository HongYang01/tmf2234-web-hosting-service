<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");

function getPayPalAccessToken()
{

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_USERPWD, CLIENT_ID . ':' . CLIENT_SECRET);

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Accept-Language: en_US';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    curl_close($ch);

    if (!$result) {
        return null;
    } else {
        $response = json_decode($result, true);
        $access_token = $response['access_token']; // access the access_token using object style "->" because it returns as an object
        return $access_token;
    }
}
