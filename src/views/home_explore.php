<?php
require_once '../config/session.php';
include_once 'partials/create_post.php';
include_once 'partials/post_modal.php';

if (!isset($_SESSION['user_id']) || 
    !isset($_SESSION['user_email']) ||
    !isset($_GET['page'])) {
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

    html,
    body {
        width: 100%;
    }

    .wrapper {
        width: 100%;
        display: flex;
    }

    .center {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden auto;
    }

    .center>main {
        flex: 1;
    }

    .modal {
        width: 80%;
        height: 70%;
        display: flex;
        z-index: 100;
        overflow: hidden auto;
    }

    .show_modal {
        display: flex !important;
    }

    .img_grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(150px, 1fr));
        gap: 1rem;
        padding: 1rem;
    }

    .img_grid>div {
        max-width: 1200px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: solid 1px black;
        aspect-ratio: 1 / 1;
    }

    .img_cont>img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<!-- Note: 'data-page' determine which page to render (home / explore) -->
<body id="page_type" class="wrapper" data-page="<?php echo htmlspecialchars($_GET['page']); ?>">
    <?php include_once '../component/sidenav.php' ?>

    <section class=center>
        <?php include_once '../component/header.php' ?>

        <main>
            <div id="result-box"></div>
            <!-- Note: 'data-content' determine which post content to fetch (home / explore / profile) -->
            <div class="img_grid" data-content="<?php echo  htmlspecialchars($_GET['page']); ?>"></div>

            <div class="loading">Loading more images...</div>
        </main>
    </section>

    <script type="module" src="../assets/js/event/fetch_post.js"></script>
</body>

</html>