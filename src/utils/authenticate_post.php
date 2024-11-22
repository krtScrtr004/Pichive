<?php 
require_once '../config/database.php';

function authenticate_post($id) {
    global $pdo;
    try {
        $query = $pdo->prepare('SELECT * FROM post WHERE id = :id');
        $query->execute(array(
            ':id' => $id
        ));

        return $query->fetch();
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }
}