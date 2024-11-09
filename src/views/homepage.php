<?php
include_once 'partials/create_post.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <button id="create_post_btn" popovertarget="create_post_modal">CREATE POST</button>
</body>

<script type="module" src="../assets/js/event/create_post.js"></script>
</html>