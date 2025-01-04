<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "FlavianLeonar2003$"; // Replace with your password
$dbname = "myhome"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs
    $ownerName = htmlspecialchars($_POST['name']);
    $apartmentName = htmlspecialchars($_POST['apartmentname']);
    $amount = intval($_POST['amount']);
    $comments = htmlspecialchars($_POST['ownercomments']);

    // Directory paths for uploaded files
    $videoDir = "uploads/videos/";
    $imageDir = "uploads/images/";

    // Create directories if they don't exist
    if (!is_dir($videoDir)) {
        mkdir($videoDir, 0777, true);
    }
    if (!is_dir($imageDir)) {
        mkdir($imageDir, 0777, true);
    }

    $videoUrls = [];
    $imageUrls = [];

    // Process video files
    if (isset($_FILES['propertyVideos']) && !empty($_FILES['propertyVideos']['name'][0])) {
        foreach ($_FILES['propertyVideos']['tmp_name'] as $key => $tmpName) {
            $fileName = basename($_FILES['propertyVideos']['name'][$key]);
            $targetPath = $videoDir . $fileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $videoUrls[] = $targetPath;
            }
        }
    }

    // Process image files
    if (isset($_FILES['propertyPictures']) && !empty($_FILES['propertyPictures']['name'][0])) {
        foreach ($_FILES['propertyPictures']['tmp_name'] as $key => $tmpName) {
            $fileName = basename($_FILES['propertyPictures']['name'][$key]);
            $targetPath = $imageDir . $fileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $imageUrls[] = $targetPath;
            }
        }
    }

    // Convert URLs to JSON format for storage
    $videoUrlsJson = json_encode($videoUrls);
    $imageUrlsJson = json_encode($imageUrls);

    // Insert data into the landlords table
    $stmt = $conn->prepare("INSERT INTO landlords (landlord_name, apartment_name, apartment_amount, comments, property_video, property_image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $ownerName, $apartmentName, $amount, $comments, $videoUrlsJson, $imageUrlsJson);

    if ($stmt->execute()) {
        echo "Owner information and media files uploaded successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
