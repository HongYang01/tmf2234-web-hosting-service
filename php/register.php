<!-- This is just an example -->



<?php

$ds = DIRECTORY_SEPARATOR;
require_once(__DIR__ . "conn.php");

// Create a new DBConnection object
$db = new DBConnection();

// Get the database connection
$conn = $db->getConnection();

// Retrieve the form data using the $_POST superglobal
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate that the password and confirm password fields match
if ($password !== $confirm_password) {
    echo "Error: Passwords do not match";
    exit;
}

// Hash the password using the PHP password_hash() function
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the user's data into the database
$sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "User created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
