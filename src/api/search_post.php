<?php

require_once '../config/database.php';
require_once '../config/session.php';

include_once '../utils/uuid.php';
include_once '../utils/validation.php';
include_once '../utils/echo_result.php';

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Unauthorized user!');
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request!');
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        throw new Exception('Data cannot be parsed!');
    }

    if (!isset($data['search_term'])) {
        throw new Exception("Missing required paramater: 'search_term'");
    }

    $search_term_result = validate_search_term($data['search_term']);
    if ($search_term_result !== true) {
        throw new Exception($search_term_result);
    }

    $search_term = preg_replace('/[+\-><()~*\"@]+/', '', $data['search_term']);
    $limit = 9;
    $offset = intval(htmlspecialchars($data['offset'])) ?? 0;

    $query = $pdo->prepare("SELECT 
                                p.id,
                                p.title,
                                p.img_url,
                                p.description,
                                p.date_time,
                                p.likes,
                                p.poster_id,
                                CASE 
                                    WHEN pl.user_id IS NOT NULL THEN 1
                                    ELSE 0
                                END AS is_liked
                            FROM
                                post AS p
                            LEFT JOIN
                                p_like AS pl
                            ON
                                p.id = pl.post_id AND pl.user_id = :user_id
                            LEFT JOIN
                                block AS b
                            ON
                                b.my_id = :user_id AND b.their_id = p.poster_id -- Check for blocked users
                            WHERE 
                                MATCH(p.title, p.description) AGAINST(:search_term IN BOOLEAN MODE)
                                AND b.their_id IS NULL -- Exclude posts from blocked users
                            ORDER BY
                                p.date_time DESC
                            LIMIT
                                $limit OFFSET $offset");
    $query->execute(array(
        ':user_id' => encode_uuid($_SESSION['user_id']),
        ':search_term' => $search_term . '*'
    ));

    $result = $query->fetchAll();
    foreach ($result as $key => &$value) {
        $value['poster_id'] = parse_uuid($value['poster_id']);
    }
    unset($value);

    echo_success('Successully retrieved post search results!', $result);
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
