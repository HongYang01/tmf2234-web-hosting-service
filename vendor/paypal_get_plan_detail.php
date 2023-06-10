<?php
/*######################################*
||             Guideline              ||
*######################################*

1. Includes neccessary file
2. Check Indentity
3. Check POST array is set or empty
4. Get access_token
5. Setup cURL & request PayPal API
6. Listen to PayPal response (JSON | HTTP code)
7. Return JSON string

*/

/*######################################*
||              Includes              ||
*######################################*/
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_1_config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/paypal_2_accessToken.php");

$response = array();
$access_token;
$plan_id;

/*######################################*
||           Check Identity           ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
if (!checkLoggedIn() || $_SESSION['role'] != "admin") {
    mysqli_close($conn);
    header("Location: /pages/login_form.php");
    exit;
}

/*######################################*
||          Check POST array          ||
*######################################*/

try {
    if (!isset($_POST['plan_id']) || empty($_POST['plan_id'])) {
        throw new Exception("Error: [" . 'plan_id' . "] is not set or empty");
    } else {
        $plan_id = $_POST['plan_id'];
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
||          set cURL options          ||
*######################################*/

try {
    $ch = curl_init();

    $url = "https://api-m.sandbox.paypal.com/v1/billing/plans/" . $planId;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    // prepare header
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: application/json';
    $headers[] = 'Authorization: Bearer ' . rawurlencode($access_token);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
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

echo json_encode($response, true);
exit;
