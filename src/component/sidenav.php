<?php
require_once '../config/session.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<link rel="stylesheet" href="../assets/style/generic.css">
<link rel="stylesheet" href="../assets/style/utils.css">
<link rel="stylesheet" href="../assets/style/nav.css">

<aside data-content="main">
    <section class="logo">
        <a href="../views/home_explore.php?page=home">
            <img src="../assets/img/logo/logo_light.svg" alt="Pichive logo" width="400" height="150">
        </a>
    </section>

    <section class="upper-halve">
        <ul class="list-wrapper list">
            <!-- Home Page -->
            <li class="link-wrapper list">
                <a class="nav-link list" href="../views/home_explore.php?page=home">
                    <img src="../assets/img/icons/Light/Home.svg" alt="" width="32" height="32">
                    <h3>Home</h3>
                </a>
            </li>
            <!-- Explore Page -->
            <li class="link-wrapper list">
                <a class="nav-link list" href="../views/home_explore.php?page=explore">
                    <img src="../assets/img/icons/Light/Explore.svg" alt="" width="32" height="32">
                    <h3>Explore</h3>
                </a>
            </li>
            <!-- Followed Users Page -->
            <li class="link-wrapper list">
                <a class="nav-link list" href="#">
                    <img src="../assets/img/icons/Light/User.svg" alt="" width="32" height="32">
                    <h3>Followed User</h3>
                </a>
            </li>
            <!-- Chat Page -->
            <li class="link-wrapper list">
                <a class="nav-link list" href="#">
                    <img src="../assets/img/icons/Light/Chat.svg" alt="" width="32" height="32">
                    <h3>Chat</h3>
                </a>
            </li>
            <!-- Profile Page -->
            <li class="link-wrapper list">
                <a class="nav-link list" href="../views/profile.php?page=profile&id=<?php echo urlencode($_SESSION['user_id']); ?>">
                    <img src="../assets/img/icons/Light/Profile.svg" alt="" width="32" height="32">
                    <h3>Profile</h3>
                </a>
            </li>
        </ul>
    </section>

    <hr class="halve-divider light-text">

    <section class="lower-halve">
        <h4 class="halve-title">Followed Users</h4>
        <span class="sidenav-result"></span>

        <ul id="followed_user_list" class="user-list list-wrapper list">
            <!-- Followed User List -->
        </ul>
    </section>
</aside>