<?php
require_once '../config/session.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<link rel="stylesheet" href="../assets/style/create_post.css">
<link rel="stylesheet" href="../assets/style/modal.css">

<section id="create_post_modal" class="modal-wrapper">
    <span class="result_box"></span>

    <section class="modal create_post flex-column">
        <h3 class="heading-title">Create New Post</h3>
        
        <!-- Create Post Form -->
        <form id="create_post_form" action="" method="POST" class="flex-column">
            <section class="form-head">
                <input type="text" name="title" id="title" placeholder="Title here..." min="1" max="50">
            </section>

            <section class="form-main flex-row">
                <div class="img-selector flex-column">
                    <label class="img-picker">
                        <input type="file" name="file_picker" id="file_picker" accept="image/*">
                        <img id="img_preview" src="../assets/img/default_img_prev.png" alt="Click to select image" title="Click to select image" width="400" height="400">
                    </label>

                    <p>Select only image files (jpg, jpeg, png)</p>
                </div>

                <textarea name="description" id="description" cols="30" rows="10" maxlength="300" placeholder="Description..."></textarea>
            </section>

            <section class="form-buttons flex-row">
                <button id="cancel_btn" class="button">CANCEL</button>
                <button id="post_btn" class="button">POST</button> 
            </section>
        </form>
    </section>

</section>