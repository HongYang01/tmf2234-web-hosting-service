<?php

/*######################################*
||              NOT USED              ||
||              NOT USED              ||
||              NOT USED              ||
||              NOT USED              ||
*######################################*/

/*######################################*
||              Includes              ||
*######################################*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_2_accessToken.php");

$response = array();
$new_prod_info = array();
$access_token;

/*######################################*
||          Check POST array          ||
*######################################*/

try {
    $post_element = ['prod_id', 'prod_name', 'prod_desc', 'prod_status'];
    foreach ($post_element as $element) {
        if (!isset($_POST[$element]) || empty($_POST[$element])) {
            throw new Exception("Error: [" . $element . "] is not set or empty");
        } else {
            $new_prod_info[$element] = $_POST[$element]; // assign new plan info
        }
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

// Set plan details
$ready_prod = [
    'id' => $_POST['prod_id'],
    'name' => $_POST['prod_name'],
    'description' => $_POST['prod_desc'],
    'type' => "SERVICE",
    'category' => "COMPUTER_AND_DATA_PROCESSING_SERVICES",
];

/*######################################*
||          Get access_token          ||
*######################################*/

try {
    $access_token = getPayPalAccessToken();
    if ($access_token == null) {
        throw new Exception("Error: Failed to request token from PayPal");
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

/*######################################*
||          set URL options           ||
*######################################*/
try {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/catalogs/products');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ready_prod)); // must encode to JSON

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: application/json';
    $headers[] = 'Authorization: Bearer ' . $access_token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch); // execute URL and return as JSON (set in Content-Type)
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // get response HTTP code
    curl_close($ch);

    if ($http_code >= 400 && $http_code < 600) {
        throw new Exception("PayPal Error " . $http_code . ": " . PAYPAL_HTTP_ERR_MSG($http_code));
    } else {
        unset($response);
        $response = json_decode($result, true);
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

// to-do: Save to databse

echo json_encode($response, true);
exit;
