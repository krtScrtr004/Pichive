<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
</head>
<body>
    <div id="result"></div>

    <section id="forget_password">
        <form id="forget_password_form" action="" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" autocomplete="on" require>
            <button id="send_otp_btn" type="submit">Send OTP</button>
        </form>
    </section>

    <!-- TODO: Create a js script for this  -->
    <section id="otp">
        <form id="otp_form" action="" method="POST">
            <label for="otp_code">OTP</label>
            <input type="number" name="otp_code" id="otp_code" require>
            <button id="reset_password_btn" type="submit">RESET PASSWORD</button>
        </form>
    </section>

    <section id="change_password">
        <form id="change_password_form" action="" method="POST">
            <label for="new_password">New Password</label>
            <input type="passwordword" name="new_password" id="new_password" require>
            <label for="c_password">Confirm Password</label>
            <input type="passwordword" name="c_password" id="c_password" require>
            <button id="change_password_btn" type="submit">CHANGE PASSWORD</button>
        </form>
    </section>

    <script type="module" src="../../assets/js/event/forget_pass.js"></script>
</body>
</html>