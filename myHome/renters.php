<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "FlavianLeonar2003$";
$dbname = "myhome";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current row index from the query string, default to the first row
$currentRow = isset($_GET['row']) ? intval($_GET['row']) : 1;

// Fetch the total number of rows in the landlords table
$totalRowsQuery = "SELECT COUNT(*) as count FROM landlords";
$totalRowsResult = $conn->query($totalRowsQuery);
$totalRows = $totalRowsResult->fetch_assoc()['count'];

// Ensure the current row index is within valid range
if ($currentRow < 1) {
    $currentRow = 1;
} elseif ($currentRow > $totalRows) {
    $currentRow = $totalRows;
}

// Fetch the landlord data for the current row
$sql = "SELECT landlord_id, landlord_name, user_id, apartment_name, apartment_amount, comments, property_video, property_image 
        FROM landlords LIMIT 1 OFFSET " . ($currentRow - 1);
$result = $conn->query($sql);

// Initialize variables to hold landlord data
$landlordName = $apartmentName = $comments = $propertyVideo = $apartmentAmount = $propertyImage = '';

if ($result->num_rows > 0) {
    // Fetch the current landlord's data
    $row = $result->fetch_assoc();
    $landlordName = htmlspecialchars($row['landlord_name']);
    $apartmentName = htmlspecialchars($row['apartment_name']);
    $comments = htmlspecialchars($row['comments']);
    $propertyVideo = htmlspecialchars($row['property_video']);
    $apartmentAmount = htmlspecialchars($row['apartment_amount']);
    $propertyImage = htmlspecialchars($row['property_image']);
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
        /* Background Animation */
        @keyframes backgroundAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background: linear-gradient(-45deg, #42a5f5, #ab47bc, #ff7043, #66bb6a);
            background-size: 400% 400%;
            animation: backgroundAnimation 15s ease infinite;
            min-height: 100vh;
            padding: 20px 0;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px 0;
            margin-bottom: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex; /* Use flexbox for layout */
            justify-content: space-between; /* Space between title and buttons */
            align-items: center; /* Center items vertically */
        }

        .header-title {
            font-size: 2rem;
            font-weight: bold;
            color: #42a5f5; /* Color for the title */
            margin-left: 20px; /* Add some left margin */
        }

        .header-btn {
            background: linear-gradient(45deg, #42a5f5, #ab47bc);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            margin: 0 10px;
            display: inline -block;
        }

        .header-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
            text-decoration: none;
        }

        .header-btn.logout {
            background: linear-gradient(45deg, #ff7043, #ff5252);
        }

        /* Container Animation */
        .animated-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .animated-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        /* Title Animation */
        .animated-title {
            font-size: 2.5rem;
            background: linear-gradient(45deg, #42a5f5, #ab47bc);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: titleGradient 5s ease infinite;
        }

        @keyframes titleGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Price Animation */
        .price-animation {
            font-size: 1.8rem;
            font-weight: bold;
            opacity: 0;
            animation: fadeInUp 1s forwards;
            color: #ff6b6b;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Media Container Styles */
        .media-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin: 30px 0;
        }

        .media-box {
            flex: 1;
            min-width: 300px;
            height: 300px;
            overflow: hidden;
            border-radius: 15px;
            position: relative;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .media-box:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .media-box img,
        .media-box video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        /* Comments Section Animation */
        .comments-section {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            color: white;
            opacity: 0;
            animation: slideIn 1s forwards;
            animation-delay: 0.5s;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Navigation Buttons Animation */
        .nav-buttons {
            margin-top: 30px;
            text-align: center;
        }

        .btn-animated {
            background: linear-gradient(45deg, #42a5f5, #ab47bc);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: bold;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 0 10px;
        }

        .btn-animated:hover:not(.disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-animated.disabled {
            opacity: 0.6;
            cursor: not-allowed;
 }

        /* Landlord Info Animation */
        .landlord-info {
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            background: white;
            opacity: 0;
            animation: fadeIn 1s forwards;
	}
	.logo {
        width: 50px; /* Adjust width as needed */
        height: auto;
        margin-left: 20px; /* Adjust margin as needed */
    }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="container">
        <div class="header">
	    <img src="/static/home.png" alt="myHome Logo" style="width: 50px; height: auto; margin-left: 20px;">
            <h1 class="header-title">MyHome</h1>
            <div class="d-flex justify-content-end align-items-center">
                <a href="landlords2.php" class="header-btn">
                    <i class="fas fa-exchange-alt"></i> Switch to Landlord
                </a>
                <a href="logout.php" class="header-btn logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="animated-container">
            <h1 class="animated-title mb-4"><?php echo $apartmentName; ?></h1>
            
            <div class="landlord-info">
                <h3><i class="fas fa-user-circle"></i> <?php echo $landlordName; ?></h3>
                <div class="price-animation mt-3">$<?php echo $apartmentAmount; ?></div>
            </div>

            <div class="comments-section">
                <h4><i class="fas fa-comments"></i> About this Property</h4>
                <p><?php echo $comments; ?></p>
            </div>
            
            <div class="media-container">
                <div class="media-box">
                    <?php if (!empty($propertyImage)): ?>
                        <img src="<?php echo $propertyImage; ?>" alt="Property Image">
                    <?php else: ?>
                        <div class="no-media">No image available for this property.</div>
                    <?php endif; ?>
                </div>

                <div class="media-box">
                    <?php if (!empty($propertyVideo)): ?>
                        <video controls>
                            <source src="<?php echo $propertyVideo; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php else: ?>
                        <div class="no-media">No video available for this property.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="nav-buttons">
                <a href="?row=<?php echo max($currentRow - 1, 1); ?>" 
                   class="btn-animated <?php echo $currentRow <= 1 ? 'disabled' : ''; ?>">
                    <i class="fas fa-chevron-left"></i> Previous
                </a>
                <a href="?row=<?php echo min($currentRow + 1, $totalRows); ?>" 
                   class="btn-animated <?php echo $currentRow >= $totalRows ? 'disabled' : ''; ?>">
                    Next <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
