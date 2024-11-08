<?php
// User Authenticator Functions

// TODO: Make this a class

require_once '../config/database.php';
include_once '../utils/uuid.php';

function authenticate_username($username) {
    global $pdo;
    try {
        // TODO: Try to minimize the return of this query
        $query = $pdo->prepare('SELECT * FROM user WHERE username = :username');
        $query->execute(array(
            ':username' => $username
        ));
        return $query->fetch();
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }

}

function authenticate_email($email)
{
    global $pdo;
    try {
        // TODO: Try to minimize the return of this query
        $query = $pdo->prepare('SELECT * FROM user WHERE email = :email');
        $query->execute(array(
            ':email' => $email
        ));
        return $query->fetch();
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }
}

function authenticate_id($id) {
    global $pdo;
    try {
        // TODO: Try to minimize the return of this query
        $query = $pdo->prepare('SELECT * FROM user WHERE id = :id');
        $query->execute(array(
            ':id' => encode_uuid($id)
        ));
        return $query->fetch();
    } catch (PDOException $e) {
        throw new PDOException('Database error: ' . $e->getMessage());
    }
}
