<?php

/*--------------------------------------------- SESSION MANAGEMENT ---------------------------------------------------*/

ini_set('session.use_only_cookies', 1);             // Use only cookie for session ID
ini_set('session.use_strict_mode', 1);              // Refuse to use invalid session ID

$lifetime = 1800;
$domain = 'localhost';
$path = '/';
$secure = false;
$httponly = true;

session_set_cookie_params([
    'lifetime' => $lifetime,                          // Valid for 30 minutes
    'domain' => $domain,                              // Default
    'path' => $path,                                  // Valid for files within the project
    'secure' => $secure,                              // Use HTTPS
    'httponly' => $httponly                           // Prevent script execution
]);

session_start();

if (!isset($_SESSION['last_regen'])) {
    session_regenerate_id();
    $_SESSION['last_regen'] = time();
} else {
    $interval = 60 * 30;
    if (time() - $_SESSION['last_regen'] >= $interval) {
        session_regenerate_id();
        $_SESSION['last_regen'] = time();
    }
}

/*--------------------------------------------------------------------------------------------------------------------*/
