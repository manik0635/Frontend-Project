<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code - Inventory Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/scan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add this script in the head -->
    <script>
        function videoError(error) {
            console.error('Video failed to load:', error);
            alert('Video failed to load. Please check if the video file exists.');
        }
    </script>
</head>
<body>
    <?php include 'includes/navigation.php'; ?>
    
    <main class="scan-container">
        <div class="scanner-section">
            <h2><i class="fas fa-qrcode"></i> Scan QR Code</h2>
            <div class="scanner-wrapper">
                <div id="reader"></div>
                <div class="scan-frame"></div>
            </div>
            <button id="demoVideoBtn" class="btn secondary">
                <i class="fas fa-play-circle"></i> Watch Demo Video
            </button>
            <div id="result"></div>
        </div>
        
        <div class="scan-history">
            <div class="history-header">
                <h3><i class="fas fa-history"></i> Recent Scans</h3>
                <div class="history-stats">
                    <i class="fas fa-chart-line"></i>
                    Today: <span id="todayCount">0</span> scans
                </div>
            </div>
            <div class="history-list">
                <!-- This will be populated by JavaScript -->
            </div>
        </div>
    </main>

    <!-- Video Modal -->
    <div id="videoModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3>How to Scan QR Codes</h3>
            <div class="video-container">
                <video id="demoVideo" controls>
                    <source src="videos/demo.mp4" type="video/mp4" onerror="videoError(this)">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script src="js/scan.js"></script>
</body>
</html>
