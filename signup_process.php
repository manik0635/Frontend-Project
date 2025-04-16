<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['name']);

    // Debug logging
    error_log("Signup attempt - Username: $username, Email: $email, Name: $full_name");

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($full_name)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: signup.php");
        exit();
    }

    // Password match validation
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: signup.php");
        exit();
    }

    // Password strength validation
    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long";
        header("Location: signup.php");
        exit();
    }

    try {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Username already exists";
            header("Location: signup.php");
            exit();
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Email already exists";
            header("Location: signup.php");
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$username, $email, $hashed_password, $full_name]);

        if ($result) {
            $_SESSION['success'] = "Account created successfully! Please login.";
            header("Location: login.php");
            exit();
        } else {
            error_log("Database insert failed without throwing exception");
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: signup.php");
            exit();
        }

    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        $_SESSION['error'] = "Registration failed: " . $e->getMessage();
        header("Location: signup.php");
        exit();
    }
}
