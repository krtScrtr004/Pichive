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

$limit = 9;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

try {
    $query = $pdo->prepare("SELECT * FROM post ORDER BY date_time DESC LIMIT $limit OFFSET $offset");
    $query->execute();
    $result = $query->fetchAll();
    foreach ($result as $key => &$value) {
        $value['poster_id'] = parse_uuid($value['poster_id']);
    }
    unset($row);


    echo json_encode(array(
        'status' => 'success',
        'message' => 'Successfully retrieved post data!',
        'data' => $result
    ));
} catch (PDOException $e) {
    echo  json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}
