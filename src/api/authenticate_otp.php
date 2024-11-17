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
include_once '../utils/echo_result.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo_fail('Invalid request!');
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo_fail('Data cannot be parsed!');
}

try {
    $existing_record = search_existing_record($data['id'], $data['otp_code']);
    if (!$existing_record) {
        echo_fail('Invalid OTP and/or user not found!');
    }

    $current_time = new DateTime();
    $record_time = new DateTime($existing_record['record_time']);
    $time_difference = $current_time->getTimestamp() - $record_time->getTimestamp();
    // Check if 5 minutes have passed
    if ($time_difference >= 300) {
        echo_fail('Invalid OTP or already expired!');
    }

    // Delete otp after use
    delete_otp_record($data['id'] ?? null, $data['otp_code'] ?? null);
    echo_success('OTP confirmed!');
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}
