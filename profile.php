<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch fresh user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Debug line - remove after testing
error_log('User data: ' . print_r($user, true));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - QR Inventory Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Keep the same navigation as other pages -->
    <?php include 'includes/nav.php'; ?>

    <main class="profile-container">
        <!-- Add navigation buttons container -->
        <div class="profile-nav-buttons">
            <div class="back-to-dashboard">
                <a href="index.php" class="btn secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            <div class="logout-button">
                <a href="logout.php" class="btn danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <div class="profile-header">
            <div class="profile-cover"></div>
            <div class="profile-avatar">
                <img src="<?php echo $user['avatar'] ?? 'images/1.jpeg'; ?>" alt="Profile Picture">
                <button class="edit-avatar" title="Change Profile Picture">
                    <i class="fas fa-camera"></i>
                </button>
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user['full_name']); ?></h1>
                <p class="username">@<?php echo htmlspecialchars($user['username']); ?></p>
            </div>
        </div>

        <div class="profile-content">
            <nav class="profile-nav">
                <button type="button" data-tab="overview" class="active">
                    <i class="fas fa-user"></i> Overview
                </button>
            </nav>

            <div class="profile-sections">
                <section id="overview" class="active">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <i class="fas fa-qrcode"></i>
                            <h3>QR Codes Generated</h3>
                            <div class="stat-number">150</div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-scanner"></i>
                            <h3>Items Scanned</h3>
                            <div class="stat-number">324</div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-boxes"></i>
                            <h3>Total Inventory</h3>
                            <div class="stat-number">487</div>
                        </div>
                    </div>

                    <div class="user-details">
                        <form id="contact-form"> <!-- Add form wrapper -->
                            <h3>Contact Information 
                                <button type="button" id="editContactBtn" class="edit-btn">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </h3>
                            <div class="details-grid">
                                <div class="detail-item">
                                    <i class="fas fa-user"></i>
                                    <div class="detail-content">
                                        <label>Full Name</label>
                                        <span class="display-value"><?php echo htmlspecialchars($user['full_name'] ?? 'Not set'); ?></span>
                                        <input type="text" class="edit-input hidden" name="full_name" 
                                               value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-envelope"></i>
                                    <div class="detail-content">
                                        <label>Email</label>
                                        <span class="display-value"><?php echo htmlspecialchars($user['email'] ?? 'Not set'); ?></span>
                                        <input type="email" class="edit-input hidden" name="email" 
                                               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-phone"></i>
                                    <div class="detail-content">
                                        <label>Phone</label>
                                        <span class="display-value"><?php echo htmlspecialchars($user['phone'] ?? 'Not set'); ?></span>
                                        <input type="tel" class="edit-input hidden" name="phone" 
                                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-building"></i>
                                    <div class="detail-content">
                                        <label>Company</label>
                                        <span class="display-value"><?php echo htmlspecialchars($user['company'] ?? 'Not set'); ?></span>
                                        <input type="text" class="edit-input hidden" name="company" 
                                               value="<?php echo htmlspecialchars($user['company'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div class="detail-content">
                                        <label>Address</label>
                                        <span class="display-value"><?php echo htmlspecialchars($user['address'] ?? 'Not set'); ?></span>
                                        <input type="text" class="edit-input hidden" name="address" 
                                               value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-globe"></i>
                                    <div class="detail-content">
                                        <label>Website</label>
                                        <span class="display-value"><?php echo htmlspecialchars($user['website'] ?? 'Not set'); ?></span>
                                        <input type="url" class="edit-input hidden" name="website" 
                                               value="<?php echo htmlspecialchars($user['website'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="edit-actions hidden">
                                <button type="button" id="saveContactBtn" class="btn primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                                <button type="button" id="cancelContactBtn" class="btn secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('profile-form');
        
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const formData = new FormData(this);
                const response = await fetch('update_profile.php', {
                    method: 'POST',
                    body: formData
                });
                
                if (response.ok) {
                    // Update the display immediately
                    document.getElementById('phone-display').textContent = 
                        formData.get('phone') || 'Not set';
                    document.getElementById('company-display').textContent = 
                        formData.get('company') || 'Not set';
                    
                    showNotification('Profile updated successfully!', 'success');
                } else {
                    showNotification('Failed to update profile', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('An error occurred', 'error');
            }
        });
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            ${message}
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    </script>
    <script src="js/profile.js"></script>
</body>
</html>
