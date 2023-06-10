<?php

require($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

$response = array();
$sub_id = "";
$u_email = "";
$paypal_trans_info = array();
$paypal_sub_info = array();

/*######################################*
||          Check POST array          ||
*######################################*/

try {

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $jsonData = file_get_contents('php://input');
        // Decode the JSON data and assign it back to $data
        $decodeData = json_decode($jsonData, true);

        if (!isset($decodeData['sub_id']) || empty($decodeData['sub_id'])) {
            throw new Exception("Subscription ID is not set");
        } else {
            $sub_id = $decodeData['sub_id'];
        }
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

/*######################################*
||           Check Identity           ||
*######################################*/
try {

    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
    if (!checkLoggedIn() || $_SESSION['role'] != "user") {
        header("Location: /pages/login_form.php");
        exit;
    } else {
        $u_email = $_SESSION['email'];
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

/*######################################
||    Get sub details from PayPal     ||
######################################*/
try {

    require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_get_sub_detail.php");
    $paypal_sub_info = paypalGetSubDetails($sub_id);

    if (key_exists("error", $paypal_sub_info)) {
        throw new Exception($paypal_sub_info['error']);
    }

    $sub_status = $paypal_sub_info['status'];
    $plan_id = $paypal_sub_info['plan_id'];


    $paypal_email = $paypal_sub_info['subscriber']['email_address'];
    $payer_id = $paypal_sub_info['subscriber']['payer_id'];
    $paypal_name = $paypal_sub_info['subscriber']['name']['given_name'] . " " . $paypal_sub_info['subscriber']['name']['surname'];

    $amount = $paypal_sub_info['billing_info']['last_payment']['amount']['value'];
    $currency_code = $paypal_sub_info['billing_info']['last_payment']['amount']['currency_code'];
    $bill_date = $paypal_sub_info['billing_info']['last_payment']['time'];

    $next_bill_date = $paypal_sub_info['billing_info']['next_billing_time'];

    /*######################################*
    ||       Store NEW subscription       ||
    *######################################*/

    $query = "INSERT INTO subscription (sub_status, sub_id, plan_id, u_email, paypal_email, paypal_name, payer_id, amount, currency_code, bill_date, next_bill_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssssdsss", $sub_status, $sub_id, $plan_id, $u_email, $paypal_email, $paypal_name, $payer_id, $amount, $currency_code, $bill_date, $next_bill_date);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error: cannot store subsription info to database, but payment is successful. Will update shortly");
    }
    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

/*######################################*
||     Get PayPal Payment History     ||
*######################################*/
try {

    sleep(3);
    $readyTrans = array();

    require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_get_transactionHistory.php");

    $paypal_trans_info = paypalGetPaymentHistory($sub_id);

    if (key_exists("error", $paypal_trans_info)) {
        throw new Exception($paypal_trans_info['error']);
    } else {
        $readyTrans = $paypal_trans_info['transactions'][0]; // first time payment
    }

    $trans_id = $readyTrans['id'];
    $trans_sub_id = $sub_id;
    $trans_status = $readyTrans['status'];
    $trans_currency_code = $readyTrans['amount_with_breakdown']['gross_amount']['currency_code'];
    $trans_gross_amount = $readyTrans['amount_with_breakdown']['gross_amount']['value'];
    $trans_fee_amount = $readyTrans['amount_with_breakdown']['fee_amount']['value'];
    $trans_net_amount = $readyTrans['amount_with_breakdown']['net_amount']['value'];
    $trans_datetime = $readyTrans['time'];

    $query = "INSERT INTO transaction (trans_id, trans_sub_id, trans_status, trans_currency_code, trans_gross_amount, trans_fee_amount, trans_net_amount, trans_datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssddds", $trans_id, $trans_sub_id, $trans_status, $trans_currency_code, $trans_gross_amount, $trans_fee_amount, $trans_net_amount, $trans_datetime);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Failed to execute query");
    }
    $response["success"] = "Transaction captured and saved";
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response, true);
exit;
