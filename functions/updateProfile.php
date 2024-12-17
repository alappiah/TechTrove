<?php
session_start();
include("../db/database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Ensure POST keys exist and sanitize input
        $firstName = isset($_POST['fName']) ? $conn->real_escape_string($_POST['fName']) : '';
        $lastName = isset($_POST['lName']) ? $conn->real_escape_string($_POST['lName']) : '';
        $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';

        // Validate input
        if ($firstName === '' || $lastName === '' || $email === '') {
            echo "<script>alert('All fields are required.'); window.history.back();</script>";
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.'); window.history.back();</script>";
            exit();
        }

        // Check for email uniqueness
        $stmt = $conn->prepare("SELECT COUNT(*) FROM final_project_users WHERE email = ? AND user_id != ?");
        $stmt->bind_param("si", $email, $userId);
        $stmt->execute();
        $stmt->bind_result($emailCount);
        $stmt->fetch();
        $stmt->close();

        if ($emailCount > 0) {
            echo "<script>alert('The email address is already in use.'); window.history.back();</script>";
            exit();
        }

        // Update user profile
        $stmt = $conn->prepare("UPDATE final_project_users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $firstName, $lastName, $email, $userId);

        if ($stmt->execute()) {
            echo "<script>alert('Profile Update Successfully!'); window.history.back();</script>";
        } else {
            die("Error updating profile: " . $stmt->error);
        }

        $stmt->close();
    } else {
        die("User is not logged in.");
    }

    
}

$conn->close();
?>
