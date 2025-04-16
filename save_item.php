<?php
require_once 'config/db.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    // Get and validate input
    $input = file_get_contents('php://input');
    if (!$input) {
        throw new Exception('No input received');
    }

    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data');
    }

    // Validate required fields
    if (empty($data['id']) || empty($data['itemName']) || 
        empty($data['itemCategory']) || !isset($data['quantity']) || 
        !isset($data['price'])) {
        throw new Exception('Missing required fields');
    }

    // Start transaction
    $pdo->beginTransaction();

    // Check if item already exists
    $checkStmt = $pdo->prepare("SELECT id FROM items WHERE id = ?");
    $checkStmt->execute([$data['id']]);
    if ($checkStmt->fetch()) {
        throw new Exception('Item with this ID already exists');
    }

    // Insert new item
    $stmt = $pdo->prepare("
        INSERT INTO items (id, name, category, quantity, price) 
        VALUES (?, ?, ?, ?, ?)
    ");

    $result = $stmt->execute([
        $data['id'],
        $data['itemName'],
        $data['itemCategory'],
        $data['quantity'],
        $data['price']
    ]);

    if (!$result) {
        throw new Exception('Failed to save item');
    }

    // Create log entry
    $logStmt = $pdo->prepare("
        INSERT INTO inventory_logs (item_id, action, quantity_change) 
        VALUES (?, 'create', ?)
    ");

    $logResult = $logStmt->execute([
        $data['id'],
        $data['quantity']
    ]);

    if (!$logResult) {
        throw new Exception('Failed to create log entry');
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Item saved successfully'
    ]);

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log('Save item error: ' . $e->getMessage());
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
