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
            <div class="result-box"></div>

            <section class="main-partition">
                <div class="profile-details" data-id="<?php echo htmlspecialchars($_GET['id']); ?>">
                    <img id="profile_img" class="circle" src="../assets/img/icons/Dark/Profile.svg" alt="Profile Image" width="250" height="250">

                    <section class="profile-texts">
                        <div class="user-info">
                            <h4 id="username" class="username"></h4>
                            <h6 id="user_id" class="user-id"></h6>
                        </div>

                        <div class="buttons">
                            <button id="edit_profile_btn" type="submit">Edit Profile</button>
                            <button id="upload-img-btn" type="submit">Upload</button>
                        </div>
                        <p id="user_bio" class="bio"></p>
                    </section>
                </div>

                <div class="img-grid" data-content="<?php echo  htmlspecialchars($_GET['page']); ?>"  data-id="<?php echo htmlspecialchars($_GET['id']); ?>"></div>
            </section>

            <div class="loading">Loading more images...</div>
        </main>
    </section>

    <script type="module" src="../assets/js/event/fetch_user.js"></script>
    <script type="module" src="../assets/js/event/fetch_post.js"></script>
    <script type="module" src="../assets/js/event/edit_profile.js"></script>
</body>

</html>