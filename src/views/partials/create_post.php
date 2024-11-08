<?php
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
//     header('Location: index.php');
//     exit();
// }
?>

<style>
    main {
        width: 1000px;
        height: 500px;
        background-color: red;
    }

    #image_preview {
        width: 400px;
        height: 400px;
    }
</style>

<main id="create_post_modal" popover>
    <form action="" method="POST">
        <section id="head">
            <input type="text" name="title" id="title" placeholder="Title here..." min="1" max="50">
        </section>
        <section id="main">
            <label class="image_picker">
                <input type="file" name="file_picker" id="file_picker" accept="image/*" style="display: none;">
                <img id="image_preview" src="../../assets/img/default_img_prev.png" alt="Click to select image" title="Click to select image">
            </label>
        </section>
        <section id=" buttons">
            <button id="post_btn">POST</button>
            <button id="cancel_btn">CANCEL</button>
        </section>
    </form>
</main>