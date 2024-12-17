document.addEventListener('DOMContentLoaded', () => {
    const commentForm = document.getElementById('commentForm');
    const commentsFeed = document.getElementById('commentsFeed');

    // Add comment functionality
    commentForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(commentForm);

        fetch('../functions/add_comment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Create new comment element
                const newCommentDiv = document.createElement('div');
                newCommentDiv.className = 'comment';
                newCommentDiv.dataset.commentId = data.comment.comment_id;
                newCommentDiv.innerHTML = `
                    <div class="comment-content">
                        <div class="comment-author">
                            <img src="https://via.placeholder.com/30" alt="Commenter" class="commenter-avatar">
                            <span class="commenter-name">${data.comment.commenter_name}</span>
                            <span class="comment-date">${data.comment.created_at}</span>
                        </div>
                        <p>${data.comment.content}</p>
                        <button class="reply-btn">Reply</button>
                    </div>
                `;

                // If it's a reply to a parent comment, nest it
                if (data.parent_comment_id > 0) {
                    const parentComment = document.querySelector(`.comment[data-comment-id="${data.parent_comment_id}"]`);
                    if (parentComment) {
                        // Create replies container if it doesn't exist
                        let repliesContainer = parentComment.querySelector('.comment-replies');
                        if (!repliesContainer) {
                            repliesContainer = document.createElement('div');
                            repliesContainer.className = 'comment-replies';
                            parentComment.appendChild(repliesContainer);
                        }
                        repliesContainer.appendChild(newCommentDiv);
                    }
                } else {
                    // Add to main comments feed
                    commentsFeed.appendChild(newCommentDiv);
                }

                // Reset form
                commentForm.reset();
                commentForm.querySelector('input[name="parent_comment_id"]').value = '0';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the comment');
        });
    });

    // Reply button functionality
    commentsFeed.addEventListener('click', (e) => {
        if (e.target.classList.contains('reply-btn')) {
            const commentContent = e.target.closest('.comment-content');
            const commentId = e.target.closest('.comment').dataset.commentId;
            
            // Create reply form
            const replyForm = document.createElement('form');
            replyForm.className = 'reply-form';
            replyForm.innerHTML = `
                <textarea name="reply_content" placeholder="Write a reply..." required></textarea>
                <input type="hidden" name="post_id" value="${commentForm.querySelector('input[name="post_id"]').value}">
                <input type="hidden" name="parent_comment_id" value="${commentId}">
                <button type="submit" class="submit-reply-btn">Post Reply</button>
                <button type="button" class="cancel-reply-btn">Cancel</button>
            `;

            // Add event listener for the reply form submission
            replyForm.addEventListener('submit', (submitEvent) => {
                submitEvent.preventDefault();
                const replyFormData = new FormData(replyForm);

                fetch('../functions/add_comment.php', {
                    method: 'POST',
                    body: replyFormData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Similar comment addition logic as above
                        const newReplyDiv = document.createElement('div');
                        newReplyDiv.className = 'comment comment-reply';
                        newReplyDiv.dataset.commentId = data.comment.comment_id;
                        newReplyDiv.innerHTML = `
                            <div class="comment-content">
                                <div class="comment-author">
                                    <img src="https://via.placeholder.com/30" alt="Commenter" class="commenter-avatar">
                                    <span class="commenter-name">${data.comment.commenter_name}</span>
                                    <span class="comment-date">${data.comment.created_at}</span>
                                </div>
                                <p>${data.comment.content}</p>
                            </div>
                        `;

                        // Add to replies container or create one
                        let repliesContainer = commentContent.closest('.comment').querySelector('.comment-replies');
                        if (!repliesContainer) {
                            repliesContainer = document.createElement('div');
                            repliesContainer.className = 'comment-replies';
                            commentContent.closest('.comment').appendChild(repliesContainer);
                        }
                        repliesContainer.appendChild(newReplyDiv);

                        // Remove reply form
                        replyForm.remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while adding the reply');
                });
            });

            // Cancel reply button
            replyForm.querySelector('.cancel-reply-btn').addEventListener('click', () => {
                replyForm.remove();
            });

            // Insert reply form after the comment content
            commentContent.after(replyForm);
        }
    });
});