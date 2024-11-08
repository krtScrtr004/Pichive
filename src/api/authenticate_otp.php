<?php
/*
    OTP Authenticator API 

    Req:
    OBJ = {
        otp_code,
        id
    }
*/

require_once '../config/database.php';
include_once '../utils/uuid.php';
include_once '../utils/forget_pass.util.php';

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

try {
    $existing_record = search_existing_record($data['id'], $data['otp_code']);
    if (!$existing_record) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Invalid OTP and/or user not found!'
        ));
        exit();
    }

    $current_time = new DateTime();
    $record_time = new DateTime($existing_record['record_time']);
    $time_difference = $current_time->getTimestamp() - $record_time->getTimestamp();
    // Check if 5 minutes have passed
    if ($time_difference >= 300) {
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Invalid OTP or already expired!'
        ));
        exit();
    }

    // Delete otp after use
    delete_otp_record($data['id'], $data['otp_code']);
    echo json_encode(array(
        'status' => 'success',
        'message' => 'OTP confirmed!'
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}
