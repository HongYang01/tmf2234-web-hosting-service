<?php
/*######################################*
||                                    ||
||          Create NEW Plan           ||
||                                    ||
*######################################*

pre-requisite:
- access_token
- prod_id
- required plan details ('prod_id', 'prod_name', 'plan_name', 'plan_desc', 'plan_price')

Work Flow:
1. Get access_token from [paypal_2_accessToken.php]
2. Use all details to request PayPal API to add new plan
3. Return JSON (with new plan_id)
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
||          Check POST array          ||
*######################################*/

try {
    $post_element = ['prod_id', 'prod_name', 'plan_name', 'plan_desc', 'plan_price'];
    foreach ($post_element as $element) {
        if (!isset($_POST[$element]) || empty($_POST[$element])) {
            throw new Exception("Error: [" . $element . "] is not set or empty");
        } else {
            $new_plan_info[$element] = $_POST[$element]; // assign new plan info
        }
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

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
||       Requesting new plan_id       ||
*######################################*/

try {

    $ready_plan_info = [
        'product_id' => $new_plan_info['prod_id'],
        'name' => $new_plan_info['plan_name'],
        'description' => $new_plan_info['plan_desc'],
        'billing_cycles' => [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => 1
                ],
                'tenure_type' => 'REGULAR',
                'sequence' => 1,
                'total_cycles' => 0,
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $new_plan_info['plan_price'],
                        'currency_code' => 'USD'
                    ]
                ]
            ]
        ],
        'payment_preferences' => [
            'auto_bill_outstanding' => true,
            'payment_failure_threshold' => 1,
            'setup_fee_failure_action' => 'CANCEL',
        ],
    ];

    /*######################################*
    ||          set URL options           ||
    *######################################*/

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/billing/plans');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ready_plan_info, true));

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

mysqli_close($conn);
echo json_encode($response, true);
exit;

// if success: save to database using [/handlers/admin_add_price_plan_handler.php]