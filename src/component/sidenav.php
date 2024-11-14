<?php 
require_once '../config/session.php';
include_once 'partials/create_post.php';
include_once 'partials/post_modal.php';

if (!isset($_SESSION['user_id']) || 
    !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    a {
        text-decoration: none;
    }

    .side-nav {
        width: 20%;
        background-color: black;
        color: white;
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        padding: 1.5em;
        overflow: auto;
    }

    .halve-divider {
        width: 100%;
        color: white;
    }

    .upper-halve {
        height: fit-content;
        margin-bottom: 1rem;
    }

    .lower-halve {
        flex: 1;
        overflow: auto hidden;
    }

    .halve-title {
        padding: 1rem 0;
    }

    .list-wrapper,
    .link-wrapper,
    .nav-link {
        display: flex;
        align-items: center;
        color: white;
    }

    .list-wrapper {
        flex-direction: column;
        align-items: start;
        gap: 1.5rem;
    }

    .nav-link>img {
        height: 2rem;
        margin-right: 1em;
    }

    .circle {
        width: 100%;
        height: auto;
        border-radius: 100%;
        aspect-ratio: 1/1;
    }
</style>

<aside class="side-nav" data-content="main">
    <section class="upper-halve">
        <ul class="list-wrapper">
            <!-- Home Page -->
            <li class="link-wrapper">
                <a class="nav-link" href="../views/home_explore.php?page=home">
                    <img src="../assets/img/icons/Light/Home.svg" alt="" width="32" height="32">
                    <h3>Home</h3>
                </a>
            </li>
            <!-- Explore Page -->
            <li class="link-wrapper">
                <a class="nav-link" href="../views/home_explore.php?page=explore">
                    <img src="../assets/img/icons/Light/Explore.svg" alt="" width="32" height="32">
                    <h3>Explore</h3>
                </a>
            </li>
            <!-- Followed Users Page -->
            <li class="link-wrapper">
                <a class="nav-link" href="#">
                    <img src="../assets/img/icons/Light/User.svg" alt="" width="32" height="32">
                    <h3>Followed User</h3>
                </a>
            </li>
            <!-- Chat Page -->
            <li class="link-wrapper">
                <a class="nav-link" href="#">
                    <img src="../assets/img/icons/Light/Chat.svg" alt="" width="32" height="32">
                    <h3>Chat</h3>
                </a>
            </li>
            <!-- Profile Page -->
            <li class="link-wrapper">
                <a class="nav-link" href="../views/profile.php?page=profile&id=<?php echo urlencode($_SESSION['user_id']); ?>">
                    <img src="../assets/img/icons/Light/Profile.svg" alt="" width="32" height="32">
                    <h3>Profile</h3>
                </a>
            </li>
        </ul>
    </section>

    <hr class="halve-divider">

    <section class="lower-halve">
        <h4 class="halve-title">Followed Users</h4>
        <ul>
            <li class="link-wrapper">
                <a class="nav-link" href="#">
                    <img class="circle" src="../assets/img/icons/Light/Profile.svg" alt="" width="32" height="32">
                    <h3>Username</h3>
                </a>
            </li>
    </section>
</aside>