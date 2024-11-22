<?php
// Cridential Validation Functions

require_once '../config/database.php';

// Username Validator
function validate_username($username)
{
    if (!$username) {
        return 'Username is not defined';
    }

    $min_len = 3;
    $max_len = 15;
    // Check is username is valid
    if (strlen($username) < $min_len || strlen($username) > $max_len) {
        return "Username must be between $min_len and $max_len characters long";
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        return 'Username can only contain letters, numbers, and underscores';
    }

    return true;
}

// Email Validator 
function validate_email($email)
{
    if (!$email) {
        return 'Email is not defined';
    }
    // Check if email address is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email address!';
    }
    return true;
}

function validate_password($password)
{
    if (!$password) {
        return 'Password is not defined';
    }

    $min_len = 8;
    $max_len = 128;
    if (strlen($password) < $min_len || strlen($password) > $max_len) {
        return "Username must be between $min_len and $max_len characters long";
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

function validate_bio($bio) {
    if (!$bio) {
        return 'Bio is not defined';
    }

    if (empty(trim($bio))) {
        return 'Bio cannot be empty.';
    }
    // Check bio length (using mb_strlen to account for multibyte characters like emojis)
    $max_len = 300;
    if (mb_strlen($bio, 'UTF-8') > $max_len) {
        return "Bio cannot exceed $max_len characters.";
    }

    return true;
}

function validate_image($file) {
    if (!$file) {
        return 'Image is not defined';
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 32 * 1024 * 1024; // 32 MB

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['isValid' => false, 'message' => 'Error uploading the file.'];
    }
    // Check file size
    if ($file['size'] > $max_size) {
        return 'File size exceeds 32MB limit.';
    }

    // Check MIME type
    $f_info = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($f_info, $file['tmp_name']);
    finfo_close($f_info);
    if (!in_array($mime_type, $allowed_types)) {
        return 'Invalid file type. Only JPEG, PNG, and GIF are allowed.';
    }

    return true;
}

function validate_description($description) {
    if (!$description) {
        return 'Description is not defined!';
    }

    if (empty(trim($description))) {
        return 'Description cannot be empty.';
    }

    $min_len = 10;
    $max_len = 300;
    if (strlen($description) < $min_len || strlen($description) > $max_len) {
        return 'Description must be between 10 and 300 characters long!';
    }

    return true;
}
