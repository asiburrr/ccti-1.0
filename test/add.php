<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "ccti_1");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Increase memory limit and execution time for larger files
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);

// Enhanced upload with validation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $image = $_FILES["image"];
    
    // Check if file uploaded successfully
    if ($image['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $image['error']);
    }
    
    // Validate file
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 20 * 1024 * 1024; // Increased to 20MB
    
    if (!in_array($image['type'], $allowedTypes)) {
        die("Invalid image type. Only JPEG, PNG, and GIF are allowed.");
    }
    if ($image['size'] > $maxSize) {
        die("Image too large. Maximum size is 20MB.");
    }
    
    // Get image data
    $imageData = file_get_contents($image["tmp_name"]);
    if ($imageData === false) {
        die("Failed to read image file");
    }
    
    // Use prepared statement with proper binding for binary data
    $stmt = $conn->prepare("INSERT INTO images (image_name, image_data, image_type) VALUES (?, ?, ?)");
    $null = NULL;  // Placeholder for blob
    $stmt->bind_param("sbs", $image["name"], $null, $image["type"]);
    $stmt->send_long_data(1, $imageData);  // Send binary data separately
    
    if ($stmt->execute()) {
        echo "Image stored successfully with original quality";
    } else {
        echo "Error storing image: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Store Image in Database</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/jpeg,image/png,image/gif" required>
        <input type="submit" value="Upload Image">
    </form>
</body>
</html>