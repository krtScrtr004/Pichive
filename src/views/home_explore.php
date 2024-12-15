<?php
require_once '../config/session.php';
include_once 'partials/create_post.php';
include_once 'partials/post_modal.php';

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_email']) ||
    !isset($_GET['page'])
) {
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
    <link rel="stylesheet" href="../assets/style/generic.css">
    <link rel="stylesheet" href="../assets/style/utils.css">
    <link rel="stylesheet" href="../assets/style/img_grid.css">
    <link rel="stylesheet" href="../assets/style/modal.css">
</head>

<!-- Note: 'data-page' determine which page to render (home / explore) -->
<body class="wrapper flex-row" data-page="<?php echo ($_GET['page']); ?>">
    <?php include_once '../component/sidenav.php' ?>

    <section class=center>
        <?php include_once '../component/header.php' ?>

        <main>
            <div id="result-box"></div>
            <!-- Note: 'data-content' determine which post content to fetch (home / explore / profile) -->
            <div class="img-grid" data-content="<?php echo  htmlspecialchars($_GET['page']); ?>">
        
            </div>

            <div class="loading">Loading more images...</div>
        </main>
    </section>

    <script type="module" src="../assets/js/event/profile_icon_menu.js"></script>
    <script type="module" src="../assets/js/event/drop_down.js"></script>
    <script type="module" src="../assets/js/event/create_post.js"></script>
    <script type="module" src="../assets/js/event/fetch_sidenav_user.js"></script>
    <script type="module" src="../assets/js/event/fetch_post.js"></script>
    <script type="module" src="../assets/js/event/search.js"></script>
    <script type="module" src="../assets/js/event/comment.js"></script>
</body>

</html>