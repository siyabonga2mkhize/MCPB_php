<?php
// Retrieve the name and certificate from the query parameters
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Unknown';
$certificate = isset($_GET['certificate']) ? htmlspecialchars($_GET['certificate']) : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - <?php echo $name; ?></title>
    <link rel="stylesheet" href="ASSETS/css/about.css">
    <style>
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            color: black;
            border: none;
            font-size: 20px;
            cursor: pointer;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <button class="close-button" onclick="window.location.href='about.php';">&times;</button>
        <div class="title">
            <h2><?php echo $name; ?>'s IT Varsity Certificate</h2>
        </div>

        <div class="certificate-container">
            <?php
            $validExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
            $filePath = "";

            // Check for the file with any valid extension based on the name
            foreach ($validExtensions as $ext) {
                $potentialPath = "./Cert/" . $name . ".$ext"; // Use the exact name from the query parameter
                if (file_exists($potentialPath)) {
                    $filePath = $potentialPath;
                    break;
                }
            }

            if ($filePath) {
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "<img src='$filePath' alt='Certificate of $name' style='width:100%; height:auto;' />";
                } else {
                    echo "<embed src='$filePath' type='application/pdf' width='100%' height='600px' />";
                }
            } else {
                echo "<p>No certificate available for $name.</p>";
            }
            ?>
        </div>

        <footer>
            <p>© 2025 Woolworths. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>