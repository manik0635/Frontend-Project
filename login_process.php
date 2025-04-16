<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validation
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: login.php");
        exit();
    }

    try {
        // Check if user exists (using username or email)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username/email or password";
            header("Location: login.php");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Login failed. Please try again.";
        header("Location: login.php");
        exit();
    }
}