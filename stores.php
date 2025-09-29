<?php
// 1. INCLUDE DATABASE CONNECTION FILE
// This line replaces all the connection setup (servername, user, password, new mysqli())
// Note: Adjust the path if database.php is in a different directory (e.g., 'config/database.php')
include 'database.php'; 

// --- FETCH STORE DATA (Now uses the $conn variable from database.php) ---
$stores = [];

// We fetch the name, full address (concatenated), and the map_url
$sql = "SELECT 
            name, 
            address_line_1, 
            city, 
            map_url 
        FROM stores 
        WHERE is_active = 1"; 

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Construct the full address
        $row['address'] = $row['address_line_1'] . ', ' . $row['city'];
        
        // Use the fetched map_url directly
        $row['map_link'] = $row['map_url']; 
        
        // Add hardcoded details (you should add 'phone' and 'hours' columns to your table)
        $row['phone'] = '011 XXX YYYY';
        $row['hours'] = 'Mon-Sat: 9am - 7pm, Sun: 9am - 5pm';
        
        $stores[] = $row;
    }
}
// 2. CLOSE CONNECTION
// It's good practice to close the connection once all data is fetched.
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Locator</title>
    <link rel="stylesheet" href="Assets/CSS/stores.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <div class="app-container store-locator-container">
        <div class="store-locator-content">

            <div class="store-header">
                <a href="index.php" class="close-btn"><i class="fa-solid fa-xmark"></i></a>
                <h2>Find a Store</h2>
                <p class="subtitle">Click on a store to open its location in Google Maps.</p>
            </div>
            
            <div id="map" class="map-placeholder">
                <i class="fa-solid fa-map-location-dot fa-5x"></i>
                <p>Interactive Map disabled. Please select a store below for navigation.</p>
            </div>

            <div class="store-list-wrapper">
                <h3>Store List</h3>
                <div id="store-list">
                    <?php foreach ($stores as $store): ?>
                        
                        <a href="<?php echo $store['map_link']; ?>" target="_blank" class="store-item-link">
                            <div class="store-item">
                                <h4><?php echo $store['name']; ?></h4>
                                <p><i class="fa-solid fa-location-dot"></i> <?php echo $store['address']; ?></p>
                                <p><i class="fa-solid fa-clock"></i> <?php echo $store['hours']; ?></p>
                                <p><i class="fa-solid fa-phone"></i> <?php echo $store['phone']; ?></p>
                            </div>
                        </a>
                        
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</body>
</html>