<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Add debug logging
        error_log('Received POST data: ' . print_r($_POST, true));

        // Sanitize inputs
        $fullName = filter_var($_POST['full_name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
        $website = filter_var($_POST['website'], FILTER_SANITIZE_URL);
        
        // Add debug logging
        error_log('Sanitized data: ' . json_encode([
            'fullName' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'address' => $address,
            'website' => $website,
            'user_id' => $_SESSION['user_id']
        ]));

        $stmt = $pdo->prepare("
            UPDATE users 
            SET full_name = ?, 
                email = ?, 
                phone = ?, 
                company = ?,
                address = ?,
                website = ?
            WHERE id = ?
        ");
        
        $result = $stmt->execute([
            $fullName,
            $email,
            $phone,
            $company,
            $address,
            $website,
            $_SESSION['user_id']
        ]);

        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } else {
            throw new Exception('Failed to update profile');
        }
    } catch (Exception $e) {
        error_log('Profile update error: ' . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false, 
            'message' => 'Failed to update profile: ' . $e->getMessage()
        ]);
    }
    exit();
}
