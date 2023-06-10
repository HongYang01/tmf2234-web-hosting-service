<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/test/paypal_1_config.php");
// require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

if (!isset($_GET['access_token']) || !isset($_GET['product_id'])) {
    echo "BYE";
    exit;
} else {
    $access_token = $_GET['access_token'];
    $product_id = $_GET['product_id'];
}

$response = array();
$planInfo = array();

$planInfo = [
    'product_id' => $product_id,
    'name' => 'Testing Name',
    'description' => 'Testing Description',
    'billing_cycles' => [
        [
            'frequency' => [
                'interval_unit' => 'MONTH',
                'interval_count' => 1
            ],
            'tenure_type' => 'TRIAL',
            'sequence' => 1,
            'total_cycles' => 1
        ],
        [
            'frequency' => [
                'interval_unit' => 'MONTH',
                'interval_count' => 1
            ],
            'tenure_type' => 'REGULAR',
            'sequence' => 2,
            'total_cycles' => 0,
            'pricing_scheme' => [
                'fixed_price' => [
                    'value' => '10',
                    'currency_code' => 'USD'
                ]
            ]
        ]
    ],
    'payment_preferences' => [
        'auto_bill_outstanding' => true,
        'setup_fee_failure_action' => 'CANCEL',
    ],
];


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api-m.sandbox.paypal.com/v1/billing/plans');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($planInfo));


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer ' . rawurlencode($access_token);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$err = curl_errno($ch);
curl_close($ch);

if ($err) {
    header("location: paypal_err_page.php");
    echo 'Error:' . $err;
} else {
    $response = json_decode($result);
    $plan_id = $response->id;
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    header("location: paypal_5_cart.php?access_token=" . $access_token . "&plan_id=" . $plan_id);
}

exit;
