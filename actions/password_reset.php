<?php
require '../db/database.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure email field is provided
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = trim($_POST['email']);

        // Check if the email exists in the database
        $query = "SELECT user_id FROM final_project_users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email exists, generate a token
            $user = $result->fetch_assoc();
            $user_id = $user['user_id'];
            $token = bin2hex(random_bytes(16)); // Generate a secure random token
            $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes')); // Token valid for 10 minutes

            // Save the token and its expiry in the database
            $insertTokenQuery = "INSERT INTO final_project_password_reset_tokens (user_id, token, expires_at) 
                                 VALUES (?, ?, ?) 
                                 ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)";
            $insertStmt = $conn->prepare($insertTokenQuery);
            $insertStmt->bind_param("iss", $user_id, $token, $expires_at);

            if ($insertStmt->execute()) {
                // Send the token via email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'saversavvy400@gmail.com'; // Your email
                    $mail->Password = 'rnpbldhmiaqtcfvn'; // Your email password (use environment variables in production)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('saversavvy400@gmail.com', 'SavvySaver');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Token';
                    $mail->Body = "<p>Here is your password reset token:</p>
                                   <h3>$token</h3>
                                   <p>The token is valid for 10 minutes. Please use it to reset your password.</p>";
                    $mail->AltBody = "Here is your password reset token: $token. The token is valid for 10 minutes.";

                    $mail->send();
                    echo "<script>
                            alert('A password reset token has been sent to your email.');
                            window.location.href = '../view/token_password.php';
                          </script>";
                } catch (Exception $e) {
                    echo "<script>
                            alert('Error sending email: " . addslashes($mail->ErrorInfo) . "');
                          </script>";
                }
            } else {
                echo "<script>
                        alert('Error saving token. Please try again later.');
                      </script>";
            }
            $insertStmt->close();
        } else {
            // Email not found
            echo "<script>
                    alert('The provided email does not exist.');
                  </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                alert('Please enter your email.');
              </script>";
    }
}

$conn->close();
?>
