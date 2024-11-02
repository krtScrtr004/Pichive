<?php

require_once '../config/database.php';
include_once '../utils/validation.php';
include_once '../utils/uuid.php';

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

try {
    $username_result = validateUsername($data['username']);
    if ($username_result !== true) {
        $error['username'] = $username_result;
    } else {
        // Check if username address is already used
        $username_query = $pdo->prepare('SELECT username FROM user WHERE username = :username');
        $username_query->execute([
            'username' => $data['username']
        ]);
        $result = $username_query->fetchAll();
        if (count($result) > 0) {
            $error['username'] = 'Username already exists!';
        }
    }

    $email_result = validateEmail($data['email']);
    if ($email_result !==  true) {
        $error['email'] = $email_result;
    } else {
        // Check if email address is already used
        $email_query = $pdo->prepare('SELECT email FROM user WHERE email = :email');
        $email_query->execute([
            'email' => $data['email']
        ]);
        $result = $email_query->fetchAll();
        if (count($result) > 0) {
            $error['email'] = 'Email address already exists!';
        }
    }

    $password_result = validatePassword($data['password']);
    if ($password_result !== true) {
        $error['password'] = $password_result;
    }

    if ($data['c_password'] !== $data['password']) {
        $error['c_password'] = 'Passwords do not match!';
    }

    if (!empty($error)) {
        echo json_encode(array(
            'status' => 'fail',
            'error' => $error
        ));
        exit();
    }
    $insert_query = $pdo->prepare('INSERT INTO user(id, username, email, password) VALUES (:id, :username, :email, :password)');
    $insert_query->execute([
        ':id' => generateUUID(),
        ':username' => $data['username'],
        ':email' => $data['email'],
        ':password' => password_hash($data['password'], PASSWORD_DEFAULT)
    ]);
    echo json_encode(array(
        'status' => 'success',
        'message' => 'Account successfully signed up'
    ));

    $_SESSION['user_id'] = $uuid;
    $_SESSION['user_email'] = $data['email'];
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Database error: ' . $e->getMessage()
    ));
}
