<?php
require_once '../config/session.php';
include_once 'partials/create_post.php';
include_once 'partials/post_modal.php';
include_once 'partials/edit_profile_modal.php';

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_email']) ||
    !isset($_GET['page']) ||
    !isset($_GET['id'])
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
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/style/generic.css">
    <link rel="stylesheet" href="../assets/style/utils.css">
    <link rel="stylesheet" href="../assets/style/img_grid.css">
    <link rel="stylesheet" href="../assets/style/modal.css">
    <link rel="stylesheet" href="../assets/style/profile.css">
</head>

<body class="wrapper flex-row" data-id="<?php echo htmlspecialchars($_GET['id']); ?>">
    <?php include_once '../component/sidenav.php' ?>
    <section class=center>
        <?php include_once '../component/header.php' ?>

        <main>
            <span class="result-box"></span>

            <section class="main-partition">
                <div class="profile-details flex-row" data-id="<?php echo htmlspecialchars($_GET['id']); ?>">
                    <img id="profile_img" class="circle" src="../assets/img/icons/Dark/Profile.svg" alt="Profile Image" width="250" height="250">

                    <section class="profile-texts flex-column">
                        <div class="user-info">
                            <h4 id="username" class="username"></h4>
                            <h6 id="user_id" class="user-id"></h6>
                        </div>

                        <div class="button-wrapper">
                            <?php if ($_GET['id'] === $_SESSION['user_id']): ?>
                                <button id="edit_profile_btn" class="button" type="submit">Edit Profile</button>
                                <button id="create_post_btn" class="button" type="submit">Upload</button>
                            <?php else: ?>
                                <button id="follow_user_btn" class="button" type="submit">Follow</button>
                                <button id="block_user_btn" class="button" type="submit">Block</button>
                            <?php endif; ?>
                        </div>
                        
                        <p id="user_bio" class="bio"></p>
                    </section>
                </div>

                <section class="profile-posts flex-column">
                    <?php if ($_GET['id'] === $_SESSION['user_id']): ?>
                        <div class="post-tabs flex-row">
                            <form class="flex-row" action="" method="POST">
                                <button id="own_post_tab" class="dark-text flex-row" type="button"><img src="../assets/img/icons/Dark/Image.svg" alt="Image Icon" title="Image Icon" width="24" height="24">Posts</button>
                                <button id="liked_post_tab" class="dark-text flex-row" type="button"><img src="../assets/img/icons/Dark/Like.svg" alt="Like Icon" title="Like Icon" width="24" height="24">Liked</button>
                            </form>
                        </div>
                    <?php endif; ?>

                </section>

            </section>

            <div class="loading">Loading more images...</div>
        </main>
    </section>

    <script type="module" src="../assets/js/event/profile_icon_menu.js"></script>
    <script type="module" src="../assets/js/event/drop_down.js"></script>
    <script type="module" src="../assets/js/event/create_post.js"></script>
    <script type="module" src="../assets/js/event/fetch_sidenav_user.js"></script>
    <script type="module" src="../assets/js/event/fetch_user.js"></script>
    <script type="module" src="../assets/js/event/edit_profile.js"></script>
    <script type="module" src="../assets/js/event/fetch_post.js"></script>
    <script type="module" src="../assets/js/event/search.js"></script>
    <script type="module" src="../assets/js/event/profile_post_tab.js"></script>
    <script type="module" src="../assets/js/event/comment.js"></script>
    <script type="module" src="../assets/js/event/follow_block.js"></script>

</body>

</html>