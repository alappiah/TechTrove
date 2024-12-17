<?php
// Start the session to track user
session_start();

// Include database connection
include('../db/database.php');

if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conn, $_GET['query']);
    
    // Query the database for matching results
    $sql = "SELECT * FROM final_project_gadgets WHERE name LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);
    
    echo "<h2>Search Results for: '$query'</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='product'>";
        echo "<a href='../view/compare.php?id=" . $row['gadget_id'] . "'>" . $row['name'] . "</a>";
        echo "</div>";
    }
}
?>
