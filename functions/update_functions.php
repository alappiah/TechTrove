<?php
session_start();
include("database.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Decode JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        // Get email notification preference
        $emailNotifications = isset($input['emailNotifications']) ? (int)$input['emailNotifications'] : 0;

        // Update the preference in the database
        $stmt = $conn->prepare("UPDATE users SET email_notifications = ? WHERE user_id = ?");
        $stmt->bind_param("ii", $emailNotifications, $userId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();
?>
