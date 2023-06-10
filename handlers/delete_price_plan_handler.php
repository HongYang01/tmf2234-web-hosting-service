<?php

/*
################################
||                            ||
||       Handler Guide        ||
||                            ||
################################

USAGE:
Allow admin to delete an entire plan

PROCESS:
1. Get plan_id from the form using $_POST['plan_id'] [/admin/edit_price_plan.php]
2. No need to delete the plan details because the plan feature relation is set to CASCADE
3. Delete the plan feature relation (JSON is response to client JS)
    - success
    - message
    - redirect

NOTE:
- Using mysqli_real_escape_string() to sanitize $_POST variables to prevent SQL injection
- using mysqli_stmt_bind_param() to prevent SQL injection

*/


require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

if (!isset($_POST['plan_id']) || empty($_POST['plan_id'])) {
    $response = array('success' => false, 'message' => "Error: Product ID not found");
    echo json_encode($response);
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

$plan_id = mysqli_real_escape_string($conn, $_POST['plan_id']);

$query = "DELETE FROM plan WHERE plan_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $plan_id);

if (mysqli_stmt_execute($stmt)) {
    $response = array('success' => true, 'redirect' => "/admin/manage_price_plan.php");
} else {
    $response = array('success' => false, 'message' => "Error: Failed to delete plan (Product ID: " . $plan_id . ")");
}

mysqli_stmt_close($stmt);
echo json_encode($response);
mysqli_close($conn);
exit;
