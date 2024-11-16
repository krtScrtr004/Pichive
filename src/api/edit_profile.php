<?php

require_once '../config/database.php';
include_once '../utils/uuid.php';
include_once '../utils/validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Invalid request!'
    ));
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Data cannot be parsed!'
    ));
}

$error = [];

try {
    $username_result = validate_username($data['username']);
    if ($username_result !== true) {
        $error['username'] = $username_result;
    } else {
        $search_duplicate_username = authenticate_username($data['username']);
        if ($search_duplicate_username) {
            $error['username'] = 'Username already exists!';
        }
    }

    $password_result = validate_password($data['password']);
    if ($password_result !== true) {
        $error['password'] = $password_result;
    }

    $query = $pdo->prepare('UPDATE user 
                            SET 
                                username = :username,
                                password = :password,
                                bio = :bio,
                                profile_url = :profile_url
                            WHERE 
                                id = :id');
    $query->execute(array(
        ':username' => $data['username'],
        ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ':bio' => $data['bio'],
        ':profile_url' => $data['profile_url'],
        ':id' => encode_uuid($_SESSION['user_id'])
    ));
    echo json_encode(array(
        'status' => 'success',
        'message' => 'Profile information successfully updated!'
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}