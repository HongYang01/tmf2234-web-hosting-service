<?php

require($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

$sub_id = "";
$u_email = "";
$response = array();
$paypal_sub_info = array();

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
    $response["success"] = "Subscription details saved";
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response, true);
exit;
