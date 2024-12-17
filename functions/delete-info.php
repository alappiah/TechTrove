<?php
session_start();
include("../db/database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Confirm account deletion
        $stmt = $conn->prepare("DELETE FROM final_project_users WHERE user_id = ?");
        $stmt->bind_param('i', $userId);

        if ($stmt->execute()) {
            session_destroy();
            echo "<script>alert('Account deleted successfully. Goodbye!!!'); window.location.href = '../index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to delete account. Please try again later.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('You are not logged in. Please log in and try again.'); window.location.href = '../index.php';</script>";
        exit();
    }
}

$conn->close();
?>