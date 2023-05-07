<?php

//NOTE: using array method to pass value back to js (separated using success[Bool], redirect[string], error[string])
// $response = array('success' => true, 'redirect' => "String");
// $response = array('success' => false, 'error' => "String");


require_once($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

$_SESSION['loggedin'] = false;

if (!empty($_POST['email']) && !empty($_POST['password'])) { // Check if the login form was submitted correctly

    //using mysqli_real_escape_string() to protect from SQL injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check on user table
    $query = "SELECT * FROM user WHERE u_email='$email'";
    $result = $conn->query($query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_array($result);

        $hash = $row['u_password'];

        if (!password_verify($password, $hash)) {
            $response = array('success' => false, 'error' => "Wrong Credentials");
        } else {

            $_SESSION['role'] = "user";
            $_SESSION['email'] = $row['u_email'];
            $_SESSION['fname'] = $row['u_firstName'];
            $_SESSION['lname'] = $row['u_lastName'];

            $_SESSION['loggedin'] = true; //logged in successful
            $_SESSION['id'] = session_id();

            $response = array('success' => true, 'redirect' => '/pages/myprofile.php');
        }
    } else {

        //Check on admin table
        $query = "SELECT * FROM admin WHERE a_email='$email'";
        $result = $conn->query($query);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_array($result);

            $hash = $row['a_password'];

            if (!password_verify($password, $hash)) {
                $response = array('success' => false, 'error' => "Wrong Credentials");
            } else {

                $_SESSION['role'] = "admin";
                $_SESSION['email'] = $row['a_email'];
                $_SESSION['fname'] = $row['a_firstName'];
                $_SESSION['lname'] = $row['a_lastName'];

                $_SESSION['loggedin'] = true; //is logged in
                $_SESSION['id'] = session_id();

                $response = array('success' => true, 'redirect' => '/admin/dashboard.php');
            }
        } else { // both user & admin not found
            $response = array('success' => false, 'error' => "Wrong Credentials");
        }
    }
} else {
    $response = array('success' => false, 'error' => "Failed to submit form, check input");
}

echo json_encode($response); //respond back to client JS

mysqli_close($conn); // Close the database connection
