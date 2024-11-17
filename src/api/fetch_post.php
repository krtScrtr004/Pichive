<?php
require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/echo_result.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo_fail('Invalid request!');
}

$content_type = htmlspecialchars($_GET['content_type']) ?? 'home';
$limit = 9;
$offset = intval(htmlspecialchars($_GET['offset'])) ?? 0;

try {
    $query = null;
    if ($content_type === 'home') {
        // TODO: Ayusin mo ito putang ina ka
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
    } else if ($content_type === 'explore') {
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
} catch (PDOException $e) {
    echo_fail($e->getMessage());
}
