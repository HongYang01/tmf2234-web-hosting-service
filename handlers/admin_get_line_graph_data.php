<?php

getLineGraphData();

function getLineGraphData()
{

    /*######################################*
    ||              Includes              ||
    *######################################*/

    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    try {

        $response = array();

        $query = "SELECT YEAR(trans_datetime) AS year, ";
        $query .= "MONTHNAME(trans_datetime) AS month, ";
        $query .= "DAY(trans_datetime) AS day, ";
        $query .= "SUM(trans_gross_amount) AS total_sales FROM transaction ";
        $query .= "GROUP BY year, month, day ";
        $query .= "ORDER BY year, month, day";

        $result = mysqli_query($conn, $query);


        if (!$result) {
            throw new Exception("Failed to execute query");
        } elseif (mysqli_num_rows($result) == 0) {
            throw new Exception("Failed to get transaction details");
        }

        while ($row = mysqli_fetch_array($result)) {
            $response['label'][] = $row['day'] . " " . $row['month'] . ", " . $row['year'];
            $response['data'][] = $row['total_sales'];
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
