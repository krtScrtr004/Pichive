<?php

/*
    Email Authenticator and OTP Sender API 

    Req:
    OBJ = {
        email
    }
*/

// TODO: When user has existing OTP and he wants to send another, 
// instead of forcing him to use the previous otp, update it 

include_once '../utils/validation.php';
include_once '../utils/uuid.php';
include_once '../utils/request.php';
include_once '../utils/forget_pass.util.php';
include_once '../utils/authenticate_user.php';

$otp = generate_otp();

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

$email_result = validate_email($data['email']);
if ($email_result !== true) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $email_result
    ));
    exit();
}

try {
    $search_user = authenticate_email($data['email']);
    if (!$search_user) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Email not found!'
        ));
        exit();
    }

    // Search existing otp in user inbox
    if (search_existing_record($search_user['id'])) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'An OTP has already been sent to this email!'
        ));
        exit();
    }

    // Send OTP to the user via gmail
    $response = send_data('http://localhost/Pichive/src/api/send_otp.php', [
        'email' => $data['email'],
        'username' => $search_user['username'],
        'otp_code' => $otp
    ]);
    if (
        !$response ||
        !isset($response->status) ||
        $response->status === 'fail'
    ) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => $response['message'] ?? 'Data cannot be processed!'
        ));
        exit();
    }

    // Insert otp with user_id to db
    insert_otp_record($search_user['id'], $otp);
    echo json_encode(array(
        'status' => 'success',
        'message' => 'OTP successfully sent!',
        'user' => array(
            'email' => $data['email'],
            'username' => $search_user['username'],
            'id' => parse_uuid($search_user['id']),
        ),
        'otp_code' => $otp
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
    exit();
}