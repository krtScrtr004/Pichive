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

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        width: 100%;
        height: 100%;
    }

    .wrapper {
        width: 100%;
        height: 100%;
    }

    .modal {
        width: 80%;
        height: 70%;
        display: flex;
        z-index: 100;
        overflow-y: hidden;
    }

    .show_modal {
        display: flex !important;
    }

    .img_grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
    }

    .img_grid>div {
        width: 300px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: solid 1px black;
    }

    .img_cont>img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<body>
    <?php
    include_once '../component/header.php';
    include_once 'partials/post_modal.php';
    ?>

    <main class="wrapper">
        <div id="result_box"></div>

        <div class="img_grid">
        </div>

        <div id="loading">Loading more images...</div>
    </main>
</body>

<script type="module" src="../assets/js/event/create_post.js"></script>
<script type="module" src="../assets/js/event/fetch_img.js"></script>

</html>