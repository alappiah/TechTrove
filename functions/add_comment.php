<?php
session_start();
include("../db/database.php");

// Check if user is logged in (you'll need to implement user authentication)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to comment']);
    exit();
}

// Validate input
if (!isset($_POST['post_id']) || !isset($_POST['comment_content'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

$post_id = intval($_POST['post_id']);
$comment_content = trim($_POST['comment_content']);
$parent_comment_id = isset($_POST['parent_comment_id']) ? intval($_POST['parent_comment_id']) : 0;
$user_id = $_SESSION['user_id'];

if (empty($comment_content)) {
    echo json_encode(['success' => false, 'message' => 'Comment cannot be empty']);
    exit();
}

// Prepare and execute insert query
$insert_query = "INSERT INTO final_project_forum_comments 
                 (post_id, user_id, content, parent_comment_id, created_at) 
                 VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("iisi", $post_id, $user_id, $comment_content, $parent_comment_id);

if ($stmt->execute()) {
    $comment_id = $stmt->insert_id;
    
    // Fetch the new comment details
    $comment_fetch_query = "SELECT c.comment_id, c.content, c.created_at, 
                                    CONCAT(u.first_name, ' ', u.last_name) AS commenter_name
                             FROM final_project_forum_comments c
                             JOIN final_project_users u ON c.user_id = u.user_id 
                             WHERE c.comment_id = ?";
    $fetch_stmt = $conn->prepare($comment_fetch_query);
    $fetch_stmt->bind_param("i", $comment_id);
    $fetch_stmt->execute();
    $result = $fetch_stmt->get_result();
    $new_comment = $result->fetch_assoc();

    echo json_encode([
        'success' => true, 
        'comment' => $new_comment,
        'parent_comment_id' => $parent_comment_id
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add comment']);
}

$stmt->close();
$conn->close();

?>