<?php

/*
################################
||                            ||
||       Handler Usage        ||
||                            ||
################################

1. Get prod_id from the form: $_POST['prod_id']
2. No need to delete the product details because the product feature relation is set to CASCADE
3. Delete the product feature relation (JSON is response to client JS)
    - success
    - message
    - redirect

NOTE:
    - Using mysqli_real_escape_string() to prevent SQL injection (sanitization)
    - Using mysqli_stmt_bind_param() to prevent SQL injection

*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

if (!isset($_POST['prod_id']) || empty($_POST['prod_id'])) {
    $response = array('success' => false, 'message' => "Error: Product ID not found");
    echo json_encode($response);
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

$prod_id = mysqli_real_escape_string($conn, $_POST['prod_id']);

$query = "DELETE FROM product WHERE prod_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $prod_id);

if (mysqli_stmt_execute($stmt)) {
    $response = array('success' => true, 'redirect' => "/admin/manage-price-plan.php");
} else {
    $response = array('success' => false, 'message' => "Error: Failed to delete product (Product ID: " . $prod_id . ")");
}

mysqli_stmt_close($stmt);
echo json_encode($response);
mysqli_close($conn);
exit;
