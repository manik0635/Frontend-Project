<?php
require_once 'config/db.php';

try {
    // Add new columns to users table if they don't exist
    $pdo->exec("
        ALTER TABLE users
        ADD COLUMN IF NOT EXISTS phone VARCHAR(20),
        ADD COLUMN IF NOT EXISTS company VARCHAR(100),
        ADD COLUMN IF NOT EXISTS address TEXT,
        ADD COLUMN IF NOT EXISTS website VARCHAR(255)
    ");
    
    echo "Users table updated successfully";

} catch(PDOException $e) {
    echo "Error updating table: " . $e->getMessage();
}
 