<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code - Inventory Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/generate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Include the same navigation as index.php -->
    
    <main class="generate-container">
        <h2>Generate QR Code</h2>
        <div class="form-container">
            <form id="generateQRForm">
                <div class="form-group">
                    <label for="itemName">Item Name</label>
                    <input type="text" id="itemName" name="itemName" required>
                </div>
                
                <div class="form-group">
                    <label for="itemCategory">Category</label>
                    <select id="itemCategory" name="itemCategory" required>
                        <option value="">Select Category</option>
                        <option value="electronics">Electronics</option>
                        <option value="furniture">Furniture</option>
                        <option value="clothing">Clothing</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" required min="1">
                </div>
                
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" required step="0.01">
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn primary">Generate QR Code</button>
                </div>
            </form>
        </div>
        
        <div id="qrResult" class="qr-result">
            <!-- QR code will be displayed here -->
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="js/generate.js"></script>
</body>
</html>
