<?php
// Include database connection
include ('../db/database.php');

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    // Sanitize input
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Check if fields are empty
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required!";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');
        window.location.href = '../view/register.php';</script>";
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');
        window.location.href = '../view/register.php';</script>";
        exit();
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

 

    // Current timestamp for created_at and updated_at
    $currentTime = date('Y-m-d H:i:s');

    // Check for duplicate email using prepared statement
    $checkEmailQuery = $conn->prepare("SELECT * FROM final_project_users WHERE email = ?");
    if ($checkEmailQuery === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $result = $checkEmailQuery->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email Address Already Exists!');
            window.location.href = '../view/register.php';</script>";
        exit();
    } else {
        // Insert user details into the database using prepared statements
        $insertQuery = $conn->prepare("INSERT INTO final_project_users (first_name, last_name, email, password,created_at) 
                                       VALUES (?, ?, ?, ?, ?)");
        if ($insertQuery === false) {
            die('MySQL prepare error: ' . $conn->error);
        }

        $insertQuery->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $currentTime);

        if ($insertQuery->execute()) {
            // Redirect to login page after successful registration
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
            exit();
        }
    }
}

// Close the connection
$conn->close();



?>
