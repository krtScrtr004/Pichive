<?php
require_once '../config/session.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<link rel="stylesheet" href="../assets/style/modal.css">
<link rel="stylesheet" href="../assets/style/utils.css">
<link rel="stylesheet" href="../assets/style/edit_profile.css">

<div class="modal-wrapper" id="edit_profile_modal">
    <span class="result"></span>
    <section class="modal edit-profile light-background dark-text">
        <!-- Right halve side -->
        <div class="left-halve flex-column">
            <h3>EDIT PROFILE INFORMATION</h3>
            <div class="flex-row">
                <img class="img-preview circle" src="../../assets/img/default_img_prev.png" alt="Profile image">
                <div class="img-button-wrapper">
                    <div class="file-input dark-background light-text">
                        <label for="file">Choose a file</label>
                        <input type="file" id="file" />
                    </div>
                </div>
            </div>

        </div>

        <!-- Left halve side -->
        <div class="left-halve"></div>
    </section>
</div>

<script type="module" src="../assets/js/event/edit_profile.js"></script>