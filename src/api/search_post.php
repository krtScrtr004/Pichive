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

    $search_term = preg_replace('/[+\-><()~*\"@]+/', '', $data['search_term'] );
    $limit = 9;
    $offset = intval(htmlspecialchars($data['offset'])) ?? 0;

    $query = $pdo->prepare("SELECT 
                                id,
                                title,
                                img_url,
                                description,
                                date_time,
                                likes,
                                poster_id
                            FROM
                                post
                            WHERE 
                                MATCH(title, description)
                                AGAINST(:search_term IN BOOLEAN MODE)
                            ORDER BY
                                date_time DESC
                            LIMIT
                                $limit OFFSET $offset");
    $query->execute(array(
        ':search_term' => $search_term . '*'
    ));

    $result = $query->fetchAll();
    foreach ($result as $key => &$value) {
        $value['poster_id'] = parse_uuid($value['poster_id']);
    }
    unset($value);
  
    echo_success('Successully retrieved search results!', $result);
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
