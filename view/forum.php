<?php
session_start();
include("../db/database.php");

// Fetch forum posts with user information (first name and last name)
$query = "SELECT p.post_id, p.title, p.category, p.excerpt, p.image_url, p.created_at, CONCAT(u.first_name, ' ', u.last_name) AS full_name 
          FROM final_project_forum_posts p
          JOIN final_project_users u ON p.user_id = u.user_id 
          ORDER BY p.created_at DESC";

$result = $conn->query($query);

// Prepare an array to store the posts
$posts = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget Review Forum</title>
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
                <a href="#" class="active">Forum</a>
                <button class="add-post-btn" id="openAddPostModal">
                    <i class="fas fa-plus"></i> Add Post
                </button>
            </div>
        </div>
    </nav>

    <div class="forum-container">
    <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search discussions, gadgets, reviews...">
    </div>

    <div class="filter-container">
        <div class="filter-section">
            <h3>Categories</h3>
            <div class="forum-categories">
                <button class="category-btn active" data-category="all">All Gadgets</button>
                <button class="category-btn" data-category="Phones and Tablets">Phones and Tablets</button>
                <button class="category-btn" data-category="PC and Laptops">PC and Laptops</button>
                <button class="category-btn" data-category="Accessories">Accessories</button>
                <button class="category-btn" data-category="Kitchen Appliances">Kitchen Appliances</button>
                <button class="category-btn" data-category="Home Appliances">Home Appliances</button>
            </div>
        </div>
    </div>

    <div class="forum-posts" id="forumFeed">
        <?php
        if (empty($posts)) {
            echo "<p>No posts available.</p>";
        } else {
            foreach ($posts as $post) {
                echo "
                <div class='forum-post' data-category='{$post['category']}'>
                    <div class='post-image'>
                        <img src='{$post['image_url']}' alt='{$post['title']}'>
                    </div>
                    <div class='post-content'>
                        <div class='post-header'>
                            <span class='post-category'>{$post['category']}</span>
                        </div>
                        <h2 class='post-title'>{$post['title']}</h2>
                        <p class='post-excerpt'>{$post['excerpt']}</p>
                        <div class='post-meta'>
                            <div class='author-info'>
                                <img src='https://via.placeholder.com/40' alt='Author' class='author-avatar'>
                                <span class='author-name'>{$post['full_name']}</span>
                            </div>
                            <span class='post-date'>{$post['created_at']}</span>
                        </div>
                        <a href='discussion.php?post_id={$post['post_id']}' class='read-more'>Read Full Discussion</a>
                    </div>
                </div>";
            }
        }
        ?>
    </div>
</div>


    <!-- Add Post Modal -->
    <div class="modal" id="addPostModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Create New Post</h2>
            <form id="addPostForm">
                <div class="form-group">
                    <label for="postTitle">Title</label>
                    <input type="text" id="postTitle" required>
                </div>
                <div class="form-group">
                    <label for="postCategory">Category</label>
                    <select id="postCategory" required>
                        <option value="">Select Category</option>
                        <option value="Phones and Tablets">Phones and Tablets</option>
                        <option value="PC and Laptops">PC and Laptops</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Kitchen Appliances">Kitchen Appliances</option>
                        <option value="Home Appliances">Home Appliances</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="postExcerpt">Post Excerpt</label>
                    <textarea id="postExcerpt" required></textarea>
                </div>
                <div class="form-group">
                    <label for="postImage">Post Image (URL)</label>
                    <input type="url" id="postImage" placeholder="Optional image URL">
                </div>
                <button type="submit" class="submit-post-btn">Publish Post</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/forum.js"></script>
</body>
</html>
