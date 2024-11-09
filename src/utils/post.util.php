<?php

require_once '../config/database.php';

function insert_post_record($obj) {
    global $pdo;
    try {
        $query = $pdo->prepare('INSERT INTO post(title, img_url, description, poster_id, date_time, likes) VALUES (:title, :img_url, :description, :poster_id, :date_time, :likes)');
        $query->execute(array(
            ':title' => $obj['title'],
            ':img_url' => $obj['img_url'],
            ':description' => $obj['description'],
            ':poster_id' => $obj['poster_id'],
            ':date_time' => $obj['date_time'],
            ':likes' => $obj['likes']
        ));
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }
}