<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <header class="header">
        <a href="#" class="logo"><img src="assets/images/logo.png" alt="Tech Trove logo"  width="110px" height="auto"></a>
        
    </header>

    <section class="main">
        <div class="content">
            <h2>Discover, Compare, Decide with Confidence.</h2>
            <p> Simplifying tech shopping with comprehensive gadget comparisons, user reviews, price tracking, and a community forum—empowering users to make informed, confident purchasing decisions.</p>
            <a href="view/register.php">Get Started</a>
        </div>
        
        <div class="login-container">
            <h2>Login</h2>
            <form action="actions/login_user.php" onsubmit="return validateForm()" method="POST">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <label for="email">Enter your email</label>
                    <input type="email" id="email" name="email">
                    <span id="email-error" class="error-message-email"></span>
                    
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <label for="password">Enter your password</label>
                    <input type="password" id="password" name="password">
                    <span id="password-error" class="error-message-password"></span>

                </div>
                <div class="remember-forgot">
                    <label for="checkbox"><input type="checkbox" id="checkbox">Remember Me</label>
                    <a href="view/forgot_password.php">Forget Your Password?</a>
                </div>
                <button type="submit" class="login-button" name="login">Login</button>
                <div class="register-link">
                    <p>Not a member? <a href="view/register.php">Sign up now!</a></p>
                </div>
            </form>
        </div>
    </section>


    <script src="assets/js/index.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>