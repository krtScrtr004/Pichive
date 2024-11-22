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

    if (!isset($data['is_liked'])) {
        throw new Exception("Missing required parameter: 'is_liked'");
    }
    
    if (!authenticate_post($data['id'])) {
        throw new Exception('Invalid post ID!');
    }
    
    if (!$data['is_liked']) {
        $pdo->beginTransaction();
        $insert_like_query = $pdo->prepare('INSERT INTO p_like(user_id, post_id) VALUES(:id, :post_id)');
        $insert_like_query->execute([
            ':id' => encode_uuid($_SESSION['user_id']),
            ':post_id' => $data['id']
        ]);

        // Increment post like count
        $increment_like_query = $pdo->prepare('UPDATE post SET likes = likes + 1 WHERE id = :id');
        $increment_like_query->execute([
            ':id' => $data['id']
        ]);

        $pdo->commit();
        echo_success('Post liked successfully!');    
    } else {
        $pdo->beginTransaction();
        $delete_like_query = $pdo->prepare('DELETE FROM p_like WHERE user_id = :id AND post_id = :post_id');
        $delete_like_query->execute([
            ':id' => encode_uuid($_SESSION['user_id']),
            ':post_id' => $data['id']
        ]);

        // Decrement post like count
        $decrement_like_query = $pdo->prepare('UPDATE post SET likes = likes - 1 WHERE id = :id');
        $decrement_like_query->execute([
            ':id' => $data['id']
        ]);

        $pdo->commit();
        echo_success('Post unliked successfully!');    
    }
} catch (Exception $e) {
    echo_fail($e->getMessage());
}