<?php
require_once '../config/session.php';

// Unset all session variables
session_unset();
// Destroy the session
session_destroy();

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

// Redirect to login page or homepage
header("Location: ../index.php");
exit;