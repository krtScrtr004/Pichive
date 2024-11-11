<?php
require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/authenticate_user.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Invalid request!'
    ));
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
try {
    $query = $pdo->prepare('SELECT * FROM post WHERE id = :id');
    $query->execute(array(
        'id' => $id
    ));
    $result = $query->fetch();
    if (!$result) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Post not found!'
        ));
        exit();
    }

    $search_user = authenticate_id(parse_uuid($result['poster_id']));
    if (!$search_user) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Image poster cannot be verified!'
        ));
        exit();
    }

    echo json_encode(array(
        'status' => 'success',
        'message' => 'Successfully retrieved post details!',
        'data' => array(
            'img_url' => $result['img_url'],
            'poster_name' => $search_user['username'],
            'poster_id' => parse_uuid($search_user['id']),
            'title' => $result['title'],
            'description' => $result['description'],
            'date' => $result['date_time']
        ) 
    ));
} catch (PDOException $e) {
    echo  json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}
