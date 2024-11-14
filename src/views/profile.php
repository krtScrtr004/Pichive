<?php
require_once '../config/session.php';
include_once 'partials/create_post.php';
include_once 'partials/post_modal.php';

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

    .main-partition {
        display: flex;
        flex-direction: column;
    }

    .profile-details {
        background-color: white;;
        display: flex;
    }

    .profile-details>img {
        width: fit-content;
        height: clamp(5rem, 13rem, 15rem);
        margin-right: 2rem;
    }

    .profile-texts {
        flex: 1;
    }

    .profile-texts > * {
        display: block;
    }

    .user-info>* {
        display: inline-block;
    }

    .username {
        font-size: 2rem;
    }

    .user-id {
        font-size: 1.5rem;
        font-weight: 300;;
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
        flex: 1;
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

    .circle {
        border-radius: 100%;
        aspect-ratio: 1/1;    
    }
</style>

<body class="wrapper" data-id="<?php echo htmlspecialchars($_GET['id']); ?>">
    <?php include_once '../component/sidenav.php' ?>
    <section class=center>
        <?php include_once '../component/header.php' ?>

        <main>
            <div class="result-box"></div>

            <section class="main-partition">
                <div class="profile-details" data-id="<?php echo htmlspecialchars($_GET['id']); ?>">
                    <img id="profile_img" class="circle" src="../assets/img/icons/Dark/Profile.svg" alt="Profile Image" width="250" height="250">

                    <section class="profile-texts">
                        <span class="user-info">
                            <h4 id="username" class="username"></h4>
                            <h6 id="user_id" class="user-id"></h6>
                        </span>
                        // TODO: 
                        <span class="buttons">
                            <button id="edit-profile-btn" type="submit">Edit Profile</button>
                            <button id="upload-img-btn" type="submit">Upload</button>
                        </span>
                        <p id="user_bio" class="bio"></p>
                    </section>
                </div>

                <div class="img_grid" data-content="<?php echo  htmlspecialchars($_GET['page']); ?>"  data-id="<?php echo htmlspecialchars($_GET['id']); ?>"></div>
            </section>

            <div class="loading">Loading more images...</div>
        </main>
    </section>

    <script type="module" src="../assets/js/event/fetch_user.js"></script>
    <script type="module" src="../assets/js/event/fetch_post.js"></script>
</body>

</html>