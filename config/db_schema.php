<?php
require_once 'db.php';

try {
    // Create items table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS items (
        id VARCHAR(255) PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        quantity INT NOT NULL DEFAULT 0,
        price DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Create inventory_logs table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS inventory_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        item_id VARCHAR(255) NOT NULL,
        action VARCHAR(50) NOT NULL,
        quantity_change INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (item_id) REFERENCES items(id)
    )");

    echo "Database schema updated successfully";
} catch (PDOException $e) {
    die("Database schema error: " . $e->getMessage());
}