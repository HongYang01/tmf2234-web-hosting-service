<?php
// https://semicolonix.000webhostapp.com/

ob_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id20654951_semicolonix";

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    // header("Location: /pages/error_503.php");
    // exit();
}

ob_end_flush();

//     error_log("Failed to connect to database: " . $conn->connect_error);
//     header("HTTP/1.1 500 Internal Server Error");
//     echo "Failed to connect to database. Please try again later.";
