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
    $query = $pdo->prepare('UPDATE user SET bio = :bio WHERE id = :id');
    $query->execute(array(
        ':bio' => $data['bio'],
        ':id' => encode_uuid($_SESSION['id']),
    ));
    echo json_encode(array(
        'status' => 'success',
        'message' => 'Bio updated successfully!'
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}