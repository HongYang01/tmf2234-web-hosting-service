<?php

/*
################################
||                            ||
||       Handler Guide        ||
||                            ||
################################

USAGE:
Allow ALL user to logout

PROCESS:
1. empty all session variables
2. Destroy the session
2. Delete all cookies
3. Redirect to index.php

*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

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
