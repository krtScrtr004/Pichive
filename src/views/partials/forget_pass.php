<link rel="stylesheet" href="../assets/style/generic.css">
<link rel="stylesheet" href="../assets/style/utils.css">
<link rel="stylesheet" href="../assets/style/modal.css">
<link rel="stylesheet" href="../assets/style/forget_pass.css">
<link rel="stylesheet" href="../assets/style/index.css">

<section id="result"></section>

<section id="forget_password_modal" class="modal-wrapper">
    <section id="forget_password" class="modal flex-column">
        <div>
            <span class="close-btn">&times;</span>
        </div>

        <div class="form-container">
            <h1 class="heading-title">FORGET PASSWORD</h1>
            <p>Enter your email and we'll send you an OTP to reset your password.</p>

            <form id="forget_password_form" class="form-container" action="" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" autocomplete="on" require>
                <button id="send_otp_btn" class="button" type="submit">Send OTP</button>
            </form>
        </div>
    </section>
</section>

<section id="otp_modal" class="modal-wrapper">
    <section id="otp" class="modal flex-column">
        <div>
            <span class="close-btn">&times;</span>
        </div>

        <div class="form-container">
            <h1 class="heading-title">ONE TIME PASSWORD</h1>
            <p>We've sent a 6-digit OTP in your email. Kindly check your inbox.</p>

            <form id="otp_form" class="wrapper" action="" method="POST">
                <label for="otp_code">6-digit OTP</label>
                <input type="number" name="otp_code" id="otp_code" require>
                <button id="reset_password_btn" class="button" type="submit">RESET PASSWORD</button>
            </form>
        </div>
    </section>
</section>

<section id="change_password_modal" class="modal-wrapper">
    <section id="change_password" class="modal">
        <form id="change_password_form" action="" method="POST">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password" require>
            <label for="c_password">Confirm Password</label>
            <input type="password" name="c_password" id="c_password" require>
            <button id="change_password_btn" type="submit">CHANGE PASSWORD</button>
        </form>
    </section>

    <span>Didn't get otp? <a href="#" id="resend_otp"> Resend OTP</a>
    </span>
</section>

<script type="module" src="../../assets/js/event/forget_pass.js"></script>