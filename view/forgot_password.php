<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        <?php include '../assets/css/password_reset.css'; ?>
    </style>
</head>
<body>
	<div class="row">
		<h1>Forgot Password</h1>
		<h6 class="information-text">Enter your registered email to reset your password.</h6>
		<form action="../actions/password_reset.php" method="POST">
            <div class="form-group">
                <input type="email" name="email" id="user_email" required>
                <label for="user_email">Email</label>
                <button type="submit" onclick="showSpinner()">Reset Password</button>
            </div>
        </form>
		<div class="footer">
			<h5>New here? <a href="register.php">Sign Up.</a></h5>
			<h5>Already have an account? <a href="../index.php">Sign In.</a></h5>
			<p class="information-text"></a></p>
		</div>
	</div>
</body>