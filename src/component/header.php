<link rel="stylesheet" href="../assets/style/generic.css">
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
        <button id="create_post_btn" popovertarget="create_post_modal">CREATE POST</button>

        <span class="profile-icon-menu flex-row">
            <img class="circle" src="../assets/img/default_img_prev.png" alt="Profile Icon Menu" title="Profile Icon Menu" width="36" height="36">
        </span>

    </div>
</header>