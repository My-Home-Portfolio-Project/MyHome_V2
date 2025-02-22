<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyHome - Owner Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @keyframes backgroundAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: backgroundAnimation 15s ease infinite;
            transition: background 2s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .navbar, footer {
            background-color: rgba(248, 249, 250, 0.8) !important;
        }

        .navbar {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .navbar-brand {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
            animation-delay: 0.2s;
        }

        .navbar-nav {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
            animation-delay: 0.4s;
        }

        .navbar .btn {
            transition: transform 0.2s ease;
        }

        .navbar .btn:hover {
            transform: scale(1.05);
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-hover-pulse:hover {
            animation: pulse 1s infinite;
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
            z-index: -1;
            animation: gradientAnimation 15s ease infinite;
            border-radius: 13px;
        }

        .hover-glow:hover::before {
            animation: gradientAnimation 5s ease infinite;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .form-group label {
            font-weight: 600;
            color: #2d3748;
        }

        .btn-submit {
            background: #3B82F6;
            color: white;
            padding: 0.5rem 2rem;
        }

        .btn-submit:hover {
            background: #2563EB;
            color: white;
        }

        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #3B82F6;
            background: #f8fafc;
            animation: pulse 1s infinite;
        }

        .upload-icon {
            font-size: 2rem;
            color: #64748b;
            margin-bottom: 1rem;
        }

        .preview-area {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
            display: none;
        }

        .file-list {
            list-style: none;
            padding: 0;
        }

        .file-list li {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            background: white;
            margin-bottom: 0.5rem;
            border-radius: 4px;
        }

        .file-list i {
            margin-right: 0.5rem;
        }

        .animated-footer {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: backgroundAnimation 15s ease infinite;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .section-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="#" class="navbar-brand d-flex align-items-center">
            <img src="../static/home.png" alt="MyHome Logo" class="mr-2" style="height: 40px;">
            MyHome
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Switch to Tenant Button -->
                <li class="nav-item">
                    <a href="renters.php" class="btn btn-outline-primary mr-2">Switch to Tenant</a>
                </li>
                <!-- Logout Button -->
                <li class="nav-item">
                    <a href="index.php" class="btn btn-outline-danger">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="form-container animated-border hover-glow">
            <h2 class="mb-4 animate-fade-in">Owner Information</h2>
            <form id="ownerForm" action="/submit-owner.php" method="POST" enctype="multipart/form-data">
                <!-- Owner Information Section -->
                <div class="section-card delay-100">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Owner Name</label>
                                <input type="text" class="form-control" id="name" name="name" maxlength="40" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="apartmentname">Apartment Name</label>
                                <input type="text" class="form-control" id="apartmentname" name="apartmentname" maxlength="56">
                            </div>
                            
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ownercomments">Comments</label>
                                <textarea class="form-control" id="ownercomments" name="ownercomments" rows="7" maxlength="1000"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Upload Section -->
                <h3 class="mt-4 mb-3 animate-fade-in delay-200">Media Upload</h3>
                <div class="row">
                    <!-- Property Videos Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="section-card delay-300 animated-border hover-glow">
                            <div class="form-group">
                                <label>Property Videos</label>
                                <div class="upload-area animate-hover-pulse" id="videoUploadArea">
                                    <input type="file" id="propertyVideos" name="propertyVideos[]" accept="video/*" multiple class="d-none">
                                    <i class="fas fa-video upload-icon"></i>
                                    <p class="mb-0">Click to upload property videos</p>
                                    <small class="text-muted">Support for multiple videos</small>
                                </div>
                                <div class="preview-area" id="videoPreview">
                                    <h6>Selected Videos:</h6>
                                    <ul class="file-list" id="videoList"></ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Pictures Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="section-card delay-400 animated-border hover-glow">
                            <div class="form-group">
                                <label>Property Pictures</label>
                                <div class="upload-area animate-hover-pulse" id="pictureUploadArea">
                                    <input type="file" id="propertyPictures" name="propertyPictures[]" accept="image/*" multiple class="d-none">
                                    <i class="fas fa-images upload-icon"></i>
                                    <p class="mb-0">Click to upload property pictures</p>
                                    <small class="text-muted">Support for multiple images</small>
                                </div>
                                <div class="preview-area" id="picturePreview">
                                    <h6>Selected Pictures:</h6>
                                    <ul class="file-list" id="pictureList"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-submit animate-hover-pulse">Submit Owner Information</button>
            </form>
        </div>
    </div>

    <footer class="animated-footer">
        <p>&copy; 2024 MyHome Real Estate App</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script>
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function handleFiles(fileInput, listElement, previewArea) {
            const files = fileInput.files;
            const fileList = document.getElementById(listElement);
            const preview = document.getElementById(previewArea);
            
            fileList.innerHTML = '';
            
            if (files.length > 0) {
                preview.style.display = 'block';
                
                Array.from(files).forEach(file => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <i class="fas ${fileInput.accept.includes('video') ? 'fa-video' : 'fa-image'}"></i>
                        ${file.name} (${formatFileSize(file.size)})
                    `;
                    fileList.appendChild(li);
                });
            } else {
                preview.style.display = 'none';
            }
        }

        document.getElementById('videoUploadArea').addEventListener('click', () => {
            document.getElementById('propertyVideos').click();
        });

        document.getElementById('pictureUploadArea').addEventListener('click', () => {
            document.getElementById('propertyPictures').click();
        });

        document.getElementById('propertyVideos').addEventListener('change', function() {
            handleFiles(this, 'videoList', 'videoPreview');
        });

        document.getElementById('propertyPictures').addEventListener('change', function() {
            handleFiles(this, 'pictureList', 'picturePreview');
        });
    </script>
</body>
</html>
