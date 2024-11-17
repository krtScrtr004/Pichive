<?php
require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/echo_result.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo_fail('Invalid request!');
}

$id = $_GET['id'] ?? $_SESSION['user_id'];
try {
    $query = $pdo->prepare('SELECT * FROM user WHERE id = :id');
    $query->execute(array(
        ':id' => encode_uuid($id),
    ));
    $result = $query->fetch();
    if (!$result) {
       echo_fail('User not found!');
    }

    $result['id'] = parse_uuid($result['id']);
    echo_success('Successfully retrieved user data!', $result);
} catch (PDOException $e) {
    echo_fail($e->getMessage());
}
