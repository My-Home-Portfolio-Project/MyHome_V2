<?php
session_start();
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
        @keyframes backgroundAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="#" class="navbar-brand">
            <img src="home.png" alt="MyHome Logo">
            MyHome
        </a>
<?php if (isset($_SESSION["user_id"])): ?>
<p> Congratulations you are logged in.</p>
<?php endif; ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="lansdlords2.html" class="btn btn-outline-primary mr-2">Be a Landlord</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid px-4 py-8">
        <!-- Renters Profile Section -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8 animated-border">
            <div class="d-flex align-items-center mb-6">
                <div class="w-24 h-24 rounded-full mr-4">
                    <img src="/api/placeholder/120/120" alt="Landlord's Image" class="w-20 h-20 rounded-circle">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-dark">Jane Doe</h1>
                    <p class="text-muted">Looking for a 2-bedroom apartment</p>
                </div>
            </div>

            <!-- Renter's Message -->
            <div class="bg-info text-white p-4 rounded-lg mb-6">
                <p>"I am searching for a cozy, pet-friendly apartment in the downtown area. Budget: $1,500/month."</p>
            </div>
        </div>

        <!-- Uploaded Content Sections -->
        <div class="row">
            <!-- Landlord's Video Preview -->
            <div class="col-md-6 mb-4">
                <div class="bg-white shadow-md rounded-lg p-6 animated-border">
                    <h2 class="text-xl font-semibold mb-4">Landlord's Property Video</h2>
                    <video controls class="w-100 rounded">
                        <source src="/path/to/landlord-property-video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <!-- Landlord's Image Preview -->
            <div class="col-md-6 mb-4">
                <div class="bg-white shadow-md rounded-lg p-6 animated-border">
                    <h2 class="text-xl font-semibold mb-4">Landlord's Property Images</h2>
                    <img src="/path/to/landlord-property-image.jpg" alt="Property Image" class="img-fluid rounded">
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="text-center mt-6">
            <button class="btn btn-outline-primary mr-2">
                << Previous
            </button>
            <button class="btn btn-outline-primary">
                Next >>
            </button>
        </div>
    </div>

    <footer class="text-center py-3 animated-footer">
        <p>&copy; 2024 MyHome Real Estate App</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
 
