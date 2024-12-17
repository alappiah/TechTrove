<?php
session_start();
include("../db/database.php");

// Check if post_id is provided
if (!isset($_GET['post_id']) || empty($_GET['post_id'])) {
    header("Location: forum.php");
    exit();
}

$post_id = intval($_GET['post_id']);

// Fetch post details
$post_query = "SELECT p.post_id, p.title, p.category, p.excerpt, p.image_url, p.created_at, 
                      CONCAT(u.first_name, ' ', u.last_name) AS author_name
               FROM final_project_forum_posts p
               JOIN final_project_users u ON p.user_id = u.user_id 
               WHERE p.post_id = ?";
$post_stmt = $conn->prepare($post_query);
$post_stmt->bind_param("i", $post_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();

if ($post_result->num_rows === 0) {
    header("Location: forum.php");
    exit();
}

$post = $post_result->fetch_assoc();

// Fetch comments for this post
$comments_query = "SELECT c.comment_id, c.content, c.created_at, 
                          CONCAT(u.first_name, ' ', u.last_name) AS commenter_name,
                          c.parent_comment_id
                   FROM final_project_forum_comments c
                   JOIN final_project_users u ON c.user_id = u.user_id 
                   WHERE c.post_id = ?
                   ORDER BY c.created_at ASC";
$comments_stmt = $conn->prepare($comments_query);
$comments_stmt->bind_param("i", $post_id);
$comments_stmt->execute();
$comments_result = $comments_stmt->get_result();

$comments = [];
while ($comment = $comments_result->fetch_assoc()) {
    $comments[] = $comment;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Tech Trove Forum</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/forum.css">
</head>
<body>
    <nav class="main-navigation">
        <div class="nav-container">
            <div class="logo">
                <a href="#" class="logo"><img src="../assets/images/logo.png" alt="Tech Trove logo" width="110px" height="auto"></a>
            </div>
            <div class="nav-links">
                <a href="homepage.php">Home</a>
                <a href="forum.php">Forum</a>
            </div>
        </div>
    </nav>

    <div class="discussion-container">
        <div class="discussion-post">
            <div class="post-image">
                <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
            </div>
            <div class="post-content">
                <div class="post-header">
                    <span class="post-category"><?php echo htmlspecialchars($post['category']); ?></span>
                </div>
                <h1 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                <p class="post-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                <div class="post-meta">
                    <div class="author-info">
                        <img src="https://via.placeholder.com/40" alt="Author" class="author-avatar">
                        <span class="author-name"><?php echo htmlspecialchars($post['author_name']); ?></span>
                    </div>
                    <span class="post-date"><?php echo htmlspecialchars($post['created_at']); ?></span>
                </div>
            </div>
        </div>

        <div class="comments-section">
            <h2>Comments</h2>
            <form id="commentForm" class="add-comment-form">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <textarea name="comment_content" placeholder="Add a comment..." required></textarea>
                <input type="hidden" name="parent_comment_id" value="0">
                <button type="submit" class="submit-comment-btn">Post Comment</button>
            </form>

            <div id="commentsFeed" class="comments-feed">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment" data-comment-id="<?php echo $comment['comment_id']; ?>">
                        <div class="comment-content">
                            <div class="comment-author">
                                <img src="https://via.placeholder.com/30" alt="Commenter" class="commenter-avatar">
                                <span class="commenter-name"><?php echo htmlspecialchars($comment['commenter_name']); ?></span>
                                <span class="comment-date"><?php echo htmlspecialchars($comment['created_at']); ?></span>
                            </div>
                            <p><?php echo htmlspecialchars($comment['content']); ?></p>
                            <button class="reply-btn">Reply</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    

    <script src="../assets/js/discussion.js"></script>

</body>
</html>