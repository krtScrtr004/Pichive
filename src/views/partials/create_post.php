<?php
require_once '../config/session.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<style>
    #img_preview {
        width: 400px;
        height: 400px;
    }
</style>

<section id="create_post_modal" popover>
    <section class="result_box"></section>
    <!-- Create Post Form -->
    <form action="" method="POST">
        <section class="form-head">
            <input type="text" name="title" id="title" placeholder="Title here..." min="1" max="50">
        </section>

        <section class="form-main">
            <label class="img_picker">
                <input type="file" name="file_picker" id="file_picker" accept="image/*" style="display: none;">
                <img id="img_preview" alt="Click to select image" title="Click to select image">
            </label>
            <input type="text" name="description" id="description" min="1" max="300">
        </section>

        <section class="form-buttons">
            <button id="post_btn">POST</button>
            <button id="cancel_btn">CANCEL</button>
        </section>
    </form>
</section>

<script type="module" src="../assets/js/event/create_post.js"></script>