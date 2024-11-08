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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array(
        'message' => 'Invalid request!'
    ));
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Data cannot be parsed!'
    ));
    exit();
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
    echo json_encode(array(
        'status' => 'fail',
        'error' => $error
    ));
    exit();
}

try {
    $search_email = authenticate_email($data['email']);
    if (!$search_email || !password_verify($data['password'], $search_email['password'])) {
        echo json_encode(array(
            'status' => 'fail',
            'error' => array(
                'Invalid email and/or password!'
            )
        ));
        exit();
    }

    echo json_encode(array(
        'status' => 'success',
        'message' => 'Account successfully logged in'
    ));

    // Initialize session
    $_SESSION['user_id'] = parse_uuid($search_email['id']);
    $_SESSION['user_email'] = $search_email['email'];
} catch (Exception $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}
