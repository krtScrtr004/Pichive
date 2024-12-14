<?php include 'partials/forget_pass.php' ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="../assets/style/generic.css">
    <link rel="stylesheet" href="../assets/style/utils.css">
    <link rel="stylesheet" href="../assets/style/index.css">
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
        <section class="banner flex-row">
            <div class="banner-text flex-column">
                <div class="banner-text-header flex-column">
                    <img src="../assets/img/logo.png" alt="Pichive Logo" title="Pichive Logo" width="400" height="150">
                    <h1>CAPTURE, COLLECT, CONNECT</h1>
                </div>

                <p>PicHive is a vibrant platform designed for creators and enthusiasts to capture, collect, and connect through visual content. Whether you're sharing your latest artistic inspiration or exploring the creations of others, PicHive offers an easy-to-use space for everyone to showcase their images, discover new ideas, and engage with a community of like-minded individuals. Join us and start building your collection today.</p>

                <div class="focus-button button-wrapper">
                    <a class="button" href="#login">LOG IN</a>
                    <a class="button" href="#signup">SIGN UP</a>
                </div>
            </div>

            <div class="banner-logo flex-row">
                <img src="../assets/img/icon.png" alt="Pichive Icon" title="Pichive Icon" width="812" height="1128">
            </div>
        </section>

        <!-- Login Section -->
        <section id="login" class="flex-row">
            <div class="form-container flex-column">
                <h1>LOG IN</h1>
                <p>Hey! Enter your details to login your account</p>
                
                <form id="login_form" action="" method="POST">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="on" required>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" min="8" max="128" required>

                    <button id="login_btn" class="form-button button" type="submit">LOG IN</button>
                </form>

                <div class="redirect-text flex-column">
                    <a href="">Forget Password?</a>
                    <a href="#signup">Create an Account?</a>
                </div>
            </div>
        </section>

        <!-- Signup Section -->
        <section id="signup" class="flex-column">
            <div class="form-container flex-column">
                <h1>SIGN UP</h1>
                <p>Fill out the form to create an account.<br>It's quick and easy!</p>

                <form id="signup_form" action="" method="POST">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" min="3" max="15" autocomplete="on" required>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="on" required>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" min="8" max="128" required>
                    <label for="c_password">Confirm Password</label>
                    <input type="password" name="c_password" id="c_password" min="8" max="128" required>
                    <button id="signup_btn" class="form-button button"  type="submit">SUBMIT</button>
                </form>

                <div class="redirect-text flex-column">
                    <a href="#login">Already have an Account?</a>
                </div>
            </div>
        </section>
    </main>

    <script type="module" src="../assets/js/event/login.js"></script>
    <script type="module" src="../assets/js/event/signup.js"></script>
</body>

</html>