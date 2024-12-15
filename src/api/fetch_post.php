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
                                    u.username,
                                    u.profile_url,
                                    CASE 
                                        WHEN p.poster_id = :id THEN 1 
                                        ELSE 0 
                                    END AS is_own,
                                    CASE 
                                        WHEN pl.user_id IS NOT NULL THEN 1
                                        ELSE 0
                                    END AS is_liked
                                FROM 
                                    post AS p
                                INNER JOIN 
                                    user AS u 
                                ON 
                                    p.poster_id = u.id 
                                LEFT JOIN 
                                    follow AS f
                                ON 
                                    (f.their_id = p.poster_id AND f.my_id = :id)  -- Current user follows poster
                                    OR 
                                    (f.my_id = p.poster_id AND f.their_id = :id) -- Poster follows current user
                                LEFT JOIN 
                                    p_like AS pl
                                ON 
                                    p.id = pl.post_id AND pl.user_id = :id
                                LEFT JOIN 
                                    report AS r
                                ON 
                                    p.id = r.post_id AND r.user_id = :id
                                WHERE 
                                    (p.poster_id = :id OR f.id IS NOT NULL) -- Own posts or valid follow relationship
                                    AND r.post_id IS NULL  -- Exclude reported posts
                                ORDER BY 
                                    p.date_time DESC 
                                LIMIT 
                                    $limit OFFSET $offset;");
        $query->execute(array(
            ':id' => encode_uuid($_SESSION['user_id']),
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
                                    u.username,
                                    u.profile_url,
                                    CASE 
                                        WHEN p.poster_id = :id THEN 1 
                                        ELSE 0 
                                    END AS is_own,
                                    CASE 
                                        WHEN pl.user_id IS NOT NULL THEN 1
                                        ELSE 0
                                    END AS is_liked
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
                                LEFT JOIN 
                                    p_like AS pl
                                ON 
                                    pl.post_id = p.id AND pl.user_id = :id
                                LEFT JOIN 
                                    report AS r
                                ON 
                                    r.post_id = p.id AND r.user_id = :id
                                WHERE 
                                    b.their_id IS NULL
                                    AND r.post_id IS NULL -- Exclude reported posts
                                ORDER BY 
                                    p.date_time DESC 
                                LIMIT 
                                    $limit OFFSET $offset");
        $query->execute(array(
            ':id' => encode_uuid($_SESSION['user_id']),
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
                                    u.username,  
                                    u.profile_url,                                                             
                                    CASE 
                                        WHEN p.poster_id = :id THEN 1 
                                        ELSE 0 
                                    END AS is_own,
                                    CASE 
                                        WHEN pl.user_id IS NOT NULL THEN 1
                                        ELSE 0
                                    END AS is_liked
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
                                LEFT JOIN 
                                    p_like AS pl
                                ON 
                                    pl.post_id = p.id AND pl.user_id = :id
                                WHERE 
                                    p.poster_id = :id AND
                                    b.their_id IS NULL
                                ORDER BY 
                                    p.date_time DESC 
                                LIMIT 
                                    $limit OFFSET $offset");
        $query->execute(array(
            ':id' => encode_uuid($_GET['id'] ?? $_SESSION['user_id']),
        ));
    } else if ($content_type === 'like') {
        $query = $pdo->prepare("SELECT 
                                    p.id,
                                    p.title, 
                                    p.img_url, 
                                    p.description, 
                                    p.date_time, 
                                    p.likes,
                                    p.poster_id, 
                                    u.username,
                                    CASE 
                                        WHEN p.poster_id = :id THEN 1 
                                        ELSE 0 
                                    END AS is_own,
                                    CASE 
                                        WHEN pl.user_id IS NOT NULL THEN 1
                                        ELSE 0
                                    END AS is_liked
                                FROM 
                                    post AS p
                                INNER JOIN 
                                    user AS u   
                                ON 
                                    p.poster_id = u.id
                                INNER JOIN 
                                    p_like AS l
                                ON 
                                    p.id = l.post_id AND l.user_id = :id -- Fetch posts liked by the user
                                LEFT JOIN 
                                    block AS b 
                                ON 
                                    b.my_id = :id AND b.their_id = u.id
                                LEFT JOIN 
                                    p_like AS pl
                                ON 
                                    pl.post_id = p.id AND pl.user_id = :id
                                LEFT JOIN 
                                    report AS r
                                ON 
                                    r.post_id = p.id AND r.user_id = :id
                                WHERE 
                                    b.their_id IS NULL
                                    AND r.post_id IS NULL -- Exclude reported posts
                                ORDER BY 
                                    pl.date_time DESC 
                                LIMIT 
                                    $limit OFFSET $offset");
        $query->execute(array(
            ':id' => encode_uuid($_SESSION['user_id']),
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
