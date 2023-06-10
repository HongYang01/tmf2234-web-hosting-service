<?php

/*######################################*
||              Includes              ||
*######################################*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_2_accessToken.php");

$response = array();
$sub_id;
$access_token;

/*######################################*
||          Check POST array          ||
*######################################*/
// Get the JSON send by JS
$jsonData = file_get_contents('php://input');
// Decode the JSON data and assign it to $decodeData
$decodeData = json_decode($jsonData, true);
try {
    if (!isset($decodeData['sub_id']) || empty($decodeData['sub_id'])) {
        throw new Exception("Subscription ID is not set");
    }

    $sub_id = $decodeData['sub_id'];
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
        throw new Exception("Failed to request token from PayPal");
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

    $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/" . $sub_id . "/activate";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $reason = ['reason' => "None"];

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($reason, true));

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

        // update to database
        if (!DB_updateSubStatus($sub_id, $conn)) {
            throw new Error("Failed to update to database");
        }

        unset($response);
        $response['success'] = "Subscription reactivated successfully";
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

mysqli_close($conn);
echo json_encode($response, true);
exit;

function DB_updateSubStatus($subId, $conn)
{

    $status = "ACTIVE";

    $query = "UPDATE subscription SET sub_status='" . $status . "' WHERE sub_id='" . $subId . "'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        return false;
    }

    return true;
}
