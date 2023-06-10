<?php

/*######################################*
||             Guideline              ||
*######################################*

- accept trans_sub_id
- can access the function using GET method [/handlers/get_all_transaction.php?trans_sub_id=YOUR_VALUE_HERE]
- call getAllTransaction()

*/

/*######################################*
||          Check POST array          ||
*######################################*/
// must use post method

try {
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        if (!isset($_GET['trans_sub_id']) || empty($_GET['trans_sub_id'])) {
            throw new Exception("Subscription ID is not set");
        } else {
            getAllTransaction($_GET['trans_sub_id']);
        }
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    echo json_encode($response, true);
    exit;
}


function getAllTransaction(?string $transSubId = null)
{

    require($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    $response = array();
    $transInfo = array();

    try {

        if ($transSubId != null && empty($transSubId)) {
            throw new Exception("Function require a transaction ID");
        }

        /*######################################*
        ||        Get Transaction Info        ||
        *######################################*/

        if ($transSubId == null) {
            $query = "SELECT * FROM transaction";
        } else {
            $query = "SELECT * FROM transaction WHERE trans_sub_id = '" . $transSubId . "'";
        }

        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Failed to retrive any transactions history");
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $transInfo[] = $row;
        }

        $response = $transInfo;
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    mysqli_close($conn);
    if (isset($_GET['trans_sub_id'])) {
        echo json_encode($response, true);
    } else {
        return $response;
    }
}

/*

// example returned value:


Array
(
    [0] => Array
        (
            [trans_id] => 3T711130TW8695834
            [trans_sub_id] => I-6M56GR72PKPH
            [trans_status] => COMPLETED
            [trans_currency_code] => USD
            [trans_gross_amount] => 2.55
            [trans_fee_amount] => 0.58
            [trans_net_amount] => 1.97
            [trans_datetime] => 2023-06-06 04:03:53
        )

    [1] => Array
        (
            [trans_id] => asdf
            [trans_sub_id] => I-6M56GR72PKPH
            [trans_status] => asdf
            [trans_currency_code] => asdf
            [trans_gross_amount] => 12.00
            [trans_fee_amount] => 1.00
            [trans_net_amount] => 11.00
            [trans_datetime] => 2023-06-08 10:35:43
        )
)

*/