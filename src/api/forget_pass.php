<?php

// Script to authenticate email and send OTP

require_once '../config/database.php';
include_once '../utils/validation.php';
include_once '../utils/uuid.php';
include_once '../utils/request.php';

use OTPHP\TOTP;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Invalid request!'
    ));
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

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

    // Create POST request to mail sender script 
    $url = 'http://localhost/Pichive/src/utils/send_otp.php';
    $response = sendData($url, [
        'email' => $data['email'],
        'otp' => $otp,
        'username' => $result['username']
    ]);
    if ($reponse['status'] === 'fail') {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Failed to send OTP!'
        ));
    }

    // Search existing otp in user inbox
    if (search_existing_record($result['id'])) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'You have an existing OTP in your inbox!'
        ));
    }

    // Insert otp with user_id to db
    insert_otp_record($result['id']);
    echo json_encode(array(
        'status' => 'success',
        'message' => 'OTP sent successfully!'
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Database error: ' . $e->getMessage()
    ));
    exit();
}

// TODO: Move this to utils file
function search_existing_record($id)
{
    global $pdo;
    try {
        $search_existing_query = $pdo->prepare('SELECT otp_code FROM otp WHERE user_id = :user_id');
        $search_existing_query->execute([
            ':user_id' => $id
        ]);
        $search_existing_result = $search_existing_query->fetch();
        return $search_existing_result ? true : false;
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Database error: ' . $e->getMessage()
        ));
        exit();
    }
}

function insert_otp_record($id)
{
    global $pdo;
    try {
        date_default_timezone_set('Asia/Manila');

        $totp = TOTP::generate();       // Generate secret (64-bit)
        $totp->setDigits(6);            // Set OTP length to 6-digit long
        $otp = $totp->now();

        // Record otp  with id in db
        $insert_query = $pdo->prepare('INSERT INTO otp(otp_code, user_id, record_time) VALUES(:otp_code, :user_id, :record_time)');
        $insert_query->execute([
            ':otp_code' => $otp,
            ':user_id' => $id,
            ':record_time' => (new DateTime())->format('Y-m-d H:i:s')
        ]);
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Database error: ' . $e->getMessage()
        ));
        exit();
    }
}
