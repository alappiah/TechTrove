<?php
require '../db/database.php'; // Include the database connection
session_start(); // Start the session


// Check if the user is logged in and user_id exists in the session
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('User not logged in.');
            window.location.href = '../view/login.php'; // Redirect to login page
          </script>";;
    exit;
}

// Retrieve the logged-in user's user_id
$userId = $_SESSION['user_id'];

// Get the checkbox value (if checked = 1, if unchecked = 0)
$emailNotifications = isset($_POST['emailNotifications']) ? 1 : 0;

// Update the notification preference in the database
$query = "UPDATE team_project_users SET email_notifications = ? WHERE user_id = ?";
$stmt = $conn->prepare($query);

// Check if the statement is successfully prepared
if (!$stmt) {
    echo "<script>alert('Error preparing the query: " . $conn->error . "');</script>";
    exit;
}

$stmt->bind_param("ii", $emailNotifications, $userId);

if ($stmt->execute()) {
    echo "<script>
            alert('Notification preference updated successfully.');
            window.location.href = '../view/settings.php'; // Redirect to settings.php
          </script>";
} else {
    echo "<script>alert('Failed to update notification preference: " . $stmt->error . "');</script>";
}

$stmt->close();
$conn->close();
?>
