<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../assets/css/settings.css">
</head>


<body>
    <header class="header">
        <a href="homepage.php" ><ion-icon name="arrow-back-outline"></ion-icon>Home</a>
    </header>

    <div class="parent">

        <nav class="sidebar">
            <ul>
                <li><a href="#personal-info" class="active" data-section="personal-info">Edit profile</a></li>
                <li><a href="#account-security" data-section="account-security">Password</a></li>
                <li><a href="#preferences" data-section="preferences">Preferences</a></li>
                <li><a href="#feedback" data-section="feedback"><i class="fas fa-comment-alt"></i> Feedback</a></li>
                <li><a href="#delete-info" style="color: red;" data-section="delete-info">Delete account</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <section id="personal-info" class="section-content active">
                <h2>Edit profile</h2>
                <form method="POST" action="../functions/updateProfile.php">
                    <div class="form-group"> <label for="avatar">Avatar</label> <input type="file" id="avatar"
                            name="avatar">
                        <small>At least 800x800 px recommended. JPG, PNG, and GIF are allowed.</small>
                    </div>

                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" id="fname" name="fName" placeholder="Enter your first name">
                        <label for="lname">Last Name</label>
                        <input type="text" id="lname" name="lName" placeholder="Enter your last name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <button type="submit" class="save-button">Save Changes</button>
                </form>
            </section>
            <section id="account-security" class="section-content">
                <h2>Account Security</h2>
                <form id="account-security-form" method="POST" action="../functions/password-change.php">
                    <h3>Change Password</h3>
                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" name="currentPassword"
                            placeholder="Enter current password" required>
                        <span id="current-password-error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="newPassword" placeholder="Enter new password">
                        <span id="new-password-error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirmPassword"
                            placeholder="Confirm new password">
                        <span id="confirm-password-error" style="color: red;"></span>
                    </div>
                    <button type="submit" class="save-button">Save Security Settings</button>
                </form>
            </section>
            <section id="preferences" class="section-content">
                <h2>Preferences</h2>
                <div class="form-group">
                    <label for="theme">Theme</label>
                    <select id="theme" name="theme">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                    </select>
                </div>
                <button id="apply-preferences" class="save-button">Apply Preferences</button>
            </section>
            <section id="feedback" class="section-content">
                <h2>Feedback</h2>
                <form id="feedback-form" method="POST" action="../functions/feedback_user.php">
                    <div class="form-group">
                        <label for="feedback-input">Your Feedback</label>
                        <textarea id="feedback-input" name="feedback-text" placeholder="How was your experience?"></textarea>
                    </div>
                    <button type="submit" class="save-button">Submit Feedback</button>
                </form>
            </section>
            <section id="delete-info" class="section-content">
                <h2> Are you sure you want to delete your account?</h2>
                <form method="POST" action="../functions/delete-info.php" id="delete-account-form">
                    <button type="submit" class="save-button" onclick="confirmDeletion(event)">Yes, Delete</button>
                </form>
            </section>

        </div>
    </div>

    <script src="../assets/js/settings.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>