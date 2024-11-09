<?php

require_once '../config/session.php';
include_once '../utils/request.php';
include_once '../utils/post.util.php';
include_once '../utils/uuid.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Unauthorized access!'
    ));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Invalid request!'
    ));
    exit();
}

if (!isset($_FILES['image'])) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'No image file provided!'
    ));
    exit();
}

if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => 'Error uploading image: ' . $_FILES['image']['error']
    ));
    exit();
}

try {
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
        echo json_encode(array(
            'status' => 'fail',
            'message' => $response['message'] ?? 'Data cannot be processed!'
        ));
        exit();
    }

    // Insert to db
    insert_post_record(array(
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'img_url' => $response->data->image->url,
        'description' => $_POST['description'],
        'poster_id' => encode_uuid($_SESSION['user_id']),
        'date_time' => (new DateTime())->format('Y-m-d H:i:s'),
        'likes' => 0
    ));

    echo json_encode(array(
        'status' => 'success',
        'message' => 'Image uploaded successfully!',
    ));
} catch (Exception $e) {
    echo json_encode(array(
        'status' => 'fail',
        'message' => $e->getMessage()
    ));
}
