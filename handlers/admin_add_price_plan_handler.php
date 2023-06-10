<?php

/*#############################*
||                            ||
||       Handler Guide        ||
||                            ||
*##############################*

USAGE:
Allow admin to add NEW plan to any existing hosting type

*/


/*######################################*
||              Includes              ||
*######################################*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

$response = array();
$newFormPlanInfo = array();

/*######################################*
||          Check POST array          ||
*######################################*/

try {

    $post_element = ['prod_id', 'plan_id', 'prod_name', 'plan_name', 'plan_desc', 'plan_price', 'plan_status'];

    foreach ($post_element as $element) {
        if (!isset($_POST[$element]) || empty($_POST[$element])) {
            throw new Exception("Error: " . $element . " is not set");
        } else {
            $newFormPlanInfo[$element] = mysqli_escape_string($conn, $_POST[$element]);
        }
    }

    $temp = array();

    for ($i = 0; $i < count($_POST['feature']); $i++) {
        $temp[] = [
            'feature' => mysqli_escape_string($conn, $_POST['feature'][$i]),
            'status' => mysqli_escape_string($conn, $_POST['feature-status'][$i]),
        ];
    }

    $newFormPlanInfo['plan_detail'] = $temp;
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

/*######################################*
||              DB query              ||
*######################################*/

try {

    $plan_id = $newFormPlanInfo['plan_id']; // from paypal
    $prod_id = $newFormPlanInfo['prod_id'];
    $plan_name = $newFormPlanInfo['plan_name'];
    $plan_desc = $newFormPlanInfo['plan_desc'];
    $plan_price = $newFormPlanInfo['plan_price'];
    $plan_status = $newFormPlanInfo['plan_status']; // from paypal
    $plan_detail = $newFormPlanInfo['plan_detail'];

    /*######################################*
    ||             plan query             ||
    *######################################*/
    $query = "INSERT INTO plan (plan_id, prod_id, plan_name, plan_desc, plan_price, plan_status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssds", $plan_id, $prod_id, $plan_name, $plan_desc, $plan_price, $plan_status);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error: Failed to execute query");
    }

    /*######################################*
    ||          plandetail query          ||
    *######################################*/
    $query = "INSERT INTO plandetail (plan_id, feature, status) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    for ($i = 0; $i < count($plan_detail); $i++) {
        mysqli_stmt_bind_param($stmt, "ssi", $plan_id, $plan_detail[$i]['feature'], $plan_detail[$i]['status']);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error: Failed to add plan details");
        }
    }

    $response = ['success' => true, 'message' => "Plan created successfully"];
} catch (Exception $e) {
    mysqli_stmt_close($stmt);
    unset($response);
    $response['error'] = $e->getMessage();
}

mysqli_close($conn);
echo json_encode($response);
exit;
