<?php
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS qr_inventory";
    $pdo->exec($sql);
    echo "Database created successfully";
    
} catch(PDOException $e) {
    echo "Error creating database: " . $e->getMessage();
}