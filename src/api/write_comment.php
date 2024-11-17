<?php

require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/authenticate_user.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo_fail('Invalid request!');
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo_fail('Data cannot be parsed!');
}

try {
    $comment_len = strlen($data['comment']);
    if ($comment_len < 1 || $comment_len > 300) {
        echo_fail('Comment length should be between 1 and 300 characters!');
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
    echo_success('Comment added successfully!', array(
        'commenter_name' => $search_user['username'],
        'img_url' => $search_user['img_url'],
        'comment_date' => $date
    ));
} catch (PDOException $e) {
    echo_fail($e->getMessage());
}
