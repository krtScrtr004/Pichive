<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
</head>
<body>

    <main>
        <!-- Banner Section -->
        <section></section>

        <!-- Login Section -->
         <section></section>

         <!-- Signup Section -->
          <section id="signup">
            <form id="signup_form" action="" method="POST>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="on" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" autocomplete="on" required>
                <label for="password">Password</label>
                <input type="text" name="password" id="password" required>
                <label for="c_password">Confirm Password</label>
                <input type="text" name="c_password" id="c_password" required>
                <button id="signup_btn" type="submit">SUBMIT</button>
            </form>

            <span id="result"></span>
          </section>
    </main>

    <script type="module" src="../assets/js/signup.js"></script>
    
</body>
</html>