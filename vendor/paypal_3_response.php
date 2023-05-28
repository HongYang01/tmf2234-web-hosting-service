<?php

/*
################################
||                            ||
||  Get paymendId & PayerID   ||
||                            ||
################################
*/

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");

if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
    throw new Exception('The response is missing the paymentId or PayerID');
}

$paymentId = $_GET['paymentId'];
$payment = Payment::get($paymentId, $apiContext);

$execution = new PaymentExecution();
$execution->setPayerId($_GET['PayerID']);

/*
################################
||                            ||
||     INSERT data to db      ||
||                            ||
################################
*/

try {

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $currentDateTime = new DateTime('now', new DateTimeZone('Asia/Kuala_Lumpur'));
    $currentDateTimeString = $currentDateTime->format('Y-m-d H:i:s');

    // Take the payment
    $payment->execute($execution, $apiContext);

    $db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);

    $payment = Payment::get($paymentId, $apiContext);

    $data = [
        'product_id' => $payment->transactions[0]->item_list->items[0]->sku,
        'user_email' => $_SESSION['email'],
        'transaction_id' => $payment->getId(),
        'payment_amount' => $payment->transactions[0]->amount->total,
        'currency_code' => $payment->transactions[0]->amount->currency,
        'payment_status' => $payment->getState(),
        'invoice_id' => $payment->transactions[0]->invoice_number,
        'product_name' => $payment->transactions[0]->item_list->items[0]->name,
        'bill_date' => $currentDateTimeString,
        'maturity_date' => date('Y-m-d H:i:s', strtotime($currentDateTimeString . ' +1 month')),
        'description' => $payment->transactions[0]->description,
        'plan_status' => 1,
    ];

    if (addPayment($data) !== false && $data['payment_status'] === 'approved') {
        // Payment successfully added, redirect to the payment complete page.
        $inserids = $db->insert_id;
        header("location: /vendor/paypal_4_success.php?payid=" . $inserids . "");
        exit(1);
    }
} catch (Exception $e) {
    // Failed to take payment
    header("location: /vendor/paypal_5_failed.php");
    echo "Wrong";
    exit;
}


/**
 * Add payment to database
 *
 * @param array $data Payment data
 * @return int|bool ID of new payment or false if failed
 */
function addPayment($data)
{
    global $db;

    if (is_array($data)) {

        $stmt = $db->prepare('INSERT INTO `payments` (product_id, user_email, transaction_id, payment_amount, currency_code, payment_status, invoice_id, product_name, bill_date, maturity_date, plan_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param(
            'issdssssssi',
            $data['product_id'],
            $data['user_email'],
            $data['transaction_id'],
            $data['payment_amount'],
            $data['currency_code'],
            $data['payment_status'],
            $data['invoice_id'],
            $data['product_name'],
            $data['bill_date'],
            $data['maturity_date'],
            $data['plan_status']

        );

        if ($stmt->execute()) {
            $stmt->close();
            return $db->insert_id;
        }
    }

    return false;
}
