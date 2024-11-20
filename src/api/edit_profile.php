<?php

require_once '../config/database.php';
require_once '../config/session.php';

include_once '../utils/uuid.php';
include_once '../utils/request.php';
include_once '../utils/authenticate_user.php';
include_once '../utils/validation.php';
include_once '../utils/echo_result.php';

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Error('Unauthorized user!');
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Error('Invalid request!');
    }    

    $pdo->beginTransaction();
    if (isset($_POST['username'])) {
        $username_result = validate_username($_POST['username']);
        if ($username_result !== true) {
            $pdo->rollBack();
            echo_fail($username_result);
        } else {
            $search_duplicate_username = authenticate_username($_POST['username']);
            if ($search_duplicate_username) {
                $pdo->rollBack();
                throw new Error('Username already exists!');
            }
        }

        $username_query = $pdo->prepare('UPDATE user SET username = :username WHERE id = :id');
        $username_query->execute(array(
            ':username' => $_POST['username'],
            ':id' => encode_uuid($_SESSION['user_id'])
        ));
    }
    if (isset($_POST['password'])) {
        $password_result = validate_password($_POST['password']);
        if ($password_result !== true) {
            $pdo->rollBack();
            echo_fail($password_result);
        }

        $password_query = $pdo->prepare('UPDATE user SET password = :password WHERE id = :id');
        $password_query->execute(array(
            ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ':id' => encode_uuid($_SESSION['user_id'])
        ));
    }
    if (isset($_POST['bio'])) {
        $bio_result = validate_bio($_POST['bio']);
        if ($bio_result !== true) {
            $pdo->rollBack();
            throw new Error($bio_result);
        }

        $bio_query = $pdo->prepare('UPDATE user SET bio = :bio WHERE id = :id');
        $bio_query->execute(array(
            ':bio' => $_POST['bio'],
            ':id' => encode_uuid($_SESSION['user_id'])
        ));
    }
    if (isset($_FILES['profile_img'])) {
        $profile_img_result = validate_image($_FILES['profile_img']);
        if ($profile_img_result !== true) {
            $pdo->rollBack();
            throw new Error($profile_img_result);
        }

        $file_path = $_FILES['profile_img']['tmp_name'];
        // Read the binary content of the image and base64 encode it
        $image_encoded = base64_encode(file_get_contents($file_path));
        $response = send_file('https://api.imgbb.com/1/upload', array(
            'key' => $_ENV['IMGBB_API'],
            'image' => $image_encoded,
        ));
        if (
            !$response ||
            !isset($response->status) ||
            $response->status === 'fail'
        ) {
            $pdo->rollBack();
            throw new Error($response['message'] ?? 'Data cannot be processed!');
        }
    
        $profile_query = $pdo->prepare('UPDATE user SET profile_url = :profile_url WHERE id = :id');
        $profile_query->execute(array(
            ':profile_url' => $response->data->image->url,
            ':id' => encode_uuid($_SESSION['user_id'])
        ));
    }

    $pdo->commit();
    echo_success('Profile information updated successfully!');
} catch (Exception $e) {
    $pdo->rollBack();
    echo_fail($e->getMessage());
}
