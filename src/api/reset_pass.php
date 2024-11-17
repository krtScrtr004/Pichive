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
include_once '../utils/echo_result.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo_fail('Invalid request!');
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo_fail('Data cannot be parsed!');
}


$password_result = validate_password($data['new_password']);
if ($password_result !== true) {
    echo_fail($password_result);
}

if ($data['new_password'] !== $data['c_password']) {
    echo_fail('Passwords do not match!');
}

try {
    $query = $pdo->prepare('UPDATE user SET password = :password WHERE id = :id');
    $query->execute(array(
        ':password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
        ':id' => encode_uuid($data['id'] ?? null)
    ));
    echo_success('Password updated successfully!');
} catch (PDOException $e) {
    echo json_encode($e->getMessage());
}
