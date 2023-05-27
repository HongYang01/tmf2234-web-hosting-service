<?php


// TODO: try subscribtion payment (recurring payment)

/*
################################
||                            ||
||       Check loggedin       ||
||                            ||
################################
*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    $response = array('success' => false, 'redirect' => "/pages/login_form.php");
    echo json_encode($response);
    exit;
}

$userEmail = $_SESSION['email'];

/*
################################
||                            ||
||    Include Paypal APIs     ||
||                            ||
################################
*/

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\ItemList;

// Get the raw request body
// using file_get_contents() because the data is send using JSON/XML (non-traditional method as using form's action)
$requestBody = file_get_contents('php://input');

// Parse the JSON data
$requestData = json_decode($requestBody, true);

if (!isset($requestData['prod_id']) || empty($requestData['prod_id'])) {
    $response = array('success' => false, 'message' => "This script should not be called directly, expected post data");
    echo json_encode($response);
    exit;
}

/*
################################
||                            ||
||    db Query for product    ||
||                            ||
################################
*/


try {

    $query = "SELECT * FROM product WHERE prod_id = " . mysqli_real_escape_string($conn, $requestData['prod_id']) . "";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) !== 1) {
        // Handle the error gracefully, such as displaying an error message or redirecting
        $response = array('success' => false, 'message' => "Product not found or failed to execute query");
        echo json_encode($response);
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $item_code = $row['prod_id'];
    $prodCategory = $row['prod_category']; // get product category for checking
    $product_name = $row['prod_category'] . " Hosting (" . $row['prod_title'] . ")"; // combine name
    $amountPayable = $row['prod_price'];

    $currency = 'USD';
    $item_qty = 1;
    $description = 'Paypal transaction';
    $invoiceNumber = uniqid();

    $my_items = array(
        array(
            'name' => $product_name,
            'quantity' => $item_qty,
            'price' => $amountPayable,
            'sku' => $item_code,
            'currency' => $currency
        )
    );

    /*
    ################################
    ||                            ||
    ||  Check user plan crashed   ||
    ||                            ||
    ################################
    
    1. Get user email and check on the payment table
    2. Check associated prod_category & payment date
    3. Compare category
    4. Compare date (< 30 days)
    5. If crashed, return success: false
    */

    $query2 = "SELECT 
        payments.product_id AS pay_prod_id, 
        DATE(payments.bill_date) AS pay_date,
        product.prod_category AS pay_product_cat
        FROM payments 
        INNER JOIN product ON payments.product_id = product.prod_id
        WHERE user_email = '" . $userEmail . "'";

    $result2 = mysqli_query($conn, $query2);

    if (!$result2) {
        $response = array('success' => false, 'message' => "Failed to execute query");
        echo json_encode($response);
        exit;
    }

    if (mysqli_num_rows($result2) > 0) {
        while ($row = $result2->fetch_array()) {
            // check product category
            if ($prodCategory == $row['pay_product_cat']) {

                $payDate = $row['pay_date'];
                $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));

                // check date > 30 days
                if ($payDate > $thirtyDaysAgo) {
                    $response = array('success' => false, 'message' => "This plan crashed with your " . $product_name . ".\n\nYou may choose to unsubscribe first to be able to change your plan.");
                    echo json_encode($response);
                    exit;
                }
            }
        }
    }
} catch (Exception $e) {
    $response = array('success' => false, 'message' => "Failed to check plan, try again");
    echo json_encode($response);
    exit;
}


mysqli_close($conn);

/*
################################
||                            ||
||    Setup Paypal gateway    ||
||                            ||
################################
*/

$payer = new Payer();
$payer->setPaymentMethod('paypal');

$amount = new Amount();
$amount->setCurrency($currency)
    ->setTotal($amountPayable);

$items = new ItemList();
$items->setItems($my_items);

$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setDescription($description)
    ->setInvoiceNumber($invoiceNumber)
    ->setItemList($items);

$_SESSION['payment_status'] = "prevent user from acessing the pages directly, will be unset once finished";

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl($paypalConfig['return_url'])
    ->setCancelUrl($paypalConfig['cancel_url']);

$payment = new Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions([$transaction])
    ->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
} catch (Exception $e) {
    // Handle the error gracefully, such as displaying an error message or redirecting
    $response = array('success' => false, 'message' => "Failed to make payment");
    echo json_encode($response);
    exit;
}

// Replace the redirection code with this
$approvalLink = $payment->getApprovalLink();
$response = array('success' => true, 'approvalLink' => $approvalLink);

echo json_encode($response);
exit(1);
