<?php
require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/echo_result.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request!');
    }
    
    $query = $result = null;
    $id = $_GET['id'] ?? $_SESSION['user_id'];

    if (isset($_GET['relation']) && $_GET['relation']) {
        // Get all user accord to relation
        if ($_GET['relation'] === 'followed') {
            // Get user followed users
            $query = $pdo->prepare('SELECT
                                        u.id,
                                        u.username,
                                        u.profile_url,
                                        u.bio
                                    FROM
                                        user AS u
                                    INNER JOIN
                                        follow AS f
                                    ON
                                        u.id = f.their_id
                                    WHERE 
                                        f.my_id = :id');
            $query->execute(array(
                ':id' => encode_uuid($id),
            ));
        } else if ($_GET['relation'] === "follower") {
            // Get user followers
            $query = $pdo->prepare('SELECT
                                        u.id,
                                        u.username,
                                        u.profile_url,
                                        u.bio
                                    FROM
                                        user AS u
                                    INNER JOIN
                                        follow AS f
                                    ON
                                        u.id = f.my_id
                                    WHERE 
                                        f.their_id = :id');
            $query->execute(array(
                ':id' => encode_uuid($id),
            ));
        }
    } else {
        // Get sppecific user info

        if ($id === $_SESSION['user_id']) {
            // Get user own information
            $query = $pdo->prepare('SELECT * FROM user WHERE id = :id');
            $query->execute(array(
                ':id' => encode_uuid($id),
            ));
        } else {
            // Get other user information
            $query = $pdo->prepare('SELECT 
                                        u.id,
                                        u.username,
                                        u.profile_url,
                                        u.bio,
                                        CASE 
                                            WHEN f.my_id IS NOT NULL THEN 1
                                            ELSE 0
                                        END AS is_followed,
                                        CASE 
                                            WHEN b.my_id IS NOT NULL THEN 1
                                            ELSE 0
                                        END AS is_blocked
                                    FROM 
                                        user u
                                    LEFT JOIN 
                                        follow f
                                    ON 
                                        u.id = f.their_id AND f.my_id = :my_id
                                    LEFT JOIN 
                                        block b
                                    ON 
                                        u.id = b.their_id AND b.my_id = :my_id
                                    WHERE 
                                        u.id = :id');
            $query->execute(array(
                ':my_id' => encode_uuid($_SESSION['user_id']),
                ':id' => encode_uuid($id)
            ));
        }
    }

    $result = $query->fetchAll();
    foreach ($result as $key => &$value) {
        $value['id'] = parse_uuid($value['id']);
    }
    echo_success('Successfully retrieved user data!', $result);
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
