<?php

require_once '../config/database.php';
include_once '../utils/validation.php';
include_once '../utils/uuid.php';
include_once '../utils/request.php';

use OTPHP\TOTP;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array(
        'message' => 'Invalid request!'
    ));
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$error = [];

$email_result = validateEmail($data['email']);
if ($email_result !== true) {
    $error['email'] = $email_result;
} else {
    try {
        $query = $pdo->prepare('SELECT email FROM user WHERE email = :email');
        $query->execute([
            ':email' => $data['email']
        ]);
        $result = $query->fetch();
        if ($result) {

            $totp = TOTP::generate();       // Generate secret (64-bit)
            $totp->setDigits(6);            // Set OTP length to 6-digit long
            $otp = $totp->now();

            // Create POST request to mail sender script 
            if (sendData('../utils/send_otp.php', [
                'email' => $data['email'],
                'otp' => $otp
            ])) {
                echo json_encode(array(
                   'status' =>'success',
                   'message' => 'OTP sent successfully!'
                ));
            } else {
                echo json_encode(array(
                   'status' => 'fail',
                   'message' => 'Failed to send OTP!'
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Email not found!'
            ));
        }
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'An error occurred while signing up: ' . $e->getMessage()
        ));
        exit();
    }
}
