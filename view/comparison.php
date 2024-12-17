<?php
// Include database connection
include('../db/database.php');

// Get gadget IDs from the URL
$id1 = isset($_GET['id1']) ? (int)$_GET['id1'] : 0;
$id2 = isset($_GET['id2']) ? (int)$_GET['id2'] : 0;

// Get category_id for gadget 1 and gadget 2
$category_id1 = 0;
$category_id2 = 0;

// Fetch category_id for gadget 1
if ($id1) {
    $query1 = "SELECT category_id FROM final_project_gadgets WHERE gadget_id = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $id1);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    if ($result1->num_rows > 0) {
        $row1 = $result1->fetch_assoc();
        $category_id1 = $row1['category_id'];
    }
}

// Fetch category_id for gadget 2
if ($id2) {
    $query2 = "SELECT category_id FROM final_project_gadgets WHERE gadget_id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $id2);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $category_id2 = $row2['category_id'];
    }
}

// Fetch specifications for gadget 1 based on category_id
$specs1 = [];
if ($id1) {
    switch ($category_id1) {
        case 1: // Mobile
            $query1 = "SELECT * FROM final_project_mobile_specifications WHERE gadget_id = ?";
            break;
        case 2: // PC & Laptop
            $query1 = "SELECT * FROM final_project_laptops_pc_specifications WHERE gadget_id = ?";
            break;
        case 3: // Accessories
            $query1 = "SELECT * FROM final_project_accesories WHERE gadget_id = ?";
            break;
        case 4: // Kitchen Appliances
            $query1 = "SELECT * FROM final_project_kitchen_appliances WHERE gadget_id = ?";
            break;
        case 5: // Home Appliances
            $query1 = "SELECT * FROM final_project_home_appliances WHERE gadget_id = ?";
            break;
        default:
            echo "Invalid category for gadget 1.";
            exit;
    }
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $id1);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $specs1 = $result1->fetch_assoc();
}

// Fetch specifications for gadget 2 based on category_id
$specs2 = [];
if ($id2) {
    switch ($category_id2) {
        case 1: // Mobile
            $query2 = "SELECT * FROM final_project_mobile_specifications WHERE gadget_id = ?";
            break;
        case 2: // PC & Laptop
            $query2 = "SELECT * FROM final_project_laptops_pc_specifications WHERE gadget_id = ?";
            break;
        case 3: // Accessories
            $query2 = "SELECT * FROM final_project_accesories WHERE gadget_id = ?";
            break;
        case 4: // Kitchen Appliances
            $query2 = "SELECT * FROM final_project_kitchen_appliances WHERE gadget_id = ?";
            break;
        case 5: // Home Appliances
            $query2 = "SELECT * FROM final_project_home_appliances WHERE gadget_id = ?";
            break;
        default:
            echo "Invalid category for gadget 2.";
            exit;
    }
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $id2);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $specs2 = $result2->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparison</title>
    <link rel="stylesheet" href="../assets/css/compare.css">
</head>
<body>
    <header class="header">
        <a href="compare.php?id=<?php echo $id1; ?>"><ion-icon name="arrow-back-outline"></ion-icon>Back</a>
    </header>

    <main>
        <div class="comparison-container">
            <?php if (!empty($specs1) && !empty($specs2)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Specification</th>
                            <th><?php echo htmlspecialchars($specs1['brand_model']); ?></th>
                            <th><?php echo htmlspecialchars($specs2['brand_model']); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fields = [
                            'display' => 'Display',
                            'processor' => 'Processor',
                            'ram' => 'RAM',
                            'storage' => 'Storage',
                            'camera_system' => 'Camera System',
                            'battery' => 'Battery',
                            'battery_life' => 'Battery Life Estimates',
                            'operating_system' => 'Operating System',
                            'connectivity' => 'Connectivity',
                            'build_design' => 'Build and Design',
                            'price' => 'Price',
                            'special_features' => 'Special Features',
                            'user_reviews' => 'User Reviews and Ratings',
                            'notable_features' => 'Other Notable Features',
                        ];

                        foreach ($fields as $field => $label): ?>
                            <tr>
                                <td><?php echo $label; ?></td>
                                <td><?php echo htmlspecialchars($specs1[$field] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($specs2[$field] ?? 'N/A'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Please select two gadgets to compare.</p>
            <?php endif; ?>
        </div>
    </main>

    <script src="../assets/js/compare.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
