<?php
// Start the session
session_start();

// Include database connection
include('../db/database.php');

// Function to get a random gadget ID
function getRandomGadgetId() {
    global $conn;
    
    // Query to get all gadget IDs
    $query = "SELECT gadget_id FROM final_project_gadgets"; // Replace with your actual table and column name
    $result = $conn->query($query);

    // If there are gadgets in the database, select one randomly
    if ($result && $result->num_rows > 0) {
        // Get all gadget IDs into an array
        $gadget_ids = [];
        while ($row = $result->fetch_assoc()) {
            $gadget_ids[] = $row['gadget_id'];
        }

        // Pick a random ID from the array
        $random_gadget_id = $gadget_ids[array_rand($gadget_ids)];

        return $random_gadget_id;
    } else {
        // If no gadgets found, return a default ID or handle the error
        return 1; // Default ID, you may handle this differently
    }
}

// Fetch the random gadget ID
$randomGadgetId = getRandomGadgetId();

// Separate SQL queries to get the total records from each category (table)
$total_home_appliances_query = "SELECT COUNT(*) AS total_home_appliances FROM final_project_home_appliances";
$total_pc_laptops_query = "SELECT COUNT(*) AS total_pc_laptops FROM final_project_laptops_pc_specifications";
$total_kitchen_appliances_query = "SELECT COUNT(*) AS total_kitchen_appliances FROM final_project_kitchen_appliances";
$total_phone_tablets_query = "SELECT COUNT(*) AS total_phone_tablets FROM final_project_mobile_specifications";
$total_accesories_query = "SELECT COUNT(*) AS total_accesories FROM final_project_accesories";

// Execute the queries
$total_home_appliances_result = mysqli_query($conn, $total_home_appliances_query);
$total_pc_laptops_result = mysqli_query($conn, $total_pc_laptops_query);
$total_kitchen_appliances_result = mysqli_query($conn, $total_kitchen_appliances_query);
$total_phone_tablets_result = mysqli_query($conn, $total_phone_tablets_query);
$total_accesories_result = mysqli_query($conn, $total_accesories_query);

// Fetch the results and store them in variables
if ($total_home_appliances_result) {
    $home_appliances_row = mysqli_fetch_assoc($total_home_appliances_result);
    $total_home_appliances = $home_appliances_row['total_home_appliances'];
} else {
    $total_home_appliances = 0;
}

if ($total_pc_laptops_result) {
    $pc_laptops_row = mysqli_fetch_assoc($total_pc_laptops_result);
    $total_pc_laptops = $pc_laptops_row['total_pc_laptops'];
} else {
    $total_pc_laptops = 0;
}

if ($total_kitchen_appliances_result) {
    $kitchen_appliances_row = mysqli_fetch_assoc($total_kitchen_appliances_result);
    $total_kitchen_appliances = $kitchen_appliances_row['total_kitchen_appliances'];
} else {
    $total_kitchen_appliances = 0;
}

if ($total_phone_tablets_result) {
    $phone_tablets_row = mysqli_fetch_assoc($total_phone_tablets_result);
    $total_phone_tablets = $phone_tablets_row['total_phone_tablets'];
} else {
    $total_phone_tablets = 0;
}

if ($total_accesories_result) {
    $accesories_row = mysqli_fetch_assoc($total_accesories_result);
    $total_accesories = $accesories_row['total_accesories'];
} else {
    $total_accesories = 0;
}

// Close the database connection
mysqli_close($conn);
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../assets/css/homepage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="bg-image">
        <!-- Background Carousel -->
        <div class="background-carousel">
            <div class="bg-slide active" style="background-image: url('../assets/images/slide-image-1.png');"> 
                <section class="main">
                    <h2>Find the right gadget for you today</h2>
                </section>
            </div>
            <div class="bg-slide" style="background-image: url('../assets/images/slide-image-2.png');">
                <section class="main">
                    <h5>Accessories</h5>
                    <h2>Next Generation Virtual Reality</h2>
                </section>
            </div>
            <div class="bg-slide" style="background-image: url('../assets/images/slide-image-3.png');"></div>
        </div>
    
        <!-- Header Section -->
        <header class="header">
            <a href="#" class="logo"><img src="../assets/images/logo.png" alt="Tech Trove logo"  width="110px" height="auto"></a>
    
            <nav class="nav">
                <a href="#">Home</a>
                <a href="compare.php?id=<?php echo $randomGadgetId; ?>">Compare</a>
                <a href="forum.php">Forum</a>
                <a href="settings.php">Settings</a>
                <form action="../actions/search_results.php" method="GET">
                    <input type="text" id="search-input" name="query" placeholder="Search gadgets..." autocomplete="off" onkeyup="searchSuggestions()">
                <div id="suggestions-dropdown" class="dropdown-content"></div>
                </form>
                <a href="../actions/logout.php" onclick="return confirm('Are you sure you want to log out?')">Logout</a>
            </nav>
        </header>
    
        <!-- Main Content Section -->
       
    </div>
    

    
    <div class="options">
        <div class="option">
            <div class="card-image1"></div>
        </div>
        <div class="option">
            <div class="card-image2"></div>
        </div>
        <div class="option">
            <div class="card-image3">
            </div>
        </div>
    </div>
    
    <div class="category-section">
        <h2>Choose your Category</h2>
        <p>Browse through our categories to find the best gadgets available.</p>
        
        <div class="categories">
            <div class="category-item">
                <img src="../assets/images/image4.png" alt="Home Appliances">
                <h3>Home Appliances</h3>
                <p><?php echo $total_home_appliances; ?> Items</p>
            </div>
            <div class="category-item">
                <img src="../assets/images/image5.png" alt="PC & Laptop">
                <h3>PC & Laptop</h3>
                <p><?php echo $total_pc_laptops; ?> Items</p>
            </div>
            <div class="category-item">
                <img src="../assets/images/image6.png" alt="Kitchen Appliances">
                <h3>Kitchen Appliances</h3>
                <p><?php echo $total_kitchen_appliances; ?> Items</p>
            </div>
            <div class="category-item">
                <img src="../assets/images/image7.png" alt="Phone & Tablet">
                <h3>Phone & Tablet</h3>
                <p><?php echo $total_phone_tablets; ?> Items</p>
            </div>
            <div class="category-item">
                <img src="../assets/images/image8.png" alt="Accessories">
                <h3>Accessories</h3>
                <p><?php echo $total_accesories; ?> Items</p>
            </div>
        </div>
    </div>
    <h2 id="highly-recommended">Highly recommended</h2>
    <div class="recommended-section">
        <div class="recommended-option">
            <img src="../assets/images/image9.png" alt="Smart Phone 12">
            <p class="category">Mobile</p> 
            <h3>iPhone 16 Pro Max</h3>
            <a href="compare.php?id=9" class="see-more">See More</a>
        </div>
        <div class="recommended-option">
            <img src="../assets/images/image10.png" alt="PS5 Pro">
            <p class="category">Accessories</p>
            <h3>Playtation Five Pro</h3>
            <a href="compare.php?id=8" class="see-more">See More</a>
        </div>
        <div class="recommended-option">
            <img src="../assets/images/image11.png" alt="Dell Laptop">
            <p class="category">PC & Laptop</p>
            <h3>Dell XPS 15</h3>
            <a href="compare.php?id=5" class="see-more">See More</a>
        </div>
        <div class="recommended-option">
            <img src="../assets/images/image12.png" alt="JBL Speaker">
            <p class="category">Accessories</p>
            <h3>JBL flip 5</h3>
            <a href="compare.php?id=6" class="see-more">See More</a>
        </div>
        <div class="recommended-option">
            <img src="../assets/images/image13.png" alt="Microwave Oven">
            <p class="category">Kitchen Appliances</p>
            <h3>Maxemi Microwave Oven</h3>
            <a href="compare.php?id=7" class="see-more">See More</a>
        </div>
        
        
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p>&copy TechTrove</p>
            <div class="footer-logo">
            <a href="#" class="logo"><img src="../assets/images/logo.png" alt="Tech Trove logo"  width="110px" height="auto"></a>
            </div>
            <nav class="footer-links">
                <a href="homepage.php">Home</a>
                <a href="forum.php">Forum</a>
                <a href="compare.php?id=<?php echo $randomGadgetId; ?>">Compare</a>
                <a href="settings.php">Settings</a>
            </nav>
        </div>
    </footer>
    

    
    <script src="../assets/js/homepage.js"></script>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../assets/js/settings.js"></script>
    
</body>
</html>