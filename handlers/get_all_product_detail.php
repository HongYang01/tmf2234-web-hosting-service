<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

$response = array();
$IncludeArr = array();
$ExcludeArr = array();

// Retrieve the raw POST data
$jsonData = file_get_contents('php://input');

// Decode the JSON data and assign it back to $data
$decodeData = json_decode($jsonData, true);

try {

    if (!isset($decodeData['prod_id']) || empty($decodeData['prod_id'])) {
        throw new Exception("Error: Product ID not set");
    }

    /*
    ################################
    ||          get info          ||
    ################################
    */

    $query = "SELECT * FROM product WHERE prod_id = " . $decodeData['prod_id'];
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response['prod_id'] = $row['prod_id'];
            $response['prod_title'] = $row['prod_title'];
            $response['prod_subtitle'] = $row['prod_subtitle'];
            $response['prod_category'] = $row['prod_category'];
            $response['prod_price'] = $row['prod_price'];
            $response['prod_status'] = $row['prod_status'];
        } else {
            throw new Exception("Success: 0 result for product");
        }
    } else {
        throw new Exception("Error: Failed to execute query 1");
    }


    /*
    ################################
    ||        get feature         ||
    ################################
    */

    $query = "SELECT * FROM productdetail WHERE prod_id = " . $decodeData['prod_id'] . " ORDER BY feature ASC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['status'] == 1) {
                    $IncludeArr[] = $row['feature'];
                } else {
                    $ExcludeArr[] = $row['feature'];
                }
            }

            // push the features into the arrays
            $response['include'] = $IncludeArr;
            $response['exclude'] = $ExcludeArr;
        } else {
            throw new Exception("Success: 0 result for feature");
        }
    } else {
        throw new Exception("Error: Failed to execute query 2");
    }
} catch (Exception $e) {
    $response = ['error' => $e->getMessage()];
}

mysqli_close($conn);
echo json_encode($response);
exit;
