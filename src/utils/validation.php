<?php
include_once '../config/database.php';

// Username Validator
function validateUsername($username)
{
    global $pdo;
    try {
        // Check is username is valid
        if (strlen($username) < 3 || strlen($username) > 15) {
            return 'Username must be between 3 and 15 characters long.';
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            return 'Username can only contain letters, numbers, and underscores.';
        }

        // Check if username address is already used
        $query = $pdo->prepare('SELECT username FROM user WHERE username = :username');
        $query->execute([
            'username' => $username
        ]);
        $result = $query->fetchAll();
        if (count($result) > 0) {
            return 'Username address already exists!';
        }

        return true;
    } catch (PDOException $e) {
        return 'Query failed: ' . $e->getMessage();
    }
}

// Email Validator 
function validateEmail($email)
{
    global $pdo;
    try {
        // Check if email address is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email address!';
        }

        // Check if email address is already used
        $query = $pdo->prepare('SELECT email FROM user WHERE email = :email');
        $query->execute([
            'email' => $email
        ]);
        $result = $query->fetchAll();
        if (count($result) > 0) {
            return 'Email address already exists!';
        }

        return true;
    } catch (PDOException $e) {
        return 'Query failed! ' . $e->getMessage();
    }
}

function validatePassword($password) {
    if (strlen($password) < 8 || strlen($password) > 128) {
        return 'Username must be between 3 and 128 characters long.';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return 'Password must contain at least one uppercase letter.';
    }
    if (!preg_match('/[a-z]/', $password)) {
        return 'Password must contain at least one lowercase letter.';
    }
    if (!preg_match('/[0-9]/', $password)) {
        return 'Password must contain at least one number.';
    }
    if (!preg_match('/[\W_]/', $password)) { // \W matches any "non-word" character
        return 'Password must contain at least one special character.';
    }
    return true;
}
