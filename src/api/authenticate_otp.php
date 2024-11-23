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

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request!');
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        throw new Exception('Data cannot be parsed!');
    }

    $existing_record = search_existing_record($data['id'], $data['otp_code']);
    if (!$existing_record) {
        throw new Exception('Invalid OTP and/or user not found!');
    }

    $current_time = new DateTime();
    $record_time = new DateTime($existing_record['record_time']);
    $time_difference = $current_time->getTimestamp() - $record_time->getTimestamp();
    // Check if 5 minutes have passed
    if ($time_difference >= 300) {
        throw new Exception('Invalid OTP or already expired!');
    }

    // Delete otp after use
    delete_otp_record($data['id'] ?? null, $data['otp_code'] ?? null);
    echo_success('OTP confirmed!');
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
