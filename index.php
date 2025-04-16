<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Inventory Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav>
        <div class="logo">
            <?php
            session_start(); // Make sure this is at the very top of the file
            $profileLink = isset($_SESSION['user_id']) ? 'profile.php' : 'index.php';
            ?>
            <a href="<?php echo $profileLink; ?>">
                <img src="images/2.jpg" alt="Logo">
                <span>QR Inventory</span>
            </a>
        </div>
        <ul>
            <li><a href="./index.php" class="active"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="./scan.php"><i class="fas fa-qrcode"></i> Scan QR</a></li>
            <li><a href="./generate.php"><i class="fas fa-plus-circle"></i> Generate QR</a></li>
            <li><a href="./inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
            <li><a href="./reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li class="auth-buttons">
                <a href="./login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="./signup.php" class="signup-btn"><i class="fas fa-user-plus"></i> Sign Up</a>
            </li>
        </ul>
    </nav>

    <main>
        <section class="hero">
            <h1>Welcome to QR Inventory Management System</h1>
            <p>Efficiently manage your inventory with QR code technology</p>
            <div class="cta-buttons">
                <a href="scan.php" class="btn primary">Scan QR Code</a>
                <a href="generate.php" class="btn secondary">Generate QR Code</a>
            </div>
        </section>

        <section class="features">
            <h2>Key Features</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <i class="fas fa-qrcode"></i>
                    <h3>QR Scanning</h3>
                    <p>Quickly scan and track inventory items using any device with a camera. Real-time updates and instant access to item details.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-tags"></i>
                    <h3>QR Generation</h3>
                    <p>Create custom QR codes for new items with unique identifiers. Include detailed product information and specifications.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-chart-line"></i>
                    <h3>Real-time Tracking</h3>
                    <p>Monitor inventory levels, stock movements, and item locations in real-time. Get instant alerts for low stock items.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-file-alt"></i>
                    <h3>Detailed Reports</h3>
                    <p>Generate comprehensive inventory reports with advanced analytics, trends, and forecasting capabilities.</p>
                </div>
            </div>
        </section>

        <section class="benefits">
            <h2>Why Choose Our System?</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <i class="fas fa-bolt"></i>
                    <h3>Fast & Efficient</h3>
                    <p>Save time with quick QR scanning and automated inventory updates</p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-mobile-alt"></i>
                    <h3>Mobile Friendly</h3>
                    <p>Access your inventory system from any device, anywhere</p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Secure & Reliable</h3>
                    <p>Enterprise-grade security with data encryption and regular backups</p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-chart-pie"></i>
                    <h3>Advanced Analytics</h3>
                    <p>Make data-driven decisions with comprehensive analytics</p>
                </div>
            </div>
        </section>

        <section class="how-it-works">
            <h2>How It Works</h2>
            <div class="steps-container">
                <div class="step">
                    <div class="step-number">1</div>
                    <i class="fas fa-plus-circle"></i>
                    <h3>Add Items</h3>
                    <p>Create new inventory items and generate unique QR codes</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <i class="fas fa-qrcode"></i>
                    <h3>Scan & Track</h3>
                    <p>Use any device to scan QR codes and update inventory</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <i class="fas fa-chart-bar"></i>
                    <h3>Monitor & Analyze</h3>
                    <p>Track inventory levels and generate insights</p>
                </div>
            </div>
        </section>

        <section class="system-statistics">
            <h2>System Statistics</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-box"></i>
                    <div class="stat-number">10,000+</div>
                    <div class="stat-label">Total Items</div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Active Users</div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-sync"></i>
                    <div class="stat-number">2,500+</div>
                    <div class="stat-label">Daily Scans</div>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-building"></i>
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Companies</div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>Ready to Get Started?</h2>
            <p>Join thousands of businesses managing their inventory efficiently</p>
            <div class="cta-buttons">
                <a href="signup.php" class="btn cta-primary">
                    <i class="fas fa-user-plus"></i> Create Free Account
                </a>
                <a href="scan.php" class="btn cta-secondary">
                    <i class="fas fa-qrcode"></i> Try Demo
                </a>
                <a href="contact.php" class="btn cta-tertiary">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 QR Inventory Management System. All rights reserved.</p>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
