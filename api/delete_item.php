<?php
require_once '../config/db.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $itemId = $data['id'];

    // First, check if the item exists
    $checkStmt = $pdo->prepare("SELECT id FROM items WHERE id = ?");
    $checkStmt->execute([$itemId]);
    
    if (!$checkStmt->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Item not found']);
        exit;
    }

    // Delete from inventory_logs first due to foreign key constraint
    $logStmt = $pdo->prepare("DELETE FROM inventory_logs WHERE item_id = ?");
    $logStmt->execute([$itemId]);

    // Then delete the item
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $result = $stmt->execute([$itemId]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete item']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
