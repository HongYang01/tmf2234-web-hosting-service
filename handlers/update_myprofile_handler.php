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
5. Insert user data to database
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fname']) && isset($_POST['lname'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    if (isset($_SESSION['email'])) {

        if ($_SESSION['role'] == "user") {

            $stmt = $conn->prepare("UPDATE user SET u_firstName = ?, u_lastName = ? WHERE u_email = ?");
            $stmt->bind_param("sss", $fname, $lname, $_SESSION['email']);
        } elseif ($_SESSION['role'] == "admin") {

            $stmt = $conn->prepare("UPDATE admin SET a_firstName = ?, a_lastName = ? WHERE a_email = ?");
            $stmt->bind_param("sss", $fname, $lname, $_SESSION['email']);
        }

        if ($stmt->execute()) {
            echo "Update successfully"; //success
        } else {
            echo "Update failed: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Email not recognised";
    }

    mysqli_close($conn);
} else {
    echo "Failed to update";
}
