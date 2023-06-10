<?php

/*

POST array accepting:
- plan_id
- plan_name
- plan_desc
- plan_price
- plan_status
- feature[]
- feature-status[]
- js_featureID[]
- js_removedFeatureID[]

if any:
- new-feature[]
- new-feature-status[]

*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

$response = array();

/*######################################*
||          Check POST array          ||
*######################################*/

try {

    $post_element = ['plan_id', 'plan_name', 'plan_desc', 'plan_price', 'plan_status'];

    foreach ($post_element as $key) {
        if (!isset($_POST[$key]) || empty($_POST[$key])) {
            throw new Exception("Error: New plan detail is not complete");
        }
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

/*######################################*
||          Assign variable           ||
*######################################*/

$plan_id = $_POST['plan_id'];
$plan_name = $_POST['plan_name'];
$plan_desc = $_POST['plan_desc'];
$plan_price = $_POST['plan_price'];
$plan_status = $_POST['plan_status'];
$plan_detail = [
    'feature' => $_POST['feature'],
    'status' => $_POST['feature-status'],
];

$js_featureID = $_POST['js_featureID'];
$js_featureID = explode(",", $js_featureID); // make it become array
$js_removedFeatureID = $_POST['js_removedFeatureID'];
$js_removedFeatureID = explode(",", $js_removedFeatureID); // make it become array

// Optional
$new_prod_feature = array();
$new_prod_feature_status = array();
if (isset($_POST['new-feature']) && isset($_POST['new-feature-status'])) {
    $new_prod_feature = $_POST['new-feature'];
    $new_prod_feature_status = $_POST['new-feature-status'];
}


/*######################################*
||         Update Plan Query          ||
*######################################*/

try {
    // Assuming you have a MySQLi connection established

    // Prepare the SQL statement
    $query = "UPDATE plan SET plan_name=?, plan_desc=?, plan_price=?, plan_status=? WHERE plan_id=?";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "ssdss", $plan_name, $plan_desc, $plan_price, $plan_status, $plan_id);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error: Failed to execute query");
    }
    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    mysqli_stmt_close($stmt);
    unset($response);
    $response['error'] = $e->getMessage();
}

/*######################################*
||                                    ||
||      Update Plan Detail Query      ||
||                                    ||
*######################################*/

/*######################################*
||       Insert New plan detail       ||
*######################################*/

try {

    $query = "INSERT INTO plandetail (plan_id, feature, status) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    for ($i = 0; $i < count($new_prod_feature); $i++) {
        mysqli_stmt_bind_param($stmt, "ssi", $plan_id, $new_prod_feature[$i], $new_prod_feature_status[$i]);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error: Failed to add new plan details");
        }
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}


/*######################################*
||       Update Old plan detail       ||
*######################################*/

try {

    $query = "UPDATE plandetail SET feature=?, status=? WHERE auto_num=?";
    $stmt = mysqli_prepare($conn, $query);


    for ($i = 0; $i < count($plan_detail['feature']); $i++) {
        mysqli_stmt_bind_param($stmt, "sis", $plan_detail['feature'][$i], $plan_detail['status'][$i], $js_featureID[$i]);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error: Failed to update old plan details");
        }
    }
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

/*######################################*
||       Delete Old plan detail       ||
*######################################*/

try {

    $query = "DELETE FROM plandetail WHERE auto_num = ?";
    $stmt = mysqli_prepare($conn, $query);

    for ($i = 0; $i < count($js_removedFeatureID); $i++) {
        mysqli_stmt_bind_param($stmt, "s", $js_removedFeatureID[$i]);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error: Failed to update old plan details");
        }
    }

    $response['success'] = "Plan updated successfully";
} catch (Exception $e) {
    unset($response);
    $response['error'] = $e->getMessage();
}

mysqli_close($conn);
echo json_encode($response, true);
exit;
