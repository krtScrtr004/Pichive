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
include_once '../utils/echo_result.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request!');
    }

    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        throw new Exception('Data cannot be parsed!');
    }

    $email_result = validate_email($data['email']);
    if ($email_result !== true) {
        throw new Exception($email_result);
    }

    $search_user = authenticate_email($data['email']);
    if (!$search_user) {
        throw new Exception('Email not found!');
    }

    // Search existing otp in user inbox
    if (search_existing_record($search_user['id'])) {
        delete_otp_record($search_user['id']);
    }

    $otp = generate_otp();
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
        throw new Exception($response['message'] ?? 'Data cannot be processed!');
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
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
