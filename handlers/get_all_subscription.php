<?php

$response = array(); // must declare
$decodeData = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the raw POST data
    $jsonData = file_get_contents('php://input');
    // Decode the JSON data and assign it back to $data
    $decodeData = json_decode($jsonData, true);

    try {
        if (!isset($decodeData['sortBy']) || empty($decodeData['sortBy'])) {
            throw new Exception("No sorting was set");
        } else {
            getALLSubscription($decodeData['sortBy']);
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
        echo json_encode($response, true);
        exit;
    }
}

/*######################################*
||     User get own subscriptions     ||
*######################################*/

function getALLSubscription(string $sortBy)
{
    /*######################################*
    ||              Includes              ||
    *######################################*/

    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");

    $response = array();
    $email;

    /*######################################*
    ||           Check Identity           ||
    *######################################*/

    if (checkLoggedIn() && $_SESSION['role'] == "user") {
        $email = $_SESSION['email'];
    } elseif (!checkLoggedIn()) {
        mysqli_close($conn);
        header("Location: /pages/login_form.php");
        exit;
    } //continue if it is admin and will get all the subscriptions

    /*######################################*
    ||          Get Sub from DB           ||
    *######################################*/

    try {

        // get subscription info
        if ($sortBy === "default") {
            $query = "SELECT * FROM subscription WHERE u_email = '" . $email . "' ORDER BY sub_status ASC";
        } elseif ($sortBy === "name") {
            $query = "SELECT * FROM subscription WHERE u_email = '" . $email . "' ORDER BY sub_id DESC";
        } elseif ($sortBy === "date") {
            $query = "SELECT * FROM subscription WHERE u_email = '" . $email . "' ORDER BY bill_date DESC";
        } else {
            throw new Exception("Error: Wrong sorting type");
        }

        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Error: Failed to execute subscription query");
        } elseif (mysqli_num_rows($result) == 0) {
            throw new Exception("Here where you will see all your subscriptions together and easily manage them.");
        }

        while ($subRow = mysqli_fetch_array($result)) {

            // get plan info
            $query2 = "SELECT * FROM plan WHERE plan_id = '" . $subRow['plan_id'] . "'";
            $result2 = mysqli_query($conn, $query2);

            if (!$result2) {
                throw new Exception("Error: Failed to execute plan query");
            } elseif (mysqli_num_rows($result2) != 1) {
                throw new Exception("Error: Plan [" . $subRow['plan_id'] . "] not found");
            }

            $planRow = mysqli_fetch_array($result2);

            // get product info
            $query3 = "SELECT * FROM product WHERE prod_id = '" . $planRow['prod_id'] . "'";
            $result3 = mysqli_query($conn, $query3);

            if (!$result3) {
                throw new Exception("Error: Failed to execute product query");
            } elseif (mysqli_num_rows($result3) == 0) {
                throw new Exception("Error: Product [" . $planRow['prod_id'] . "] not found");
            }

            $prodRow = mysqli_fetch_array($result3);

            $subInfo = array(
                "sub_status" => $subRow['sub_status'],
                "sub_id" => $subRow['sub_id'],
                "plan_id" => $subRow['plan_id'],
                "plan_name" => $prodRow['prod_name'] . " Hosting (" . $planRow['plan_name'] . ")", //prod_name + plan_name
                "u_email" => $subRow['u_email'],
                "paypal_email" => $subRow['paypal_email'],
                "paypal_name" => $subRow['paypal_name'],
                "payer_id" => $subRow['payer_id'],
                "amount" => $subRow['amount'],
                "currency_code" => $subRow['currency_code'],
                "bill_date" => $subRow['bill_date'],
                "next_bill_date" => $subRow['next_bill_date'],
            );

            $response[] = $subInfo;
        }
    } catch (Exception $e) {
        unset($response);
        $response = ['error' => $e->getMessage()];
    }

    mysqli_close($conn);
    // Return the subscription data as JSON
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode($response, true);
        exit;
    } else {
        return $response;
    }
}
