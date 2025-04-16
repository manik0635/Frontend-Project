<?php
require_once 'config/db.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

try {
    // Decode QR data
    $qrData = json_decode($data['qrCode'], true);
    
    if (!isset($qrData['id'])) {
        throw new Exception('Invalid QR code');
    }

    // Start transaction
    $pdo->beginTransaction();

    // Get current item
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id = :id FOR UPDATE");
    $stmt->execute(['id' => $qrData['id']]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        throw new Exception('Item not found');
    }

    // Update quantity (assuming we're scanning items out)
    $newQuantity = $item['quantity'] - 1;
    if ($newQuantity < 0) {
        throw new Exception('Insufficient quantity');
    }

    // Update item
    $updateStmt = $pdo->prepare("UPDATE items SET quantity = :quantity WHERE id = :id");
    $updateStmt->execute([
        'quantity' => $newQuantity,
        'id' => $qrData['id']
    ]);

    // Log the action
    $logStmt = $pdo->prepare("INSERT INTO inventory_logs (item_id, action, quantity_change) 
                             VALUES (:item_id, 'scan_out', -1)");
    $logStmt->execute([
        'item_id' => $qrData['id']
    ]);

    $pdo->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
