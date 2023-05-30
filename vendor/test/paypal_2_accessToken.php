<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/test/paypal_1_config.php");

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
    $err = curl_errno($ch);
    curl_close($ch);

    if ($err) {
        echo 'Error:' . $err;
        return null;
    } else {
        $response = json_decode($result);
        $access_token = $response->access_token; // access the access_token using object style "->" because it returns as an object
        // echo "<pre>";
        // print_r($response);
        // echo "</pre>";
        // header("location: /vendor/test/paypal_3_createProduct.php?access_token=" . $access_token);
        return $access_token;
    }
}
