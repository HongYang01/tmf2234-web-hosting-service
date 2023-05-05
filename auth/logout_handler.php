<?php

//start a new session because previous session cookie still exists in the user's browser and may be used to initiate a new session
//Therefore to make sure it is destroyed properly
session_start();

//Destroy the opened session
session_destroy();

// Remove the session cookie
// setcookie(session_name(), "", time() - 3600);

// Remove the session cookie
// Unset all session variables
$_SESSION = [];

// Delete the session cookie by setting it to expire immediately
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirect the user to the login page
header("Location: /index.php");

exit();
