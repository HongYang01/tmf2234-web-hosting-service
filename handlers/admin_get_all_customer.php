<?php

function getAllCustomer()
{

    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");

    $response = array();

    try {
        $query = "SELECT u_email,u_firstname,u_lastname,signupDate FROM user";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            throw new Exception("Failed to execute query");
        } elseif (mysqli_num_rows($result) == 0) {
            throw new Exception("No Customer Found");
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

    return $response;
}

/*

Example returned value

Array
(
    [0] => Array
        (
            [u_email] => alex@gmail.com
            [u_firstname] => Alex
            [u_lastname] => Anderson
            [signupDate] => 2023-05-01 07:45:30
        )

    [1] => Array
        (
            [u_email] => alice@outlook.com
            [u_firstname] => Alice
            [u_lastname] => Williams
            [signupDate] => 2023-01-25 02:39:44
        )

    [2] => Array
        (
            [u_email] => bob@hotmail.com
            [u_firstname] => Bob
            [u_lastname] => Johnson
            [signupDate] => 2023-03-30 07:38:45
        )
)

*/