<?php

/*
################################
||                            ||
||       Handler Usage        ||
||                            ||
################################

USAGE:
Allow admin to edit & delete products & product features

PROCESS:
1. Get the $_POST variable from the submitted form (including form data handling from edit_price_plan.js)
    - the js array is decoded using json_decode(myArray,true)

2. Check isset() & assign it into a NEW variable for easy maintenance

3. Product Section
    - prepare UPDATE query
    - Execute the statement

4. Product Feature Section
    - remove feature (if any)
    - update feature (iff the feature id is not in the remove feature array)
    - insert NEW feature (if any)

5. Return JSON format message (to determine the execution is success)

NOTE:
- - using JSON method to pass value back to client JS (separated using success[Bool], redirect[string], message[string])
- Using mysqli_real_escape_string() to prevent SQL injection (sanitization)
- Using mysqli_stmt_bind_param() to prevent SQL injection
*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

/*
################################
||                            ||
||       Check isset()        ||
||                            ||
################################

- check only "prod_id", "prod_title", "prod_subtitle", "prod_category", "prod_price", "prod_status"
- DONT check "js_featureID", "feature", "feature-status"
    - because scenerio: might have totally NEW features

*/

$field = ["prod_id", "prod_title", "prod_subtitle", "prod_category", "prod_price", "prod_status", "js_featureID", "feature", "feature-status"];

for ($i = 0; $i < count($field) - 3; $i++) { // NOTE: -3 because dont check "js_featureID", "feature", "feature-status"
    $temp = $field[$i];

    if (!isset($_POST[$temp])) {
        $response = array('success' => false, 'message' => "Missing data, check input: " . $temp);
        echo json_encode($response);
        exit;
    }
}


/*
################################
||                            ||
||      Assign Variable       ||
||                            ||
################################
*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

// Sanitize value
$prod_id = mysqli_real_escape_string($conn, $_POST[$field[0]]);
$prod_title = mysqli_real_escape_string($conn, $_POST[$field[1]]);
$prod_subtitle = mysqli_real_escape_string($conn, $_POST[$field[2]]);
$prod_category = mysqli_real_escape_string($conn, $_POST[$field[3]]);
$prod_price = mysqli_real_escape_string($conn, $_POST[$field[4]]);
$prod_status = mysqli_real_escape_string($conn, $_POST[$field[5]]);

// Get OLD feature Array (only if feature & status are set)
// because sometime can be completely new features only
if (isset($_POST[$field[7]]) && isset($_POST[$field[8]])) {
    $prod_feature_id = json_decode($_POST[$field[6]], true); // decode JSON
    $prod_feature = $_POST[$field[7]];
    $prod_feature_status = $_POST[$field[8]];
}

// NEW feature Array
$new_prod_feature = array();
$new_prod_feature_status = array();

if (isset($_POST['new-feature']) && isset($_POST['new-feature-status'])) {
    $new_prod_feature = $_POST['new-feature'];
    $new_prod_feature_status = $_POST['new-feature-status'];
}

// REMOVED feature array
$removed_prod_feature = array();
if (isset($_POST['js_removedFeature'])) {
    $removed_prod_feature = json_decode($_POST['js_removedFeature'], true); // decode JSON
}


/*
################################
||                            ||
||      Product Section       ||
||                            ||
################################
*/

/*
*    Here's a list of commonly used type specifiers in mysqli_stmt_bind_param():
*
*    i = integer.
*    d = double/float.
*    s = string.
*    b = blob.
*/

// Prepare the query
$success = false;
$query = "UPDATE product SET prod_title = ?, prod_subtitle = ?, prod_category = ?, prod_price = ?, prod_status = ? WHERE prod_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssdsi", $prod_title, $prod_subtitle, $prod_category, $prod_price, $prod_status, $prod_id);

if (mysqli_stmt_execute($stmt)) {
    $success = true;
    mysqli_stmt_close($stmt);
} else {
    $response = array('success' => $success, 'message' => mysqli_error($conn));
    mysqli_stmt_close($stmt);
    echo json_encode($response);
    mysqli_close($conn);
    exit();
}


/*
################################
||                            ||
||  Product Feature Section   ||
||                            ||
################################
*/

/*
################################
||       DELETE Feature       ||
################################
*/

if ($success && !empty($removed_prod_feature)) { // DELETE feature
    $success = false;
    $query = "DELETE FROM productdetail WHERE auto_num = ?";
    $stmt = mysqli_prepare($conn, $query);
    $num = count($removed_prod_feature);

    for ($i = 0; $i < $num; $i++) {
        mysqli_stmt_bind_param($stmt, "i", $removed_prod_feature[$i]);

        if (mysqli_stmt_execute($stmt) && $i == $num - 1) {
            $success = true;
        }
    }
    mysqli_stmt_close($stmt);
}

/*
################################
||       UPDATE Feature       ||
################################

*/
if ($success && isset($_POST[$field[7]]) && isset($_POST[$field[8]])) { // UPDATE OLD Product feature (only if feature & status are set)
    $success = false;
    $query = "UPDATE productdetail SET feature = ?, status = ? WHERE auto_num = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $v1, $v2, $v3);

    for ($i = 0; $i < count($prod_feature_id); $i++) {
        if (!in_array($prod_feature_id[$i], $removed_prod_feature)) {
            $v1 = $prod_feature[$i];
            $v2 = $prod_feature_status[$i];
            $v3 = $prod_feature_id[$i];

            if (mysqli_stmt_execute($stmt) && $i == count($prod_feature) - 1) {
                $success = true;
            }
        }
    }
    mysqli_stmt_close($stmt);
}

/*
################################
||     INSERT NEW Feature     ||
################################
*/

if ($success && !empty($new_prod_feature)) { // INSERT NEW Product feature
    $success = false;
    $query = "INSERT INTO productdetail (prod_id, feature, status) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    for ($i = 0; $i < count($new_prod_feature); $i++) { // update NEW feature

        mysqli_stmt_bind_param($stmt, "iss", $prod_id, $new_prod_feature[$i], $new_prod_feature_status[$i]);

        if (mysqli_stmt_execute($stmt) && $i == count($new_prod_feature) - 1) {
            $success = true;
        }
    }
    mysqli_stmt_close($stmt);
}

if ($success) {
    $response = array('success' => $success, 'message' => "Update Successfully");
} else {
    $response = array('success' => $success, 'message' => "Failed to Update");
}

echo json_encode($response); //respond back to client JS
mysqli_close($conn);
exit();
