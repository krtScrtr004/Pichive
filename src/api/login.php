<?php
/*
    Login API 

    Req:
    OBJ = {
        email, 
        password
    }
*/

require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/validation.php';
include_once '../utils/authenticate_user.php';
include_once '../utils/echo_result.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo_fail('Invalid request!');
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo_fail('Data cannot be parsed!');
}

$error = [];
$email_result = validate_email($data['email']);
if ($email_result !==  true) {
    $error['email'] = $email_result;
}

$password_result = validate_password($data['password']);
if ($password_result !== true) {
    $error['password'] = $password_result;
}

if (!empty($error)) {
    echo_fail('Login failed!', $error);
}

try {
    $search_email = authenticate_email($data['email']);
    if (!$search_email || !password_verify($data['password'], $search_email['password'])) {
        echo_fail('Invalid email and/or password!');
    }

    // Initialize session
    $_SESSION['user_id'] = parse_uuid($search_email['id']);
    $_SESSION['user_email'] = $search_email['email'];
    echo_success('Account successfully logged in');
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
