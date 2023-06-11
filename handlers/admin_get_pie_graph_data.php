<?php

getPieChartData();

function getPieChartData()
{
    /*######################################*
    ||              Includes              ||
    *######################################*/

    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    try {

        $response = array();

        $query = "SELECT plan.plan_name AS planName, ";
        $query .= "product.prod_name AS prodName, ";
        $query .= "SUM(transaction.trans_gross_amount) AS netAmount ";
        $query .= "FROM transaction ";
        $query .= "INNER JOIN subscription ON transaction.trans_sub_id = subscription.sub_id ";
        $query .= "INNER JOIN plan ON subscription.plan_id = plan.plan_id ";
        $query .= "INNER JOIN product ON plan.prod_id = product.prod_id ";
        $query .= "GROUP BY plan.plan_id";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Failed to execute query");
        } elseif (mysqli_num_rows($result) == 0) {
            throw new Exception("Failed to get pie chart details");
        }

        while ($row = mysqli_fetch_array($result)) {
            $response['pieLabels'][] = $row['prodName'] . " Hosting (" . $row['planName'] . ")";
            $response['pieData'][] = $row['netAmount'];
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    mysqli_close($conn);

    // Check if the request includes the custom header
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'Fetch') { // header is fetch
        // If the header is present and has the expected value, echo the JSON response
        echo json_encode($response, true);
    } else {
        // If the header is not present or doesn't have the expected value, return the JSON response
        return json_encode($response, true);
    }
}
