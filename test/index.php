<?php
$conn = new mysqli("localhost", "root", "", "ccti_1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to resize image dynamically
function resizeImage($imageData, $imageType, $width, $height) {
    // Create image from binary data based on type
    switch ($imageType) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg("data://image/jpeg;base64," . base64_encode($imageData));
            break;
        case 'image/png':
            $source = imagecreatefrompng("data://image/png;base64," . base64_encode($imageData));
            break;
        case 'image/gif':
            $source = imagecreatefromgif("data://image/gif;base64," . base64_encode($imageData));
            break;
        default:
            return false;
    }

    if (!$source) {
        return false;
    }

    // Get original dimensions
    $origWidth = imagesx($source);
    $origHeight = imagesy($source);

    // Create new image with specified dimensions
    $resized = imagecreatetruecolor($width, $height);

    // Preserve transparency for PNG/GIF
    if ($imageType == 'image/png' || $imageType == 'image/gif') {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefill($resized, 0, 0, $transparent);
    }

    // Resize with high quality
    imagecopyresampled($resized, $source, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);

    // Capture output
    ob_start();
    switch ($imageType) {
        case 'image/jpeg':
            imagejpeg($resized, null, 90); // 90% quality
            break;
        case 'image/png':
            imagepng($resized, null, 9); // Max compression
            break;
        case 'image/gif':
            imagegif($resized);
            break;
    }
    $output = ob_get_clean();

    // Clean up
    imagedestroy($source);
    imagedestroy($resized);

    return $output;
}

// Handle image request
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $width = isset($_GET['w']) ? (int)$_GET['w'] : null;  // Null if not set
    $height = isset($_GET['h']) ? (int)$_GET['h'] : null; // Null if not set

    $stmt = $conn->prepare("SELECT image_data, image_type FROM images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        header("Content-type: " . $row["image_type"]);
        header("Content-Disposition: inline; filename=\"image\"");

        // Only resize if both width and height are specified and valid
        if ($width !== null && $height !== null && $width > 0 && $height > 0) {
            $resizedImage = resizeImage($row["image_data"], $row["image_type"], $width, $height);
            if ($resizedImage !== false) {
                echo $resizedImage;
            } else {
                echo $row["image_data"]; // Fallback to original if resize fails
            }
        } else {
            // Serve original image by default if no valid dimensions provided
            echo $row["image_data"];
        }
        exit;
    }
    $stmt->close();
}

// Display image list
$sql = "SELECT id, image_name FROM images";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Show 50x50 thumbnail and link to original
        echo "<p>";
        echo "<img src='?id={$row['id']}&w=50&h=50' alt='{$row['image_name']}'> ";
        echo "<a href='?id={$row['id']}'>{$row['image_name']} (Original)</a>";
        echo "</p>";
    }
} else {
    echo "No images found";
}

$conn->close();
?>