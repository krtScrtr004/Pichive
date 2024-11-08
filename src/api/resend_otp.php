<?php

include_once '../utils/authenticate_user.php';
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
    $search_user = authenticate_email($data['email']);
    if (!$search_user) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Email not found!'
        ));
        exit();
    }

    if (!search_existing_record($search_user['id'])) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'User record not found!'
        ));
        exit();
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
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
    exit();
}
