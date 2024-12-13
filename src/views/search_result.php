<?php
require_once '../config/session.php';
include_once 'partials/create_post.php';
include_once 'partials/post_modal.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
    <link rel="stylesheet" href="../assets/style/generic.css">
    <link rel="stylesheet" href="../assets/style/utils.css">
    <link rel="stylesheet" href="../assets/style/img_grid.css">
    <link rel="stylesheet" href="../assets/style/modal.css">
    <link rel="stylesheet" href="../assets/style/search_result.css">
</head>

<body class="wrapper flex-row">
    <?php include_once '../component/sidenav.php' ?>

    <section class=center>
        <?php include_once '../component/header.php' ?>

        <main>
            <div id="result-box"></div>

            <div class="search-result flex-row">
                <div class="img-grid" data-content="search"></div>

                <div id="search_user_list" class="user-list flex-column"></div>
            </div>

            <div class="loading">Loading more images...</div>
        </main>
    </section>

    <script type="module" src="../assets/js/event/profile_icon_menu.js"></script>
    <script type="module" src="../assets/js/event/create_post.js"></script>
    <script type="module" src="../assets/js/event/fetch_sidenav_user.js"></script>
    <script type="module" src="../assets/js/event/fetch_post.js"></script>
    <script type="module" src="../assets/js/event/search.js"></script>
    <script type="module" src="../assets/js/event/comment.js"></script>
</body>

</html>