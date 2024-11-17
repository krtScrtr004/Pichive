<?php

/*
    Signup API 

    Req:
    OBJ = {
        username,
        email,
        password,
        c_password
    }
*/

require_once '../config/database.php';
include_once '../utils/validation.php';
include_once '../utils/authenticate_user.php';
include_once '../utils/uuid.php';
include_once '../utils/echo_result.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo_fail('Invalid request!');
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo_fail('Data cannot be parsed!');
}

$error = [];
try {
    $username_result = validate_username($data['username']);
    if ($username_result !== true) {
        $error['username'] = $username_result;
    } else {
        // Check if username address is already used
        $search_duplicate_username = authenticate_username($data['username']);
        if ($search_duplicate_username) {
            $error['username'] = 'Username already exists!';
        }
    }

    $email_result = validate_email($data['email']);
    if ($email_result !==  true) {
        $error['email'] = $email_result;
    } else {
        // Check if email address is already used
        $search_duplicate_email = authenticate_email($data['email']);
        if ($search_duplicate_email) {
            $error['email'] = 'Email address already exists!';
        }
    }

    $password_result = validate_password($data['password']);
    if ($password_result !== true) {
        $error['password'] = $password_result;
    }

    if ($data['c_password'] !== $data['password']) {
        $error['c_password'] = 'Passwords do not match!';
    }

    if (!empty($error)) {
        echo_fail('Signup failed!', $error);
    }

    $uuid =  generate_uuid();
    $query = $pdo->prepare('INSERT INTO 
                                user(id, 
                                    username, 
                                    email, 
                                    password) 
                            VALUES (
                                    :id, 
                                    :username, 
                                    :email, 
                                    :password)');
    $query->execute(array(
        ':id' => $uuid,
        ':username' => $data['username'],
        ':email' => $data['email'],
        ':password' => password_hash($data['password'], PASSWORD_DEFAULT)
    ));

    $_SESSION['user_id'] = parse_uuid($uuid);
    $_SESSION['user_email'] = $data['email'];
    echo_success('Account successfully signed up');
} catch (PDOException $e) {
    echo_fail($e->getMessage());
}
