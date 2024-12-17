document.addEventListener('DOMContentLoaded', () => {
    const categoryButtons = document.querySelectorAll('.category-btn');
    const forumFeed = document.getElementById('forumFeed');

    // Function to filter posts based on selected category
    function filterPosts(category) {
        const forumPosts = document.querySelectorAll('.forum-post');  // Always select posts when filtering
        
        forumPosts.forEach(post => {
            const postCategory = post.dataset.category;
            if (category === 'all' || postCategory === category) {
                post.style.display = 'flex'; // Show the post
            } else {
                post.style.display = 'none'; // Hide the post
            }
        });
    }

    // Add Post Modal Functionality
    const addPostModal = document.getElementById('addPostModal');
    const openAddPostModalBtn = document.getElementById('openAddPostModal');
    const closeModalBtn = document.querySelector('.close-modal');
    const addPostForm = document.getElementById('addPostForm');

    // Open Modal
    openAddPostModalBtn.addEventListener('click', () => {
        addPostModal.style.display = 'block';
    });

    // Close Modal
    closeModalBtn.addEventListener('click', () => {
        addPostModal.style.display = 'none';
    });

    // Close modal if clicked outside
    window.addEventListener('click', (event) => {
        if (event.target === addPostModal) {
            addPostModal.style.display = 'none';
        }
    });

    // Add New Post
    addPostForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Gather form data
        const title = document.getElementById('postTitle').value;
        const category = document.getElementById('postCategory').value;
        const excerpt = document.getElementById('postExcerpt').value;
        const imageUrl = document.getElementById('postImage').value || 'https://via.placeholder.com/800x500';

        // Create FormData to send to server
        const formData = new FormData();
        formData.append('title', title);
        formData.append('category', category);
        formData.append('excerpt', excerpt);
        formData.append('image_url', imageUrl);

        // Send AJAX request to add post
        fetch('../functions/add_post.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Create new post element
                const newPost = document.createElement('div');
                newPost.className = 'forum-post';
                newPost.dataset.category = category;
                newPost.dataset.postId = data.post_id;
                newPost.innerHTML = `
                    <div class="post-image">
                        <img src="${imageUrl}" alt="${title}">
                    </div>
                    <div class="post-content">
                        <div class="post-header">
                            <span class="post-category">${category}</span>
                        </div>
                        <h2 class="post-title">${title}</h2>
                        <p class="post-excerpt">${excerpt}</p>
                        <div class="post-meta">
                            <div class="author-info">
                                <img src="https://via.placeholder.com/40" alt="Author" class="author-avatar">
                                <span class="author-name">You</span>
                            </div>
                            <span class="post-date">Just now</span>
                        </div>
                        <a href="#" class="read-more">Read Full Discussion</a>
                    </div>
                `;

                // Add new post to the feed
                forumFeed.insertBefore(newPost, forumFeed.firstChild);

                // Reset form and close modal
                addPostForm.reset();
                addPostModal.style.display = 'none';

                // Reapply current category filter
                const activeCategory = document.querySelector('.category-btn.active').dataset.category;
                filterPosts(activeCategory);
            } else {
                // Handle error (e.g., show error message)
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the post');
        });
    });

    // Filter posts based on the category button clicked
    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to the clicked button
            button.classList.add('active');

            // Filter posts based on the selected category
            const category = button.dataset.category;
            filterPosts(category);
        });
    });

    // Initial filter on page load (show all posts)
    filterPosts('all');

    // Search functionality for filtering posts by title or excerpt
    const searchInput = document.querySelector('.search-container input');
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        
        // Select all forum posts
        const forumPosts = document.querySelectorAll('.forum-post');
        
        forumPosts.forEach(post => {
            const title = post.querySelector('.post-title').textContent.toLowerCase();
            const excerpt = post.querySelector('.post-excerpt').textContent.toLowerCase();
            
            // Filter posts by search term (searches through title and excerpt)
            if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                post.style.display = 'flex';  // Show matching posts
            } else {
                post.style.display = 'none';  // Hide non-matching posts
            }
        });
    });
});
