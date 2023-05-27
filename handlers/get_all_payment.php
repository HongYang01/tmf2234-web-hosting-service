<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

$response = array(); // must declare

// Retrieve the raw POST data
$jsonData = file_get_contents('php://input');
// Decode the JSON data and assign it back to $data
$decodeData = json_decode($jsonData, true);


try {
    if (!isset($decodeData['sortBy'])) {
        throw new Exception("Error: Unable to sort");
    } elseif ($decodeData['sortBy'] == "default") {
        $query = "SELECT * FROM payments WHERE user_email = '" . $_SESSION['email'] . "' ORDER BY plan_status DESC";
    } elseif ($decodeData['sortBy'] == "name") {
        $query = "SELECT * FROM payments WHERE user_email = '" . $_SESSION['email'] . "' ORDER BY product_name ASC";
    } elseif ($decodeData['sortBy'] == "date") {
        $query = "SELECT * FROM payments WHERE user_email = '" . $_SESSION['email'] . "' ORDER BY bill_date ASC";
    } else {
        throw new Exception("Error: Wrong sorting type");
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $payment = array(
                    "product_id" => $row['product_id'],
                    "transaction_id" => $row['transaction_id'],
                    "payment_amount" => $row['payment_amount'],
                    "currency_code" => $row['currency_code'],
                    "invoice_id" => $row['invoice_id'],
                    "product_name" => $row['product_name'],
                    "bill_date" => $row['bill_date'],
                    "maturity_date" => $row['maturity_date'],
                    "plan_status" => $row['plan_status'],
                );

                $response[] = $payment;
            }
        } else {
            throw new Exception("Success: 0 result");
        }
    } else {
        throw new Exception("Error: Failed to execute query");
    }
} catch (Exception $e) {
    $response = ['error' => $e->getMessage()];
}

// Return the payment data as JSON
echo json_encode($response);
mysqli_close($conn);
exit;
