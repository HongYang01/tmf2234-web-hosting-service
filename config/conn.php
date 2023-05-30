<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id20654951_semicolonix";

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_errno) {
        throw new Exception();
    }
} catch (Exception $e) {
    // Connection error occurred
    header("Location: /Error/503.php");
    exit;
}