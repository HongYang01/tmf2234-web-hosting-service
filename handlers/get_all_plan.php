<?php

/**
 * @param planType {String} null(all) | Shared | VPS | Dedicated
 * @return {encoded JSON}
 */

function getAllPlan(?String $planType = null)
{

    require($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    $allPlan = array();

    try {
        /*######################################*
        ||              Get Plan              ||
        *######################################*/

        if ($planType == null) {
            $query = "SELECT * FROM plan ORDER BY plan_price ASC";
        } else {
            $query = "SELECT * FROM plan
            INNER JOIN product
            ON plan.prod_id = product.prod_id
            WHERE product.prod_name = '" . $planType . "'
            ORDER BY plan.plan_price ASC";
        }

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $plans = array();
                $plansIncludeFeature = array();
                $plansExcludeFeature = array();

                $plans['plan_id'] = $row['plan_id'];
                $plans['prod_id'] = $row['prod_id'];
                $plans['plan_name'] = $row['plan_name'];
                $plans['plan_desc'] = $row['plan_desc'];
                $plans['plan_price'] = $row['plan_price'];
                $plans['plan_status'] = $row['plan_status'];

                /*######################################*
                ||          Get Plan Feature          ||
                *######################################*/

                $query2 = "SELECT * FROM plandetail WHERE plan_id ='" . $row['plan_id'] . "' ORDER BY feature ASC";
                $result2 = mysqli_query($conn, $query2);

                if ($result2 && mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_array($result2)) {
                        if ($row2['status']) {
                            $plansIncludeFeature[] = $row2['feature'];
                        } else {
                            $plansExcludeFeature[] = $row2['feature'];
                        }
                    }
                    $plans['include_feature'] = $plansIncludeFeature;
                    $plans['exclude_feature'] = $plansExcludeFeature;
                } else {
                    throw new Exception("Error: Plan [" . $row['plan_id'] . "] detail not found");
                }

                $allPlan[] = $plans;
            }
            mysqli_close($conn);
            return json_encode($allPlan, true);
        } else {
            throw new Exception("Error: 0 plan found");
        }
    } catch (Exception $e) {
        mysqli_close($conn);
        return json_encode(['error' => $e->getMessage()], true);
    }
}
