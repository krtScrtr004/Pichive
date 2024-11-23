<?php

require_once '../config/database.php';
require_once '../config/session.php';

include_once '../utils/uuid.php';
include_once '../utils/request.php';
include_once '../utils/authenticate_user.php';
include_once '../utils/authenticate_post.php';
include_once '../utils/validation.php';
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
        throw new Exception('Data cannot be parsed!');
    }

    if (!authenticate_post($data['id'])) {
        throw new Error('Post does not exists!');
    }

    $pdo->beginTransaction();
    if (isset($data['title'])) {
        $title_result = validate_title($data['title']);
        if ($title_result !== true) {
            throw new Exception($title_result);
        }

        $title_query = $pdo->prepare('UPDATE post SET title = :title WHERE id = :id');
        $title_query->execute(array(
            ':title' => $data['title'],
            ':id' => $data['id']
        ));
    }
    if (isset($data['description'])) {
        $description_result = validate_description($data['description']);
        if ($description_result!== true) {
            throw new Exception($description_result);
        }

        $description_query = $pdo->prepare('UPDATE post SET description = :description WHERE id = :id');
        $description_query->execute(array(
            ':description' => $data['description'],
            ':id' => $data['id']
        ));
    }

    $pdo->commit();
    echo_success('Post updated successfully!');
} catch (Exception $e) {
    $pdo->rollBack();
    echo_fail($e->getMessage());
}
