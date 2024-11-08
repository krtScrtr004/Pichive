<?php

/*
    Change password API 

    Req:
    OBJ = {
        id,
        new_password,
        c_password
    }
*/

require_once '../config/database.php';
include_once '../utils/validation.php';
include_once '../utils/uuid.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array(
        'status' => 'fail',
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

$password_result = validate_password($data['new_password']);
if ($password_result !== true) {
    $error['password'] = $password_result;
}

if ($data['new_password'] !== $data['c_password']) {
    $error['c_password'] = 'Passwords do not match';
}

if (!empty($error)) {
    echo json_encode(array(
        'status' => 'fail',
        'errors' => $error
    ));
    exit();
}

try {
    $query = $pdo->prepare('UPDATE user SET password = :password WHERE id = :id');
    $query->execute(array(
        ':password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
        ':id' => encode_uuid($data['id'])
    ));

    echo json_encode(array(
        'status' => 'success',
        'message' => 'Password updated successfully!'
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'error' => $e->getMessage()
    ));
}
