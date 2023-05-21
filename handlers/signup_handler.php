<?php

/*
################################
||                            ||
||       Handler Guide        ||
||                            ||
################################

USAGE:
Allow public user to sign up

PROCESS:
1. Get $_POST variable from submitted form (/pages/sign-form.php)
2. Check if the any $_POST variables are empty (return fail)
3. Check if public user email is registered before (return fail)
4. Encrypt the password using Bcrypt in password_hash()
5. Insert user data to db
5. Redirect user
    - Success
        - to myprofile (user)
        - to dashboard (admin)
    - Failed
        - to signup page again

NOTE:
- using JSON method to pass value back to client JS (separated using success[Bool], redirect[string], error[string])
- Using mysqli_real_escape_string() to sanitize $_POST variables to prevent SQL injection
- using mysqli_stmt_bind_param() to prevent SQL injection

*/

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
        $stmt = mysqli_prepare($conn, "INSERT INTO user (u_email, u_firstName, u_lastName, u_password) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $email, $fname, $lname, $hash);

        if (mysqli_stmt_execute($stmt)) { //login success

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
