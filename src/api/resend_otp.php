<?php

include_once '../utils/authenticate_user.php';
include_once '../utils/forget_pass.util.php';
include_once '../utils/request.php';
include_once '../utils/echo_result.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request!');
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        throw new Exception('Data cannot be parsed!');
    }
    
    $search_user = authenticate_email($data['email']);
    if (!$search_user) {
        throw new Exception('Email not found!');
    }

    if (!search_existing_record($search_user['id'])) {
        throw new Exception('User record not found!');
    }

    $otp = generate_otp();
    $response = send_data('http://localhost/Pichive/src/api/send_otp.php', [
        'email' => $search_user['email'],
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
    update_otp_record($search_user['id'], $otp);
    echo json_encode(array(
        'status' => 'success',
        'message' => 'New OTP was sent successfully!',
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
