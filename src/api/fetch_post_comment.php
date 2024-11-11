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

try {
    $query = null;
    if ($_GET['has_already_ran'] === 'false') {
        $query = $pdo->query('SELECT * FROM p_comment ORDER BY likes DESC, date_time DESC');
    } else {
        $query = $pdo->prepare('SELECT * FROM p_comment WHERE date_time = :date_time ORDER BY likes DESC');
        $query->execute(array(
            ':date_time' => (new DateTime())->format('Y-m-d H:i:s')
        ));
    }

    $result = $query->fetchAll();
    foreach ($result as $key => &$value) {
        $search_user = authenticate_id(parse_uuid($value['commenter_id']));
        if ($search_user) {
            $value['commenter_name'] = $search_user['username'];
        } else {
            $value['commenter_name'] = null;
        }
        unset($value['commenter_id']); // Remove commenter_id before returning the response
    }
    unset($row);


    echo json_encode(array(
        'status' => 'success',
        'message' => 'Successfully fetched comments!',
        'data' => $result
    ));
} catch (PDOException $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}
