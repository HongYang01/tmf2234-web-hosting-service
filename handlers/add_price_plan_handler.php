<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

if (!empty($_POST['prod_title']) && !empty($_POST['prod_subtitle']) && !empty($_POST['prod_category']) && !empty($_POST['prod_price']) && !empty($_POST['prod_status'])) {

    // Set the values from $_POST
    $prod_title = mysqli_real_escape_string($conn, $_POST['prod_title']);
    $prod_subtitle = mysqli_real_escape_string($conn, $_POST['prod_subtitle']);
    $prod_category = mysqli_real_escape_string($conn, $_POST['prod_category']);
    $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
    $prod_status = mysqli_real_escape_string($conn, $_POST['prod_status']);
    $prod_feature = $_POST['feature'];
    $prod_feature_status = $_POST['feature-status'];

    // Prepare the query
    $query = "INSERT INTO product (prod_title, prod_subtitle, prod_category, prod_price, prod_status) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $prod_title, $prod_subtitle, $prod_category, $prod_price, $prod_status);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $prod_id = mysqli_insert_id($conn); //get the new generated product id

        $query = "INSERT INTO productdetail (prod_id, feature, status) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        for ($i = 0; $i < count($prod_feature); $i++) {
            mysqli_stmt_bind_param($stmt, "sss", $prod_id, $prod_feature[$i], $prod_feature_status[$i]);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: /admin/manage-price-plan.php");
            } else {
                echo "Failed to add the new plan details";
            }
        }
    } else {
        echo "Failed to add the new plan";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Failed to receive submission";
}
mysqli_close($conn);
