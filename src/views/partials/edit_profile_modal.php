<?php
require_once '../config/session.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<link rel="stylesheet" href="../assets/style/generic.css">
<link rel="stylesheet" href="../assets/style/modal.css">
<link rel="stylesheet" href="../assets/style/utils.css">
<link rel="stylesheet" href="../assets/style/edit_profile.css">

<section class="modal-wrapper" id="edit_profile_modal">
    <span class="result"></span>

    <section class="modal edit-profile light-background dark-text">
        <!-- Right halve side -->
        <div class="left-halve flex-column">
            <h3 class="heading-title">EDIT PROFILE INFORMATION</h3>

            <div class="flex-row">
                <img class="img-preview circle" src="../assets/img/default_img_prev.png" alt="Profile image" width="100" height="100">
                <div class="img-button-wrapper">
                    <!-- Hidden file picker -->
                    <input type="file" name="img_picker" id="img_picker" accept="image/*">

                    <!-- Button that would simulate the file picking through events -->
                    <div class="flex-column">
                        <button id="img_picker_btn" class="button dark-background light-text" type="button">Choose Image</button>

                        <p class="img-reminder">Select only image files (jpg, jpeg, png)</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Left halve side -->
        <div class="right-halve flex-column">
            <form id="edit_profile_form" class="flex-column" action="" method="POST">
                <!-- Username -->
                <div class="input-wrapper flex-column">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" min="8" max="128" autocomplete="on">
                </div>

                <!-- Email -->
                <div class="flex-column">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $_SESSION['user_email'] ?>" disabled>
                </div>

                <!-- Password -->
                <div class="flex-column">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" placeholder="Password" min="8" max="128">
                </div>

                <!-- Bio -->
                <div class="flex-column">
                    <label for="bio">Bio</label>
                    <textarea class="bio" name="bio" id="bio" cols="30" rows="10" maxlength="512" placeholder="Short bio about yourself"></textarea>
                </div>

                <!-- Buttons -->
                <div class="button-wrapper flex-row">
                    <button id="cancel_btn" class="button" type="button">CANCEL</button>
                    <button id="save_btn" class="button" type="submit">SAVE</button>
                </div>
            </form>
        </div>
    </section>
</section>