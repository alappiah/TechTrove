<?php
session_start();
include("../db/database.php");

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Retrieve the logged-in user's ID from the session
        $userId = $_SESSION['user_id'];

        // Sanitize input data
        $feedback = $conn->real_escape_string($_POST['feedback-text']);

        // Use PHP's date() function to get the current timestamp
        $createdAt = date('Y-m-d H:i:s');

        // Insert query with prepared statements
        $stmt = $conn->prepare("INSERT INTO final_project_feedback (user_id, feedback_text, created_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $feedback, $createdAt);

        if ($stmt->execute()) {
            echo "<script>
                alert('Thank you for your feedback!');
                window.location.href = '../view/settings.php'; 
                </script>";
        } else {
            echo  "<script>
                    alert('Error saving feedback: " . $stmt->error . "');
                    window.location.href = '../view/settings.php';
                    </script>";
        }

        $stmt->close();
    } else {
        echo "User is not logged in.";
    }
}

// Close connection
$conn->close();
?>