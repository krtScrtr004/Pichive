<?php

require_once '../config/database.php';
require_once '../config/session.php';

include_once '../utils/uuid.php';
include_once '../utils/authenticate_user.php';
include_once '../utils/echo_result.php';

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Error('Unauthorized user!');
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Error('Invalid request!');
    }   
    
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        throw new Error('Data cannot be parsed!');
    }

    if (!isset($data['is_followed'])) {
        throw new Error("Missing required parameter:'is_followed'");
    }
    
    $authenticate_id = authenticate_id($data['id']);
    if (!$authenticate_id) {
        throw new Error('Invalid user ID!');
    }

    if (!$data['is_followed']) {
        $query = $pdo->prepare('INSERT INTO follow(my_id, their_id) VALUES(:my_id, :their_id)');
        $query->execute([
            ':my_id' => encode_uuid($_SESSION['user_id']),
            ':their_id' => encode_uuid($data['id'])
        ]);
        echo_success('User followed successfully!');    
    } else {
        $query = $pdo->prepare('DELETE FROM follow WHERE my_id = :my_id AND their_id = :their_id');
        $query->execute([
            ':my_id' => encode_uuid($_SESSION['user_id']),
            ':their_id' => encode_uuid($data['id'])
        ]);
        echo_success('User unfollowed successfully!');    
    }
} catch (PDOException $e) {
    echo_fail($e->getMessage());
}