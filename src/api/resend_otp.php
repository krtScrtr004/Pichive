<?php

include_once '../utils/authenticate_user.php';
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
    $search_user = authenticate_email($data['email']);
    if (!$search_user) {
        echo_fail('Email not found!');
    }

    if (!search_existing_record($search_user['id'])) {
        echo_fail('User record not found!');
    }

    $otp = generate_otp();
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
} catch (PDOException $e) {
    echo_fail($e->getMessage());
}
