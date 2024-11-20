<?php

require_once '../config/database.php';
require_once '../config/session.php';

include_once '../utils/uuid.php';
include_once '../utils/authenticate_user.php';
include_once '../utils/echo_result.php';

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Unauthorized user!');
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request!');
    }   
    
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        throw new Exception('Data cannot be parsed!');
    }

    if (!isset($data['is_blocked'])) {
        throw new Exception("Missing required parameter: 'is_blocked'");
    }
    
    $authenticate_id = authenticate_id($data['id']);
    if (!$authenticate_id) {
        throw new Exception('Invalid user ID!');
    }

    if (!$data['is_blocked']) {
        $block_query = $pdo->prepare('INSERT INTO block(my_id, their_id) VALUES(:my_id, :their_id)');
        $block_query->execute([
            ':my_id' => encode_uuid($_SESSION['user_id']),
            ':their_id' => encode_uuid($data['id'])
        ]);

        // Unfollow user if they already followed
        $delete_query = $pdo->prepare('DELETE FROM follow WHERE my_id = :my_id AND their_id = :their_id');
        $delete_query->execute([
            ':my_id' => encode_uuid($_SESSION['user_id']),
            ':their_id' => encode_uuid($data['id'])
        ]);

        echo_success('User blocked successfully!');    
    } else {
        $query = $pdo->prepare('DELETE FROM block WHERE my_id = :my_id AND their_id = :their_id');
        $query->execute([
            ':my_id' => encode_uuid($_SESSION['user_id']),
            ':their_id' => encode_uuid($data['id'])
        ]);
        echo_success('User unblocked successfully!');    
    }
} catch (Exception $e) {
    echo_fail($e->getMessage());
}