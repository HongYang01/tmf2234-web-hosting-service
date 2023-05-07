<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

$_SESSION['loggedin'] = false;

if (isset($_POST['submit'])) {

    //using mysqli_real_escape_string() to protect from SQL injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $c_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    $query = "SELECT * FROM user WHERE u_email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) { //user exist in database
        echo "Already have an account, login instead";
        header("Location: /pages/signup_form.php");
    } elseif ($password != $c_password) {   //password not matched
        echo "Password does not matched";
        header("Location: /pages/signup_form.php");
    } elseif (strpos($email, "@semicolonix.com")) { //admin account are not allow to signup
        echo "Admin account are not allow to signup, login instead";
        header("Location: /pages/signup_form.php");
    } else { //signing up

        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT); //hasing password using Bcrypt

        // using prepared statement (stmt) to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO user (u_email, u_firstName, u_lastName, u_password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $fname, $lname, $hash);

        if ($stmt->execute()) {
            echo "Welcome " . $fname . ", " . $lname;
            require_once("/handlers/login_handler.php"); //auto login
            header("Location: /pages/myprofile.php");
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
} else {
    echo "not submitted";
}

mysqli_close($conn);
