<link rel="stylesheet" href="../assets/style/generic.css">
<link rel="stylesheet" href="../assets/style/utils.css">
<link rel="stylesheet" href="../assets/style/header.css">

<header class="header flex-row">
    <div class="search-area flex-row">
        <form id="search_form" class="flex-row" action="" method="POST">
            <input class="dark-text" type="text" name="search_input" id="search_input" min="1" max="300" placeholder="Search" required>

            <button type="submit" id="search_btn">
                <img src="../assets/img/icons/Dark/Search.svg" alt="Search Button" title="Search Button" width="24" height="24">
            </button>
        </form>
    </div>

    <div class="right-sub-menu flex-row">
        <button id="create_post_btn" class="button">CREATE POST</button>

        <span class="profile-icon-menu flex-row">
            <img class="circle" src="../assets/img/default_img_prev.png" alt="Profile Icon Menu" title="Profile Icon Menu" width="36" height="36">

            <!-- Drop Down Sub Menu -->
            <div class="drop-down">
                <ul class="flex-column">
                    <li>
                        <a class="link-wrapper list" href="">
                            <img src="../assets/img/icons/Light/DarkMode.svg" alt="Dark Mode Icon" width="24" height="24">
                            <h3>Dark Mode</h3>
                        </a>
                    </li>
                    <li>
                        <a class="link-wrapper list" href="">
                            <img src="../assets/img/icons/Light/AboutUs.svg" alt="About Us Icon" width="24" height="24">
                            <h3>About Us</h3>
                        </a>
                    </li>
                    <li>
                        <a class="link-wrapper list" href="">
                            <img src="../assets/img/icons/Light/Block.svg" alt="Report Icon" width="24" height="24">
                            <h3>Report Bug</h3>
                        </a>
                    </li>

                    <hr class="halve-divider light-text">

                    <li id="logout" class="logout">
                        <a class="link-wrapper list" href="">
                            <img src="../assets/img/icons/Light/Logout.svg" alt="Logout Icon" width="24" height="24">
                            <h3>Logout</h3>
                        </a>
                    </li>
                </ul>
            </div>
        </span>
    </div>
</header>