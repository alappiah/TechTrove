<?php
// Include database connection
include('../db/database.php');

// Set header to return JSON (in case of browser issues)
header('Content-Type: application/json');

// Check if the query parameter is set
if (isset($_GET['query'])) {
    // Sanitize the query to prevent SQL injection
    $query = mysqli_real_escape_string($conn, $_GET['query']);
    
    // Search query with LIKE for partial matches
    $sql = "SELECT gadget_id, name FROM final_project_gadgets 
            WHERE name LIKE '%$query%' 
            LIMIT 5"; // Limit to 5 suggestions
    
    // Execute the query
    $result = mysqli_query($conn, $sql);
    
    // Check if there was an error in the query execution
    if (!$result) {
        // Return an error response if query fails
        echo json_encode(['error' => 'Error executing query: ' . mysqli_error($conn)]);
        exit;
    }

    // Prepare an array to hold the search results
    $suggestions = [];
    
    // Fetch results into the suggestions array
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = [
            'gadget_id' => $row['gadget_id'],
            'name' => $row['name']
        ];
    }
    
    // Return JSON-encoded suggestions
    echo json_encode($suggestions);
} else {
    // If no query is set, return an empty array
    echo json_encode([]);
}
?>
