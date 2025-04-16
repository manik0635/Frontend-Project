<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - QR Inventory Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="contact-container">
        <h2>Contact Us</h2>
        <p class="subtitle">Get in touch with our team for any inquiries or support</p>

        <div class="contact-grid">
            <div class="contact-info">
                <h3>Contact Information</h3>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="info-content">
                        <h4>Office Location</h4>
                        <p>123 Tech Street, Silicon Valley<br>California, USA 94025</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div class="info-content">
                        <h4>Phone Number</h4>
                        <p>+919805301107<br>+919780802939 </p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div class="info-content">
                        <h4>Email Address</h4>
                        <p>support@qrinventory.com<br>info@qrinventory.com</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div class="info-content">
                        <h4>Business Hours</h4>
                        <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM</p>
                    </div>
                </div>

                <div class="social-links">
                    <h4>Follow Us</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="https://x.com/SuryadevRana47"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/in/suryadev-rana-878a19272/"><i class="fab fa-linkedin"></i></a>
                        <a href="https://www.instagram.com/suryadev_rana69/"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h3>Send Us a Message</h3>
                <form id="contactForm" action="process_contact.php" method="POST">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            alert('Thank you for your message. We will get back to you soon!');
            this.reset();
        });
    </script>
</body>
</html>