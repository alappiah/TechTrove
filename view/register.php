<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body>
    <header class="header">
        <a href="#" class="logo"><img src="../assets/images/logo.png" alt="Tech Trove logo"  width="110px" height="auto"></a>
    </header>

    <section class="main">
        <div class="register-container">
            <h2>Register</h2>
            <form action="../actions/register_user.php" onsubmit="return validateForm()" method="POST">
                <div class="name-container">
                    <div class="input-box">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first_name" required>
                    </div>
                    <div class="input-box">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last_name" required>
                    </div>
                </div>

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
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <label for="password">Confirm your password</label>
                    <input type="password" id="confirm-password" name="confirm-password">
                    <span id="confirm-password-error" class="error-message-password"></span>

                </div>
                <button type="submit" class="register-button"  name="register">register</button>
                <div class="register-link">
                    <p>Already a member? <a href="../index.php">Login now!</a></p>
                </div>
            </form>
        </div>
    </section>



    <script src="../assets/js/register.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
