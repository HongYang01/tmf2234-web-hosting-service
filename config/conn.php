<?php

// https://semicolonix.000webhostapp.com/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id20654951_semicolonix";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {

    error_log("Failed to connect to database: " . $conn->connect_error);
    header("HTTP/1.1 500 Internal Server Error");
    echo "Failed to connect to database. Please try again later.";
    exit;
}

// Connection successful
// echo "Connected successfully to database";
