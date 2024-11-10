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
    }

    body {
        width: 100%;
        height: 100%;
    }

    .wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;;
        gap: 10px;
    }

    .wrapper>div {
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
    <?php include '../component/header.php' ?>

    <div id="result_box"></div>

    <div class="wrapper">
        <div class="img_cont">
            <img src="../assets/img/default_img_prev.png" alt="">
        </div>
    </div>
    
    <div id="loading">Loading more images...</div>
</body>

<script type="module" src="../assets/js/event/create_post.js"></script>
<script type="module" src="../assets/js/event/fetch_img.js"></script>

</html>