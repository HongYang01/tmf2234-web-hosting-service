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
    echo json_encode(['url' => "/pages/login_form.php"], true);
    exit;
}

/*######################################*
||           Check POST array          ||
*######################################*/

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'Fetch') {

    // Retrieve the raw POST data
    $jsonData = file_get_contents('php://input');
    // Decode the JSON data and assign it back to $data
    $decodeData = json_decode($jsonData, true);

    if (isset($decodeData['plan_id']) || !empty($decodeData['plan_id'])) {
        $result = checkPlanClashed($decodeData['plan_id'], $_SESSION['email']);
        echo json_encode($result, true);
    }
}

function checkPlanClashed(string $planId, string $email)
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

    return $response;
}
