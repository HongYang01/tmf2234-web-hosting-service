<?php
/*######################################*
||              Includes              ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

/*######################################*
||           Check Identity           ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/CheckLogin.php");
if (!checkLoggedIn() || $_SESSION['role'] != "user") {
    header("Location: /pages/login_form.php");
    exit;
}

/*######################################*
||           Check POST array          ||
*######################################*/
// Retrieve the raw POST data
$jsonData = file_get_contents('php://input');
// Decode the JSON data and assign it back to $data
$decodeData = json_decode($jsonData, true);
if (isset($decodeData['plan_id']) || !empty($decodeData['plan_id'])) {
    checkPlanClashed($decodeData['plan_id'], $_SESSION['email'], true);
}


function checkPlanClashed(string $planId, string $email, ?bool $urlAccess = false)
{

    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    $response = array();

    try {

        $query = "SELECT sub_id FROM subscription WHERE u_email='" . $email . "' AND plan_id='" . $planId . "' AND (sub_status='ACTIVE' OR sub_status='SUSPEND')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Failed to check if plan clashed");
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            throw new Exception("Plan clashed with subcription ID [" . $row['sub_id'] . "]");
        }

        $response['success'] = "No plan clashes";
    } catch (Exception $e) {
        unset($response);
        $response['error'] = $e->getMessage();
    }

    mysqli_close($conn);
    if ($urlAccess) {
        echo json_encode($response, true);
    } else {
        return $response;
    }
}

exit;
