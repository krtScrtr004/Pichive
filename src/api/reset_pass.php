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

$password_result = validate_password($data['new_password']);
if ($password_result !== true) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $password_result
    ));
}

if ($data['new_password'] !== $data['c_password']) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Passwords do not match!'
    ));
    exit();
}

try {
    $query = $pdo->prepare('UPDATE user SET password = :password WHERE id = :id');
    $query->execute(array(
        ':password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
        ':id' => encode_uuid($data['id'] ?? null)
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
