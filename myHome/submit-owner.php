<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Update with your MySQL username
$password = "FlavianLeonar2003$"; // Update with your MySQL password
$dbname = "myhome"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $landlord_name = $conn->real_escape_string($_POST['name']);
    $apartment_name = $conn->real_escape_string($_POST['apartmentname']);
    $apartment_amount = (int) $_POST['amount'];
    $comments = $conn->real_escape_string($_POST['ownercomments']);
    $user_id = 1; // Replace with the actual user_id (e.g., from session)

    // File upload handling
    $property_video_path = null;
    $property_image_path = null;

    // Upload video files
    if (isset($_FILES['propertyVideos']) && $_FILES['propertyVideos']['error'][0] == UPLOAD_ERR_OK) {
        $video_dir = "uploads/videos/";
        if (!is_dir($video_dir)) {
            mkdir($video_dir, 0777, true);
        }
        $video_name = time() . "_" . basename($_FILES['propertyVideos']['name'][0]);
        $video_path = $video_dir . $video_name;
        if (move_uploaded_file($_FILES['propertyVideos']['tmp_name'][0], $video_path)) {
            $property_video_path = $video_path;
        }
    }

    // Upload image files
    if (isset($_FILES['propertyPictures']) && $_FILES['propertyPictures']['error'][0] == UPLOAD_ERR_OK) {
        $image_dir = "uploads/images/";
        if (!is_dir($image_dir)) {
            mkdir($image_dir, 0777, true);
        }
        $image_name = time() . "_" . basename($_FILES['propertyPictures']['name'][0]);
        $image_path = $image_dir . $image_name;
        if (move_uploaded_file($_FILES['propertyPictures']['tmp_name'][0], $image_path)) {
            $property_image_path = $image_path;
        }
    }

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO landlords (user_id, landlord_name, apartment_name, apartment_amount, comments, property_video, property_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississs", $user_id, $landlord_name, $apartment_name, $apartment_amount, $comments, $property_video_path, $property_image_path);

    if ($stmt->execute()) {
        echo "Data successfully inserted into the database.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

