<?php

//NOTE: using array method to pass value back to js (separated using success[Bool], redirect[string], error[string])
// $response = array('success' => true, 'redirect' => "String");
// $response = array('success' => false, 'error' => "String");


require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

$_SESSION['loggedin'] = false;

if (!empty($_POST['email']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {

    //using mysqli_real_escape_string() to protect from SQL injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $c_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    $query = "SELECT * FROM user WHERE u_email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) { //user exist in database
        $response = array('success' => false, 'error' => 'Already have an account, login instead');
    } else { //signing up

        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT); //hasing password using Bcrypt

        // using prepared statement (stmt) to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO user (u_email, u_firstName, u_lastName, u_password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $fname, $lname, $hash);

        if ($stmt->execute()) { //login success

            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = session_id();
            $_SESSION['role'] = "user";
            $_SESSION['email'] = $email;
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;

            $response = array('success' => true, 'redirect' => '/pages/myprofile.php');
        } else { //error execution
            $response = array('success' => false, 'error' => "Error: Unable to connect to server");
        }

        mysqli_stmt_close($stmt);
    }
} else {
    $response = array('success' => false, 'error' => "Failed to submit form, check input");
}

echo json_encode($response); //respond back to client JS

mysqli_close($conn);
