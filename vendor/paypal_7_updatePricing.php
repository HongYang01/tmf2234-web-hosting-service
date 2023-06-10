<?php
/*######################################*
||                                    ||
||            Update Plan             ||
||                                    ||
*######################################*

pre-requisite:
- access_token
- plan_id
- plan_price

Work Flow:
1. Get access_token from [paypal_2_accessToken.php]
2. Request PayPal API to update pricing
3. PayPal return HTTP code 204

Note: 
- Pricing cannot be update here (see paypal_7_updatePricing.php)

*/

/*######################################*
||              Includes              ||
*######################################*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_2_accessToken.php");

$response = array();
$new_plan_info = array();
$access_token;

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
||          Check POST array          ||
*######################################*/

try {

    $post_element = ['plan_id', 'plan_price'];
    foreach ($post_element as $element) {
        if (!isset($_POST[$element]) || empty($_POST[$element])) {
            throw new Exception("Error: Missing POST value : " . $element);
        }
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}


$plan_id = $_POST['plan_id'];
$new_plan_info = [
    "pricing_schemes" => [
        [
            "billing_cycle_sequence" => 1,
            "pricing_scheme" => [
                "fixed_price" => [
                    "value" => $_POST['plan_price'],
                    "currency_code" => "USD"
                ]
            ]
        ]
    ]
];

/*######################################*
||          set URL options           ||
*######################################*/

try {
    $ch = curl_init();

    $url = "https://api-m.sandbox.paypal.com/v1/billing/plans/" . $plan_id . "/update-pricing-schemes";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($new_plan_info, true));

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: application/json';
    $headers[] = 'Authorization: Bearer ' . $access_token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // get response HTTP code
    curl_close($ch);

    if ($http_code >= 400 && $http_code < 600 && $http_code != 422) { // 422: no changes made or bad format (whcich is impossible)
        throw new Exception("PayPal Error " . $http_code . ": " . PAYPAL_HTTP_ERR_MSG($http_code));
    } else {
        unset($response);
        $response = ['HTTP' => $http_code]; // return 204 if success
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

mysqli_close($conn);
echo json_encode($response, true);
exit;
