<?php

/*--------------------------------------------- SESSION MANAGEMENT ---------------------------------------------------*/

require_once 'load_env.php';

ini_set('session.use_only_cookies', 1);             // Use only cookie for session ID
ini_set('session.use_strict_mode', 1);              // Refuse to use invalid session ID

session_set_cookie_params([
    'lifetime' => $_ENV['SS_LIFETIME'],            // Valid for 30 minutes
    'domain' => $_ENV['SS_DOMAIN'],                 // Default
    'path' => $_ENV['SS_PATH'],                     // Valid for files within the project
    'secure' => $_ENV['SS_SECURE'],                 // Use HTTPS
    'httponly' => $_ENV['SS_HTTPONLY']              // Prevent script execution
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
