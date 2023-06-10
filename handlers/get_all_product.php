<?php

/**
 * @param string - prod_id | null(default select all)
 * @return array all product in array
 */

function getAllProduct(?String $select = null)
{
    require($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    $response = array();

    try {
        if ($select == null) {
            $query = "SELECT * FROM product";
        } else {
            $query = "SELECT * FROM product WHERE prod_id = '" . $select . "'";
        }

        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Error: Failed to execute product query");
        } elseif (mysqli_num_rows($result) <= 0) {
            throw new Exception("Success: 0 product found");
        }

        while ($row = mysqli_fetch_array($result)) {
            $response[] = [
                'prod_id' => $row['prod_id'],
                'prod_name' => $row['prod_name'],
                'prod_status' => $row['prod_status']
            ];
        }
    } catch (Exception $e) {
        unset($response); // empty array
        $response['error'] = $e->getMessage();
    }

    mysqli_close($conn);
    return $response;
}
