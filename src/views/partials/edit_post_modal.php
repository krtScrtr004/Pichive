<?php
require_once '../config/session.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<link rel="stylesheet" href="../assets/style/generic.css">
<link rel="stylesheet" href="../assets/style/modal.css">
<link rel="stylesheet" href="../assets/style/utils.css">
<link rel="stylesheet" href="../assets/style/create_post.css">
<link rel="stylesheet" href="../assets/style/edit_post.css">

<section id="edit_post_modal" class="modal-wrapper">

    <section class="modal edit_post flex-column light-background dark-text">
        <span class="result"></span>

        <section class="form-head flex-column">
            <h3 class="dark-text heading-title">Edit Post</h3>
            <input type="text" name="title" id="title" placeholder="Title here..." min="1" max="50">
        </section>

        <section class="form-main flex-row">
            <img id="post_img" src="../assets/img/default_img_prev.png" alt="Image Post" title="Image Post">
            <div class="flex-column">
                <textarea name="description" id="description" id="description" cols="30" rows="10" maxlength="300"></textarea>
            </div>
        </section>

        <section class="form-buttons flex-row">
            <button id="cancel_btn" class="button">CANCEL</button>
            <button id="edit_btn" class="success-btn button">EDIT</button>
        </section>
    </section>
</section>