<?php
include '../config/session.php';
// if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
//     header('Location:');    // TODO: Add redirect here
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
</head>

<style>
    form>* {
        display: block;
    }
</style>

<body>
    <main>
        <h1 id="result"></h1>

        <!-- Banner Section -->
        <section></section>

        <!-- Login Section -->
         <section id="login">
            <form id="login_form" action="" method="POST">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="on" required>
                <label for="password">Password</label>
                <input type="text" name="password" id="password" required>
                <button id="login_btn" type="submit">LOG IN</button>
            </form>
         </section>

         <!-- Signup Section -->
          <section id="signup">
            <form id="signup_form" action="" method="POST">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="on" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" autocomplete="on" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <label for="c_password">Confirm Password</label>
                <input type="password" name="c_password" id="c_password" required>
                <button id="signup_btn" type="submit">SUBMIT</button>
            </form>
          </section>
    </main>

    <script type="module" src="../assets/js/login.js"></script>
    <script type="module" src="../assets/js/signup.js"></script>
    
</body>
</html>