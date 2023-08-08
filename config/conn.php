<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/dotenv/vendor/autoload.php";

use Dotenv\Dotenv as Dotenv;

// Create connection
try {

    $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
    $dotenv->load();

    $servername = $_ENV['DB_HOSTNAME'];
    $username = $_ENV['DB_USERNAME'];
    $dbname = $_ENV['DB_NAME'];
    $password = $_ENV['DB_PASSWORD'];

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
