<?php
// Script to authenticate OTP

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Invalid request!'
    ));
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
try {
    $search_query = $pdo->prepare('SELECT * FROM otp WHERE otp_code = :otp_code AND user_id = :user_id');
    $search_query->execute([
        'otp_code' => $data['otp_code'],
        'user_id' => $data['user_id']
    ]);

    $result = $search_query->fetch();

    $current_time = new DateTime();
    $record_time = new DateTime($result['record_time']);
    $time_difference = $current_time->getTimestamp() - $record_time->getTimestamp();
    // If 5 minutes have passed
    if ($time_difference >= 300) {
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Invalid OTP or already expired!'
        ));
        exit();
    }

    // Delete otp after use
    $delete_query = $pdo->prepare('DELETE FROM otp WHERE otp_code = :otp_code AND user_id = :user_id');
    $delete_query->execute([
        ':otp_code' => $data['otp_code'],
        ':user_id' => $data['user_id']
    ]);

    echo json_encode(array(
        'status' => 'success',
        'message' => 'OTP confirmed!'
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Database error: ' . $e->getMessage()
    ));
}
