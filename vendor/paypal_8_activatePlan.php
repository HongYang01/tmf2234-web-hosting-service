<?php
/*######################################*
||              Includes              ||
*######################################*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_2_accessToken.php");

$response = array();
$access_token;
$plan_id;

/*######################################*
||          Check POST array          ||
*######################################*/

$requestBody = file_get_contents('php://input');
$decodedData = json_decode($requestBody, true);

try {
    if (!isset($decodedData['plan_id']) || empty($decodedData['plan_id'])) {
        throw new Exception("Error: plan_id is not set");
    } else {
        $plan_id = $decodedData['plan_id'];
    }
} catch (Exception $e) {
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
||          set URL options           ||
*######################################*/

try {

    $ch = curl_init();

    $request_link = "https://api-m.sandbox.paypal.com/v1/billing/plans/" . $plan_id . "/activate";
    curl_setopt($ch, CURLOPT_URL, $request_link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: application/json';
    $headers[] = 'Authorization: Bearer ' . $access_token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // get HTTP code returned by PayPal (success: 204)
    curl_close($ch);

    if ($http_code == 204) {
        if (updatePlanStatusInDB($plan_id)) {
            $response = ['success' => "Plan reactivated successfully"];
        } else {
            throw new Exception("Failed to update status of plan [" . $plan_id . "] to DB");
        }
    } else {
        throw new Exception("Error " . $http_code . ": " . PAYPAL_HTTP_ERR_MSG($http_code));
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response, true);
exit;

function updatePlanStatusInDB($get_plan_id)
{

    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    $query = "UPDATE plan SET plan_status='ACTIVE' WHERE plan_id='" . $get_plan_id . "'";
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);

    if (!$result) return false;

    return true;
}
