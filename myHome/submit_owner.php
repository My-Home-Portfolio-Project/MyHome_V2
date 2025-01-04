?php
// Database connection
$servername = "localhost"; // Change if necessary
$username = "your_username"; // Your database username
$password = "your_password"; // Your database password
$dbname = "myhome"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = $_POST['user_id']; // Assuming you have a hidden input for user_id
    $landlord_name = $_POST['name'];
    $apartment_name = $_POST['apartmentname'];
    $apartment_amount = $_POST['amount'];
    $comments = $_POST['ownercomments'];

    // Handle video upload
    $video_path = '';
    if (isset($_FILES['propertyVideos']) && $_FILES['propertyVideos']['error'][0] == UPLOAD_ERR_OK) {
        $video_dir = 'uploads/videos/'; // Directory to store videos
        foreach ($_FILES['propertyVideos']['tmp_name'] as $key => $tmp_name) {
            $video_name = basename($_FILES['propertyVideos']['name'][$key]);
            $video_target = $video_dir . uniqid() . '-' . $video_name;
            if (move_uploaded_file($tmp_name, $video_target)) {
                $video_path .= $video_target . ';'; // Store multiple video paths
            }
        }
    }

    // Handle image upload
    $image_path = '';
    if (isset($_FILES['propertyPictures']) && $_FILES['propertyPictures']['error'][0] == UPLOAD_ERR_OK) {
        $image_dir = 'uploads/images/'; // Directory to store images
        foreach ($_FILES['propertyPictures']['tmp_name'] as $key => $tmp_name) {
            $image_name = basename($_FILES['propertyPictures']['name'][$key]);
            $image_target = $image_dir . uniqid() . '-' . $image_name;
            if (move_uploaded_file($tmp_name, $image_target)) {
                $image_path .= $image_target . ';'; // Store multiple image paths
            }
        }
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO landlords (user_id, landlord_name, apartment_name, apartment_amount, comments, property_video, property_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississs", $user_id, $landlord_name, $apartment_name, $apartment_amount, $comments, $video_path, $image_path);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
