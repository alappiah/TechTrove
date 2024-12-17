<?php
require '../db/database.php';

// Check if the token is passed in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check token validity
    $query = "SELECT user_id FROM team_project_password_reset_tokens 
              WHERE token = ? AND expires_at > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, process the password reset
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
            $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

            // Validate new password
            if ($newPassword !== $confirmPassword) {
                echo "<script>alert('Passwords do not match.');</script>";
            } elseif (strlen($newPassword) < 8) {
                echo "<script>alert('Password must be at least 8 characters long.');</script>";
            } else {
                // Hash the password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $updateQuery = "UPDATE team_project_users SET password = ? WHERE user_id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $hashedPassword, $user_id);

                if ($updateStmt->execute()) {
                    // Password reset successful
                    echo "<script>alert('Password has been reset. You can now log in.'); window.location.href = '../view/login.php';</script>";
                } else {
                    echo "<script>alert('Error updating password. Please try again later.');</script>";
                }
                $updateStmt->close();
            }
        }
    } else {
        echo "<script>alert('Invalid or expired token. Please try again.'); window.location.href = 'token_password.php';</script>";
    }
    $stmt->close();
} else {
    // Token is missing
    echo "<script>alert('No token provided.'); window.location.href = 'token_password.php';</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        <?php include '../assets/css/password_reset.css'; ?>
    </style>
</head>
<body>
    <div class="row">
        <h1>Reset Password</h1>
        <form action="" method="POST">
            <div class="form-group">
                <input type="password" name="new_password" id="new_password" required minlength="8">
                <p><label for="new_password">New Password</label></p>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" id="confirm_password" required minlength="8">
                <p><label for="confirm_password">Confirm Password</label></p>
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
