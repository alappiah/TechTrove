<?php
// Start the session to track user
session_start();

// Include database connection
include('../db/database.php');

if (isset($_POST['login'])) {
    // Sanitize input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit();
    }

    // Query to check if the user exists
    $checkUserQuery = $conn->prepare("SELECT * FROM final_project_users WHERE email = ?");
    $checkUserQuery->bind_param("s", $email);
    $checkUserQuery->execute();
    $result = $checkUserQuery->get_result();

    if ($result->num_rows == 0) {
        // No user found with this email, redirect with an alert
        echo "<script>
                alert('No user found with this email!');
                window.location.href = '../index.php';
              </script>";
        exit();
    } else {
        // Fetch user details
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['fname'];
            $_SESSION['last_name'] = $user['lname'];
            $_SESSION['email'] = $email;

            header("Location:  ../view/homepage.php"); // For admin
           
            exit(); // Make sure to exit after header
        } else {
            // Incorrect password, redirect with an alert
            echo "<script>
                    alert('Incorrect password!');
                    window.location.href = '../index.php';
                  </script>";
            exit();
        }
    }
}
?>
