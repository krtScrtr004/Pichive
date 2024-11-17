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

try {
    $username_result = validate_username($data['username']);
    if ($username_result !== true) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => $username_result
        ));
    } else {
        $search_duplicate_username = authenticate_username($data['username']);
        if ($search_duplicate_username) {
            echo json_encode(array(
                'status' => 'fail',
                'message' => 'Username already exists!'
            ));
            exit();
        }
    }

    $query = $pdo->prepare('UPDATE user SET username = :username WHERE id = :id');
    $query->execute(array(
        ':username' => $data['username'],
        ':id' => encode_uuid($_SESSION['id']),
    ));
    echo json_encode(array(
        'status' => 'success',
        'message' => 'Username updated successfully!'
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}