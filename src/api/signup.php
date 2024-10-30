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
$error = [];

$username_result = validateUsername($data['username']);
if ($username_result !== true) {
    $error['username'] = $username_result;
} else {
    try {
        // Check if username address is already used
        $query = $pdo->prepare('SELECT username FROM user WHERE username = :username');
        $query->execute([
            'username' => $data['username']
        ]);
        $result = $query->fetchAll();
        if (count($result) > 0) {
            $error['username'] = 'Username already exists!';
        }
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'fail', 
            'message' => 'An error occurred while signing up: ' . $e->getMessage()
        ));
        exit();
    }
}

$email_result = validateEmail($data['email']);
if ($email_result !==  true) {
    $error['email'] = $email_result;
} else {

    try {
        // Check if email address is already used
        $query = $pdo->prepare('SELECT email FROM user WHERE email = :email');
        $query->execute([
            'email' => $data['email']
        ]);
        $result = $query->fetchAll();
        if (count($result) > 0) {
            $error['email'] = 'Email address already exists!';
        }
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'fail', 
            'message' => 'An error occurred while signing up: ' . $e->getMessage()
        ));
        exit();
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
    echo json_encode(array('status' => 'fail', 'error' => $error));
} else {
    try {
        $query = $pdo->prepare('INSERT INTO user(id, username, email, password) VALUES (:id, :username, :email, :password)');
        $query->execute([
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
    } catch (Exception $e) {
        echo json_encode(array(
            'status' => 'fail', 
            'message' => 'An error occurred while signing up: ' . $e->getMessage()
        ));
    }
}
