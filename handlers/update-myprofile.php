<?php
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
