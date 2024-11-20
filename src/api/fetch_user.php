<?php
require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/echo_result.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo_fail('Invalid request!');
}

try {
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
        $result = $query->fetchAll();
    } else {
         // Get sppecific user info
         $query = $pdo->prepare('SELECT * FROM user WHERE id = :id');
         $query->execute(array(
             ':id' => encode_uuid($id),
         ));
         $result = $query->fetchAll();
    }

    foreach ($result as $key => &$value) {
        $value['id'] = parse_uuid($value['id']);
    }
    echo_success('Successfully retrieved user data!', $result);
} catch (PDOException $e) {
    echo_fail($e->getMessage());
}
