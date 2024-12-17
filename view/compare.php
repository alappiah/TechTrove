<?php
session_start();
include('../db/database.php'); // Ensure database connection

// Ensure that 'id' is set in the URL
$gadget_id = isset($_GET['id']) ? $_GET['id'] : 0; // Default to 0 if 'id' is not set

// Check if the database connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Step 1: Search for the gadget and get gadget_id and category_id
$query = "SELECT gadget_id, category_id FROM final_project_gadgets WHERE gadget_id = ?";
$stmt = $conn->prepare($query); // Prepare the query using the correct $conn object

if ($stmt === false) {
    die("Error preparing the query: " . $conn->error);
}

$stmt->bind_param("i", $gadget_id); // Use 'i' for integer type
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $gadget = $result->fetch_assoc();
    $category_id = $gadget['category_id'];

    // Step 2: Dynamically fetch the specifications based on category_id
    $spec_query = "";

    switch ($category_id) {
        case 1:
            // For category 1, fetch from the mobile specifications table
            $spec_query = "SELECT * FROM final_project_mobile_specifications WHERE gadget_id = ?";
            break;
        case 2:
            // For category 2, fetch from laptops/pc specifications
            $spec_query = "SELECT * FROM final_project_laptops_pc_specifications WHERE gadget_id = ?";
            break;
        case 3:
            // For category 3, fetch from accessories
            $spec_query = "SELECT * FROM final_project_accesories WHERE gadget_id = ?";
            break;
        case 4:
            // For category 4, fetch from kitchen appliances
            $spec_query = "SELECT * FROM final_project_kitchen_appliances WHERE gadget_id = ?";
            break;
        case 5:
            // For category 5, fetch from home appliances
            $spec_query = "SELECT * FROM final_project_home_appliances WHERE gadget_id = ?";
            break;
        default:
            echo "No specifications available for this category.";
            exit;
    }

    // Prepare the query to fetch specifications
    $spec_stmt = $conn->prepare($spec_query);
    if ($spec_stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    $spec_stmt->bind_param("i", $gadget_id);
    $spec_stmt->execute();
    $spec_result = $spec_stmt->get_result();

    if ($spec_result->num_rows > 0) {
        $specifications = $spec_result->fetch_assoc();
    } else {
        echo "No specifications found for this gadget.";
    }

} else {
    echo "No gadget found for the given ID.";
}

// Step 3: Fetch similar products
$similar_query = "
    SELECT 
        g.name AS similar_gadget_name,
        sp.description AS similar_gadget_description
    FROM 
        final_project_similar_products sp
    JOIN 
        final_project_gadgets g ON sp.similar_gadget_id = g.gadget_id
    WHERE 
        sp.gadget_id = ?
    ORDER BY 
        RAND()
    LIMIT 3";

$similar_stmt = $conn->prepare($similar_query);
if ($similar_stmt === false) {
    die("Error preparing query: " . $conn->error . " | SQL: " . $similar_query);
}

$similar_stmt->bind_param("i", $gadget_id);
$similar_stmt->execute();
$similar_result = $similar_stmt->get_result();

// Display Specifications and Similar Products
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare</title>
    <link rel="stylesheet" href="../assets/css/compare.css">
</head>

<body>
    <header class="header">
        <a href="homepage.php"><ion-icon name="arrow-back-outline"></ion-icon>Home</a>
    </header>


    <main class="body-content">
        <div class="parent active">
            <div class="Title">
                <div class="title-container">
                    <div class="title-left-content">
                        <img src="Homepage_Images/image5.png">
                        <h2>
                            <?php echo htmlspecialchars($specifications['brand_model']); ?>
                        </h2>
                    </div>
                    <div class="title-right-content">
                        <button class="change-button">Change</button>
                        <button class="compare-button">Compare</button>
                    </div>

                </div>
            </div>
            <div class="navigation-buttons">
                <a href="#specs" class="active" data-section="specs"><button
                        class="specs-button">Specifications</button></a>
                <a href="#reviews" data-section="reviews"><button class="reviews-button">View Reviews</button></a>
                <a href="#buy" data-section="buy"><button class="buy-button">Where to buy</button></a>
                <a href="#similar" data-section="similar"><button class="similar-button">View Similar
                        Products</button></a>
            </div>

            <div class="section-container">
                <div class="table-container section-content active" id="specs">
                    <table>
                        <tr>
                            <th>Category</th>
                            <th>Specification</th>
                        </tr>
                        <tr>
                            <td><strong>Brand and Model</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['brand_model']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Display</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['display']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Processor</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['processor']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>RAM</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['ram']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Storage</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['storage']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Camera System</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['camera_system']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Battery</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['battery']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Battery Life Estimates</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['battery_life']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Operating System</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['operating_system']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Connectivity</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['connectivity']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Build and Design</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['build_design']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Price</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['price']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Special Features</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['special_features']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>User Reviews and Ratings</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['user_reviews']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Other Notable Features</strong></td>
                            <td>
                                <?php echo htmlspecialchars($specifications['notable_features']); ?>
                            </td>
                        </tr>
                    </table>
                    </div>
                    <div id="comparison-container"></div>



                    <div id="reviews" class="section-content">
                    <div class="review-container">
                        <p>"Amazing phone, great camera!" - John D.</p>
                        <p>"Solid performance, battery life is impressive." - Sarah M.</p>
                        <p>"Best smartphone I've ever owned." - Mike R.</p>
                    </div>
                    </div>

                    <div id="buy" class="section-content">
                    <div class="buy-options">
                        <div class="retailer">
                            <h4>Amazon</h4>
                            <button onclick="window.open('https://www.amazon.com', '_blank')" class="buy-now-button">Buy
                                Now</button>
                        </div>
                        <div class="retailer">
                            <h4>Best Buy</h4>
                            <button onclick="window.open('https://www.bestbuy.com', '_blank')"
                                class="buy-now-button">Buy Now</button>
                        </div>
                    </div>
                    </div>

                    <div id="similar" class="section-content">
                    <div class="similar-products">
                        <div class="product">
                            <?php
                        if ($similar_result->num_rows > 0) {
                            while ($product = $similar_result->fetch_assoc()) {
                                ?>
                            <div class="product">
                                <h3>
                                    <?php echo htmlspecialchars($product['similar_gadget_name']); ?>
                                </h3>
                                <p>
                                    <?php echo htmlspecialchars($product['similar_gadget_description']); ?>
                                </p>
                                <br> <!-- Space between product name and description -->

                            </div>
                            <?php
                            }
                        } else {
                            echo "<p>No similar products found.</p>";
                        }
                        ?>

                        </div>
                    </div>
                </div>

            </div>
            

            <div class="div5">sc</div>
            </div>
            <div class="search-container" id="search-container">
                <div class="search-bar">
                    <input type="text" id="search-input" name="query" placeholder="Compare to..." autocomplete="off" onkeyup="searchSuggestions()">
                </div>
                <div id="search-suggestions-dropdown" class="suggestions-dropdown"></div>
            </div>
            
            <div class="change-container" id="change-container">
                <div class="search-bar">
                <input type="text" id="change-input" name="query" placeholder="Change to..." autocomplete="off" onkeyup="change()">
             </div>
    <div id="change-suggestions-dropdown" class="suggestions-dropdown"></div>
</div>
</div>
                
           
        
        </div>
        

    </main>

    <script src="../assets/js/compare.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>