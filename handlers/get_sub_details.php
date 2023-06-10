<?php
/*######################################*
||          Check POST array          ||
*######################################*/

if (isset($_POST['function_name']) && isset($_POST['sub_id'])) {
    $functionName = $_POST['function_name'];
    $subID = $_POST['sub_id'];

    if ($functionName === "getSubDetail" && !empty($subID)) {
        $result = getSubDetail($subID);
        echo json_encode($result, true);
    }
}

function getSubDetail(string $subID)
{

    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    $response = array();

    $query = "SELECT * FROM subscription ";
    $query .= "INNER JOIN plan ON subscription.plan_id = plan.plan_id ";
    $query .= "INNER JOIN product ON plan.prod_id = product.prod_id ";
    $query .= "WHERE sub_id='" . $subID . "'";

    try {
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Failed to execute query");
        } elseif (mysqli_num_rows($result) == 0) {
            throw new Exception("No subscription detail found");
        }

        $response = mysqli_fetch_assoc($result);
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    return $response;
}

/*

return example:

Array
(
    [sub_status] => ACTIVE
    [sub_id] => I-6M56GR72PKPH
    [plan_id] => P-7HU86870CB6342615MR2LZNA
    [u_email] => name2@gmail.com
    [paypal_email] => sb-tehix25986425@personal.example.com
    [paypal_name] => John Doe
    [payer_id] => 9LB2QJM6L9ZSU
    [amount] => 2.55
    [currency_code] => USD
    [bill_date] => 2023-06-06 04:03:53
    [next_bill_date] => 2023-07-05 10:00:00
    [prod_id] => PROD0001
    [plan_name] => Popular
    [plan_desc] => Intermediate user
    [plan_price] => 2.55
    [plan_status] => ACTIVE
    [prod_name] => Shared
    [prod_status] => ACTIVE
)

*/