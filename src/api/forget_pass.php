<?php

// Script to authenticate email and send OTP

require_once '../config/database.php';
include_once '../utils/validation.php';
include_once '../utils/uuid.php';
include_once '../utils/request.php';
include_once '../utils/forget_pass.util.php';

use OTPHP\TOTP;

$totp = TOTP::generate();       // Generate secret (64-bit)
$totp->setDigits(6);            // Set OTP length to 6-digit long
$otp = $totp->now();

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

$email_result = validateEmail($data['email']);
if ($email_result !== true) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $email_result
    ));
    exit();
}

try {
    $query = $pdo->prepare('SELECT id, username FROM user WHERE email = :email');
    $query->execute([
        ':email' => $data['email']
    ]);
    $result = $query->fetch();
    if (!$result) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Email not found!'
        ));
        exit();
    }

    // Search existing otp in user inbox
    if (search_existing_record($result['id'])) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'You have an existing OTP in your inbox!'
        ));
        exit();
    }

    // Send OTP to the user via gmail
    $request = sendData('http://localhost/Pichive/src/api/send_otp.php', [
        'email' => $data['email'],
        'username' => $result['username'],
        'otp_code' => $otp
    ]);
    if (
        !$request ||
        !isset($request->status) ||
        $request->status === 'fail'
    ) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => $request['message'] ?? 'Data cannot be processed!'
        ));
        exit();
    }

    // Insert otp with user_id to db
    insert_otp_record($result['id']);
    echo json_encode(array(
        'status' => 'success',
        'message' => 'OTP sent successfully!',
        'user' => [
            'user_email' => $data['email'],
            'user_username' => $result['username'],
            'user_id' => parseUUID($result['id']),
        ],
        'otp_code' => $otp
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Database error: ' . $e->getMessage()
    ));
    exit();
}