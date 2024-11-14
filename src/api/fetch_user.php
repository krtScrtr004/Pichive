<?php
require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';

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

$id = htmlspecialchars($_GET['id']) ?? $_SESSION['user_id'];
try {
    $query = $pdo->prepare('SELECT * FROM user WHERE id = :id');
    $query->execute(array(
        ':id' => $id,
    ));
    $result = $query->fetch();
    if (!$result) {
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'User not found!'
        ));
        exit();
    }

    $result['id'] = parse_url($result['id']);
    echo json_encode(array(
        'status' => 'sucess',
        'message' => 'User details successfully fetched!',
        'data' => $result
    ));
} catch (PDOException $e) {
    echo  json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}
