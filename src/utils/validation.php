<?php
require_once '../config/database.php';

// Username Validator
function validateUsername($username)
{
    // Check is username is valid
    if (strlen($username) < 3 || strlen($username) > 15) {
        return 'Username must be between 3 and 15 characters long';
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        return 'Username can only contain letters, numbers, and underscores';
    }

    return true;
}

// Email Validator 
function validateEmail($email)
{
    // Check if email address is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email address!';
    }
    return true;
}

function validatePassword($password)
{
    if (strlen($password) < 8 || strlen($password) > 128) {
        return 'Username must be between 3 and 128 characters long';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return 'Password must contain at least one uppercase letter';
    }
    if (!preg_match('/[a-z]/', $password)) {
        return 'Password must contain at least one lowercase letter';
    }
    if (!preg_match('/[0-9]/', $password)) {
        return 'Password must contain at least one number';
    }
    if (!preg_match('/[\W_]/', $password)) { // \W matches any "non-word" character
        return 'Password must contain at least one special character';
    }
    return true;
}
