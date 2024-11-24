<?php

require_once '../config/database.php';
require_once '../config/session.php';
include_once '../utils/uuid.php';
include_once '../utils/authenticate_user.php';
include_once '../utils/echo_result.php';

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Unauthorized user!');
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request!');
    }
    
    $query = null;
    if ($_GET['has_already_ran'] === 'false') {
        // $query = $pdo->query('SELECT * FROM p_comment ORDER BY likes DESC, date_time ASC');
        $query = $pdo->query('SELECT 
                                p.*,
                                u.username,
                                u.profile_url
                            FROM 
                                p_comment AS p
                            INNER JOIN
                                user AS u
                            ON 
                                p.commenter_id = u.id
                            ORDER BY 
                                likes DESC, 
                                date_time ASC');
    } else {
        $query = $pdo->prepare('SELECT 
                                    p.*, 
                                    u.username,
                                    u.profile_url
                                FROM 
                                    p_comment AS p
                                INNER JOIN
                                    user AS u
                                ON 
                                    p.commenter_id = u.id 
                                WHERE 
                                    date_time = :date_time 
                                ORDER BY 
                                    likes ASC');
        $query->execute(array(
            ':date_time' => (new DateTime())->format('Y-m-d H:i:s')
        ));
    }

    $result = $query->fetchAll();
    foreach ($result as $key => &$value) {
        unset($value['commenter_id']); // Remove commenter_id before returning the response
    }
    unset($value);

    echo_success('Successfully fetched comments!', $result);
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
