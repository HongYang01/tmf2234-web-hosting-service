<?php
function checkLoggedIn()
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/auth/auth_session.php");

    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        return false;
    }

    return true;
}
