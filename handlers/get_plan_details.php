<?php

/*######################################*
||             Guideline              ||
*######################################*

- can access the function using GET method [/handlers/get_plan_details.php?plan_id=YOUR_VALUE_HERE]
- call getAllPlanDetails()

*/

if (isset($_GET['plan_id']) && !empty($_GET['plan_id'])) {
    getAllPlanDetails(rawurldecode($_GET['plan_id']));
}

function getAllPlanDetails(string $planId)
{

    require($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    $response = array();

    try {

        if (empty($planId)) {
            throw new Exception("Error: Function require a plan ID");
        }

        /*######################################*
        ||           Get Plan Info            ||
        *######################################*/

        $query = "SELECT * FROM plan WHERE plan_id = '" . $planId . "'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Error: Failed to execute query 1");
        } elseif (mysqli_num_rows($result) == 0) {
            throw new Exception("Success: Plan [" . $planId . "] not found");
        }

        $row = mysqli_fetch_array($result);

        $response['plan_id'] = $row['plan_id'];
        $response['prod_id'] = $row['prod_id'];
        $response['plan_name'] = $row['plan_name'];
        $response['plan_desc'] = $row['plan_desc'];
        $response['plan_price'] = $row['plan_price'];
        $response['plan_status'] = $row['plan_status'];

        /*######################################*
        ||          Get Product Info          ||
        *######################################*/

        $query = "SELECT * FROM product WHERE prod_id = '" . $response['prod_id'] . "'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Error: Failed to execute query 1");
        } elseif (mysqli_num_rows($result) != 1) {
            throw new Exception("Success: Product [" . $response['prod_id'] . "] not found");
        }

        $row = mysqli_fetch_array($result);

        $response['prod_name'] = $row['prod_name'];
        $response['prod_status'] = $row['prod_status'];
        $response['plan_full_name'] = "" . $row['prod_name'] . " Hosting (" . $response['plan_name'] . ")";


        /*######################################*
        ||          Get Plan Feature          ||
        *######################################*/

        $query = "SELECT * FROM plandetail WHERE plan_id = '" . $response['plan_id'] . "' ORDER BY status DESC, feature ASC";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $planDetail[] = [
                        'auto_num' => $row['auto_num'],
                        'feature' => $row['feature'],
                        'status' => $row['status'],
                    ];
                }

                // push the features into the arrays
                $response['plan_detail'] = $planDetail;
            } else {
                throw new Exception("Success: 0 result for plan details");
            }
        } else {
            throw new Exception("Error: Failed to execute query 2");
        }
    } catch (Exception $e) {
        unset($response);
        $response['error'] = $e->getMessage();
    }

    mysqli_close($conn);
    if (isset($_GET['plan_id'])) {
        echo json_encode($response, true);
    } else {
        return $response;
    }
}


/*

// Returned JSON format

Array
(
    [plan_id] => 10
    [prod_id] => PROD0003
    [plan_name] => Testing Edited
    [plan_desc] => Good for testing Edited
    [plan_price] => 1.00
    [plan_status] => ACTIVE
    [prod_name] => Dedicated
    [prod_status] => ACTIVE
    [plan_full_name] => Dedicated Hosting (Testing Edited)
    [plan_detail] => Array
        (
            [0] => Array
                (
                    [auto_num] => 153
                    [feature] => te1
                    [status] => 1
                )

            [1] => Array
                (
                    [auto_num] => 154
                    [feature] => tet
                    [status] => 1
                )

            [2] => Array
                (
                    [auto_num] => 155
                    [feature] => tete
                    [status] => 0
                )

        )

)
*/