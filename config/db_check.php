<?php
// Check if columns exist in users table
$check_query = "DESCRIBE users";
$result = $pdo->query($check_query);
$columns = $result->fetchAll(PDO::FETCH_COLUMN);

// Add new columns if they don't exist
$pdo->exec("ALTER TABLE users 
    ADD COLUMN IF NOT EXISTS phone VARCHAR(20),
    ADD COLUMN IF NOT EXISTS company VARCHAR(100),
    ADD COLUMN IF NOT EXISTS address TEXT,
    ADD COLUMN IF NOT EXISTS website VARCHAR(255)
");
?>
