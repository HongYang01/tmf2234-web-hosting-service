<?php
include($_SERVER['DOCUMENT_ROOT'] . "/config/conn.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

$_SESSION['loggedin'] = false;

if (isset($_POST['submit'])) { // Check if the login form was submitted

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username and password are valid
    // Check on user table
    $query = "SELECT * FROM user WHERE u_email='$email'";
    $result = $conn->query($query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_array($result);

        $hash = $row['u_password'];

        if (!password_verify($password, $hash)) {
            header("Location: /pages/login_form.php");
        } else {

            $_SESSION['role'] = "user";
            $_SESSION['email'] = $row['u_email'];
            $_SESSION['fname'] = $row['u_firstName'];
            $_SESSION['lname'] = $row['u_lastName'];

            $_SESSION['loggedin'] = true; //logged in successful
            $_SESSION['id'] = session_id();

            header("Location: /pages/myprofile.php");
        }
    } else {

        //Check on admin table
        $query = "SELECT * FROM admin WHERE a_email='$email'";
        $result = $conn->query($query);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_array($result);

            $hash = $row['a_password'];

            if (!password_verify($password, $hash)) {
                header("Location: /pages/login_form.php");
            } else {

                $_SESSION['role'] = "admin";
                $_SESSION['email'] = $row['a_email'];
                $_SESSION['fname'] = $row['a_firstName'];
                $_SESSION['lname'] = $row['a_lastName'];

                $_SESSION['loggedin'] = true; //is logged in
                $_SESSION['id'] = session_id();

                header("Location: /admin/dashboard.php");
            }
        } else {
            header("Location: /pages/login_form.php");
        }
    }
} else {
    echo "Form not submitted";
}

mysqli_close($conn); // Close the database connection
