<?php
// Database connection
$servername = "localhost"; // Change if your database server is different
$username = "your_username"; // Replace with your database username
$password = "your_password"; // Replace with your database password
$dbname = "myHome"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch landlords from the database
$sql = "SELECT landlord_id, landlord_name, user_id, apartment_name, apartment_amount, comments, property_video, property_image FROM landlords";
$result = $conn->query($sql);

// Initialize variables to hold landlord's name, apartment name, comments, and video
$landlordName = '';
$apartmentName = '';
$comments = '';
$propertyVideo = '';
$apartmentAmount = '';
$propertyImage = '';

if ($result->num_rows > 0) {
    // Fetch the first landlord's data
    $row = $result->fetch_assoc();
    $landlordName = htmlspecialchars($row['landlord_name']); // Store the landlord's name
    $apartmentName = htmlspecialchars($row['apartment_name']); // Store the apartment name
    $comments = htmlspecialchars($row['comments']); // Store the comments
    $propertyVideo = htmlspecialchars($row['property_video']); // Store the property video
    $apartmentAmount = htmlspecialchars($row['apartment_amount']); // Store the apartment amount
    $propertyImage = htmlspecialchars($row['property_image']); // Store the property image
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHome - Renters</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Your existing CSS styles */
        @keyframes backgroundAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background: linear-gradient(-45deg, #42a5f5, #ab47bc, #ff7043, #66bb6a);
            background-size: 400% 400%;
            animation: backgroundAnimation 15s ease infinite;
        }

        .navbar, footer {
            background-color: rgba(248, 249, 250, 0.8) !important;
        }

        .animated-border {
            position: relative;
            border: 3px solid transparent;
            border-radius: 10px;
            background-clip: padding-box, border-box;
            background-origin: padding-box, border-box;
        }

        .animated-border::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45aaf2, #ff6b6b);
            background-size: 400% 400%;
            animation: backgroundAnimation 10s ease infinite;
            border-radius: 13px;
            z-index: -1;
        }

        .animated-footer {
            background: linear-gradient(-45deg, #42a5f5, #ab47bc, #ff7043, #66bb6a);
            background-size: 400% 400%;
            animation: backgroundAnimation 15s ease infinite;
            color: white;
        }

        .animated-footer p {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
        }

        /* Set dimensions for video and image */
        .media-box {
            width: 100%;
            height: 300px; /* Set a fixed height for both video and image */
            overflow: hidden;
            position: relative;
        }

        .media-box video,
        ```php
        .media-box img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the video/image covers the box without distortion */
        }

        .price-animation {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff5722; /* Highlight the price */
            animation: pulse 1s infinite; /* Add a pulse animation */
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="logo.png" alt="Logo"> MyHome
        </a>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6 mb-4">
                        <div class="bg-white shadow-md rounded-lg p-6 animated-border">
                            <h2 class="text-xl font-semibold mb-4"><?php echo htmlspecialchars($row['landlord_name']); ?></h2>
                            <p>Landlord ID: <?php echo htmlspecialchars($row['landlord_id']); ?></p>
                            <p>Apartment Name: <?php echo htmlspecialchars($row['apartment_name']); ?></p>
                            <p>Apartment Amount: $<?php echo htmlspecialchars($row['apartment_amount']); ?></p>
                            <p>Comments: <?php echo htmlspecialchars($row['comments']); ?></p>
                            <div class="media-box">
                                <?php if (!empty($row['property_video'])): ?>
                                    <video controls>
                                        <source src="<?php echo htmlspecialchars($row['property_video']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php endif; ?>
                                <?php if (!empty($row['property_image'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['property_image']); ?>" alt="Property Image" />
                                <?php else: ?>
                                    <p>No image available for this property.</p>
                                <?php endif; ?>
                            </div>
                            <p class="price-animation">$<?php echo htmlspecialchars($row['apartment_amount']); ?></p> <!-- Display apartment amount with animation -->
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No landlords found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="animated-footer text-center mt-5">
        <p>&copy; 2023 MyHome. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
``` ```php
<?php
// Database connection
$servername = "localhost"; // Change if your database server is different
$username = "your_username"; // Replace with your database username
$password = "your_password"; // Replace with your database password
$dbname = "myHome"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch landlords from the database
$sql = "SELECT landlord_id, landlord_name, user_id, apartment_name, apartment_amount, comments, property_video, property_image FROM landlords";
$result = $conn->query($sql);

// Initialize variables to hold landlord's name, apartment name, comments, and video
$landlordName = '';
$apartmentName = '';
$comments = '';
$propertyVideo = '';
$apartmentAmount = '';
$propertyImage = '';

if ($result->num_rows > 0) {
    // Fetch the first landlord's data
    $row = $result->fetch_assoc();
    $landlordName = htmlspecialchars($row['landlord_name']); // Store the landlord's name
    $apartmentName = htmlspecialchars($row['apartment_name']); // Store the apartment name
    $comments = htmlspecialchars($row['comments']); // Store the comments
    $propertyVideo = htmlspecialchars($row['property_video']); // Store the property video
    $apartmentAmount = htmlspecialchars($row['apartment_amount']); // Store the apartment amount
    $propertyImage = htmlspecialchars($row['property_image']); // Store the property image
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHome - Renters</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Your existing CSS styles */
        @keyframes backgroundAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background: linear-gradient(-45deg, #42a5f5, #ab47bc, #ff7043, #66bb6a);
            background-size: 400% 400%;
            animation: backgroundAnimation 15s ease infinite;
        }

        .navbar, footer {
            background-color: rgba(248, 249, 250, 0.8) !important;
        }

        .animated-border {
            position: relative;
            border: 3px solid transparent;
            border-radius: 10px;
            background-clip: padding-box, border-box;
            background-origin: padding-box, border-box;
        }

        .animated-border::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45aaf2, #ff6b6b);
            background-size: 400% 400%;
            animation: backgroundAnimation 10s ease infinite;
            border-radius: 13px;
            z-index: -1;
        }

        .animated-footer {
            background: linear-gradient(-45deg, #42a5f5, #ab47bc, #ff7043, #66bb6a);
            background-size: 400% 400%;
            animation: backgroundAnimation 15s ease infinite;
            color: white;
        }

        .animated-footer p {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
        }

        /* Set dimensions for video and image */
        .media-box {
            width: 100%;
            height: 300px; /* Set a fixed height for both video and image */
            overflow: hidden;
            position: relative;
        }

        .media-box video,
        .media-box img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the video/image covers the box without distortion */
        }

        .price-animation {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ff5722; /* Highlight the price */
            animation: pulse 1s infinite; /* Add a pulse animation */
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="logo.png" alt="Logo"> MyHome
        </a>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6 mb-4">
                        <div class="bg-white shadow-md rounded-lg p-6 animated-border">
                            <h2 class="text-xl font-semibold mb-4"><?php echo htmlspecialchars($row['landlord_name']); ?></h2>
                            <p>Landlord ID: <?php echo htmlspecialchars($row['landlord_id']); ?></p>
                            <p>Apartment Name: <?php echo htmlspecialchars($row['apartment_name']); ?></p>
                            <p>Apartment Amount: $<?php echo htmlspecialchars($row['apartment_amount']); ?></p>
                            <p>Comments: <?php echo htmlspecialchars($row['comments']); ?></p>
                            <div class="media-box">
                                <?php if (!empty($row['property_video'])): ?>
                                    <video controls>
                                        <source src="<?php echo htmlspecialchars($row['property_video']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php endif; ?>
                                <?php if (!empty($row['property_image'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['property_image']); ?>" alt="Property Image" />
                                <?php else: ?>
                                    <p>No image available for this property.</p>
                                <?php endif; ?>
                            </div>
                            <p class="price-animation">$<?php echo htmlspecialchars($row['apartment_amount']); ?></p> <!-- Display apartment amount with animation -->
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No landlords found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="animated-footer text-center mt-5">
        <p>&copy; 2023 MyHome. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
