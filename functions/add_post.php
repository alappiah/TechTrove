<?php
header('Content-Type: application/json');  // Set JSON content type
session_start();
include("../db/database.php");

$response = ['success' => false, 'message' => ''];

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Retrieve the logged-in user's ID from the session
        $userId = $_SESSION['user_id'];

        // Sanitize input data
        $title = $conn->real_escape_string($_POST['title']);
        $category = $conn->real_escape_string($_POST['category']);
        $excerpt = $conn->real_escape_string($_POST['excerpt']);
        $imageUrl = $conn->real_escape_string($_POST['image_url'] ?? 'https://via.placeholder.com/800x500');

        // Use PHP's date() function to get the current timestamp
        $createdAt = date('Y-m-d H:i:s');

        // Insert query with prepared statements
        $stmt = $conn->prepare("INSERT INTO final_project_forum_posts (user_id, title, category, excerpt, image_url, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $userId, $title, $category, $excerpt, $imageUrl, $createdAt);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['post_id'] = $stmt->insert_id;
            $response['message'] = 'Post added successfully';
        } else {
            $response['message'] = 'Error saving post: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'You must be logged in to create a post';
    }
}

// Close connection
$conn->close();

// Send JSON response
echo json_encode($response);
?>