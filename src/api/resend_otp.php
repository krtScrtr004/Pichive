<?php

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

    if (search_existing_record($result['id'])) {
        // TODO: Move this to Resend OTP link on FE
        $otp = generate_otp();
        update_otp_record($result['id'], $otp);
        echo json_encode(array(
            'status' => 'success',
            'message' => 'New OTP sent successfully!',
            'user' => [
                'user_email' => $data['email'],
                'user_username' => $result['username'],
                'user_id' => parse_uuid($result['id']),
            ],
            'otp_code' => $otp    
        ));
    } else {
       echo json_encode(array(
        'status' => 'fail',
        'message' => 'User record not found!'
       ));   
    }
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Database error: ' . $e->getMessage()
    ));
    exit();
}