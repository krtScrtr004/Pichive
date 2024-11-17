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

try {
    $profile_result = validate_image($_FILE['profile_url'] ?? null);
    if ($profile_result !== true) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => $profile_result
        ));
        exit();
    }

    $query = $pdo->prepare('UPDATE user SET profile_url = :profile_url WHERE id = :id');
    $query->execute(array(
        ':profile_url' => $data['profile_url'],
        ':id' => encode_uuid($_SESSION['id']),
    ));
    echo json_encode(array(
        'status' => 'success',
        'message' => 'Profile picture updated successfully!'
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}