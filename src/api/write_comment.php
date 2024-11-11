<?php

require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/authenticate_user.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}

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
    $comment_len = strlen($data['comment']);
    if ($comment_len < 1 || $comment_len > 300) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Comment length should be between 1 and 300 characters!'
        ));
        exit();
    }
    $date = (new DateTime())->format('Y-m-d H:i:s');
    $query = $pdo->prepare('INSERT INTO p_comment(commenter_id, post_id, comment, date_time, likes) VALUES (:commenter_id, :post_id, :comment, :date_time, :likes)');
    $query->execute(array(
        ':commenter_id' => encode_uuid($_SESSION['user_id']),
        ':post_id' => $data['post_id'],
        ':comment' => $data['comment'],
        ':date_time' => $date,
        ':likes' => 0
    ));
    
    $search_user = authenticate_id($_SESSION['user_id']);
    echo json_encode(array(
       'status' =>'success',
       'message' => 'Comment added successfully!',
       'data' => array(
            'commenter_name' => $search_user['username'] ?? null,
            'img_url' => $search_user['img_url'] ?? null,
            'comment_date' => $date ?? null
       )
    ));

} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}