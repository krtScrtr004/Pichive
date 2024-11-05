<?php

require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/validation.php';

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
    $query = $pdo->prepare('SELECT id, email, password FROM user WHERE email = :email');
    $query->execute([
        ':email' => $data['email'],
    ]);
    $result = $query->fetch();
    if (!$result || !password_verify($data['password'], $result['password'])) {
        echo json_encode(array(
            'status' => 'fail',
            'error' => [
                'Invalid email and/or password!'
                ]
        ));
        exit();
    }

    echo json_encode(array(
        'status' => 'success',
        'message' => 'Account successfully logged in'
    ));

    // Initialize session
    $_SESSION['user_id'] = $result['id'];
    $_SESSION['user_email'] = $result['email'];
} catch (Exception $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Database error: ' . $e->getMessage()
    ));
}
