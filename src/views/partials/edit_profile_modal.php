<?php 
require_once '../config/session.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<style>
    .modal {
        background-color: var(--default-black);
    }
</style>

<link rel="stylesheet" href="../assets/style/modal.css">

<div class="modal-wrapper" id="edit_profile_modal">
    <span class="result"></span>
    <section class="modal">
        tretrewtwer
    </section>
</div>

<script type="module" src="../assets/js/event/edit_profile.js"></script>
