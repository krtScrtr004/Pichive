<?php
require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/echo_result.php';

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Unauthorized user!');
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request!');
    }

    $content_type = htmlspecialchars($_GET['content_type']) ?? 'home';
    $limit = 9;
    $offset = intval(htmlspecialchars($_GET['offset'])) ?? 0;



    $query = null;
    if ($content_type === 'home') {
        // Only include own, follower, and followed users' posts
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
                                    post AS p
                                INNER JOIN 
                                    user AS u 
                                ON 
                                    p.poster_id = u.id 
                                LEFT JOIN 
                                    follow AS f
                                ON 
                                    p.poster_id = f.their_id AND f.my_id = :id
                                WHERE 
                                    f.my_id = :id OR p.poster_id = :id
                                ORDER BY 
                                    p.date_time DESC 
                                LIMIT 
                                    $limit OFFSET $offset");
        $query->execute(array(
            ':id' => encode_uuid($_SESSION['user_id'])
        ));
    } else if ($content_type === 'explore') {
        // Include all users' posts excluding blocked users
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
                                    post AS p
                                INNER JOIN 
                                    user AS u 
                                ON 
                                    p.poster_id = u.id 
                                LEFT JOIN 
                                    block AS b 
                                ON 
                                    b.my_id = :id AND b.their_id = u.id
                                WHERE 
                                    b.their_id IS NULL
                                ORDER BY 
                                    p.date_time DESC 
                                LIMIT 
                                    $limit OFFSET $offset");
        $query->execute(array(
            ':id' => encode_uuid($_SESSION['user_id'])
        ));
    } else if ($content_type === 'profile') {
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
                                WHERE 
                                    p.poster_id = :id
                                ORDER BY date_time DESC 
                                LIMIT $limit OFFSET $offset");
        $query->execute(array(
            ':id' => encode_uuid(htmlspecialchars($_GET['id']) ?? $_SESSION['user_id'])
        ));
    }

    $result = $query->fetchAll();
    foreach ($result as $key => &$value) {
        $value['poster_id'] = parse_uuid($value['poster_id']);
    }
    unset($value);

    echo_success('Successfully retrieved post data!', $result);
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
