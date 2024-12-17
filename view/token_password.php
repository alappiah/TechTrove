<?php
require '../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['token']) && !empty($_POST['token'])) {
        $token = trim($_POST['token']);

        // Validate the token in the database
        $query = "SELECT user_id FROM team_project_password_reset_tokens 
                  WHERE token = ? AND expires_at > NOW()";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Token is valid, allow user to reset their password
            $user = $result->fetch_assoc();
            $user_id = $user['user_id'];

            // Display password reset form
            echo "<script>
                    alert('Token verified! Redirecting to password reset page...');
                    window.location.href = 'reset_password.php?token=" . urlencode($token) . "';
                  </script>";
        } else {
            // Token is invalid or expired
            echo "<script>alert('Invalid or expired token. Please try again.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter the token.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Token</title>
    <style>
        <?php include '../assets/css/password_reset.css'; ?>
    </style>
</head>
<body>
    <div class="row">
        <h1>Enter Token</h1>
        <h6 class="information-text">Enter the token sent to your email to reset your password.</h6>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="token" id="token" required>
                <p><label for="token">Token</label></p>
                <button type="submit">Submit</button>
            </div>
        </form>
        <div class="footer">
            <h5>New here? <a href="register.php">Sign Up.</a></h5>
            <h5>Already have an account? <a href="../index.php">Sign In.</a></h5>
        </div>
    </div>
</body>
</html>
