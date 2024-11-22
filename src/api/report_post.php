<?php

require_once '../config/database.php';
require_once '../config/session.php';

include_once '../utils/uuid.php';
include_once '../utils/authenticate_post.php';
include_once '../utils/validation.php';
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

    if (!authenticate_post($data['id'])) {
        throw new Exception('Invalid post ID!');
    }

    $description_result = validate_description($data['description']);
    if ($description_result !== true) {
        throw new Exception($description_result);
    }

    $query = $pdo->prepare('INSERT INTO report(user_id, post_id, description) VALUES(:user_id, :post_id, :description)');
    $query->execute(array(
        ':user_id' => encode_uuid($_SESSION['user_id']),
        ':post_id' => $data['id'],
        ':description' => $data['description']
    ));

    echo_success('Post liked successfully!');
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
