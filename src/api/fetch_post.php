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
    $query = $pdo->prepare("SELECT 
                                p.id,
                                p.title, 
                                p.img_url, 
                                p.description, 
                                p.date_time, 
                                p.likes,
                                p.poster_id, 
                                u.username 
                            FROM 
                                post as p 
                            INNER JOIN 
                                user as u 
                            ON 
                                p.poster_id = u.id 
                            ORDER BY date_time DESC 
                            LIMIT $limit OFFSET $offset");
    $query->execute();
    $result = $query->fetchAll();
    foreach ($result as $key => &$value) {
        $value['poster_id'] = parse_uuid($value['poster_id']);
    }
    unset($value);

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
