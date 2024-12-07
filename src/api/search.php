<?php

require_once '../config/database.php';
require_once '../config/session.php';

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

    $search_term = preg_replace('/[+\-><()~*\"@]+/', '', $data['search_term'] );
    $limit = 9;
    $offset = intval(htmlspecialchars($data['offset'])) ?? 0;

    $post_search_query = $pdo->prepare("SELECT 
                                            id,
                                            title,
                                            img_url,
                                            description,
                                            date_time,
                                            likes,
                                            poster_id,
                                        FROM
                                            post
                                        WHERE 
                                            MATCH(title, description)
                                            AGAINST(:search_term)
                                        ORDER BY
                                            date_time DESC
                                        LIMIT
                                            $limit OFFSET $offset");
    $user_search_query = $pdo->prepare("SELECT
                                            id,
                                            username,
                                            profile_url
                                        FROM 
                                            user
                                        WHERE 
                                            MATCH(username, bio)
                                            AGAINST(:search_term)
                                        LIMIT
                                            $limit OFFSET $offset");

    $post_search_query->execute(array(
        ':searh_term' => $search_term
    ));
    $user_search_query->execute(array(
        ':searh_term' => $search_term
    ));

    $post_result = $post_search_query->fetchAll();
    $user_result = $user_search_query->fetchAll();
    foreach ($user_result as $key => &$value) {
        $value['id'] = parse_uuid($value['id']);
    }

    echo json_encode(array(
        'status' => 'success',
        'message' => 'Successully fetched search results!',
        'post_result' => $post_result,
        'user_result' => $user_result
    ));
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
