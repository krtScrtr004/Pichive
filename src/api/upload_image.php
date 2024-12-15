<?php

require_once '../config/session.php';
include_once '../utils/request.php';
include_once '../utils/post.util.php';
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

    $file_path = $_FILES['image']['tmp_name'];
    // Read the binary content of the image and base64 encode it
    $image_encoded = base64_encode(file_get_contents($file_path));
    $response = send_file('https://api.imgbb.com/1/upload', array(
        'key' => $_ENV['IMGBB_API'],
        'title' => $_POST['title'],
        'image' => $image_encoded,
        'description' => $_POST['description'],
    ));

    if (
        !$response ||
        !isset($response->status) ||
        $response->status === 'fail'
    ) {
        throw new Exception($response['message'] ?? 'Data cannot be processed!');
    }

    // Insert to db
    insert_post_record(array(
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'img_url' => $response->data->image->url,
        'poster_id' => encode_uuid($_SESSION['user_id']),
        'date_time' => (new DateTime())->format('Y-m-d H:i:s'),
        'likes' => 0
    ));

    echo_success('Image uploaded successfully!');
} catch (Exception $e) {
    echo_fail($e->getMessage());
}
