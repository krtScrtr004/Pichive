<?php
require_once '../config/session.php';
include_once 'partials/create_post.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<header>
    <button id="create_post_btn" popovertarget="create_post_modal">CREATE POST</button>
</header>