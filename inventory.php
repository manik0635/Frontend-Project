<?php
session_start();
require_once 'config/db.php';

// Fetch inventory stats with total revenue instead of out of stock
$stmt = $pdo->query("SELECT 
    COUNT(*) as total_items,
    SUM(quantity) as total_quantity,
    COUNT(CASE WHEN quantity < 10 THEN 1 END) as low_stock,
    SUM(quantity * price) as total_revenue
FROM items");
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch inventory items
$stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - QR Inventory Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/inventory.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/navigation.php'; ?>

    <main class="inventory-container">
        <div class="inventory-header">
            <h2><i class="fas fa-boxes"></i> Inventory Management</h2>
            <a href="generate.php" class="btn primary">
                <i class="fas fa-plus"></i> Add New Item
            </a>
        </div>

        <div class="inventory-stats">
            <div class="stat-card">
                <h3>Total Items</h3>
                <div class="value"><?php echo $stats['total_items']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Quantity</h3>
                <div class="value"><?php echo $stats['total_quantity']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Low Stock Items</h3>
                <div class="value"><?php echo $stats['low_stock']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="value">$<?php echo number_format($stats['total_revenue'], 2); ?></div>
            </div>
        </div>

        <div class="search-container">
            <input type="text" id="searchInventory" placeholder="Search items...">
            <select class="filter-dropdown">
                <option value="">All Categories</option>
                <option value="electronics">Electronics</option>
                <option value="furniture">Furniture</option>
                <option value="clothing">Clothing</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="inventory-table-container">
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr data-item-id="<?php echo htmlspecialchars($item['id']); ?>">
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['category']); ?></td>
                            <td><?php echo (int)$item['quantity']; ?></td>
                            <td>$<?php echo number_format((float)$item['price'], 2); ?></td>
                            <td>
                                <?php
                                $statusClass = (int)$item['quantity'] === 0 ? 'out-of-stock' : 
                                             ((int)$item['quantity'] < 10 ? 'low-stock' : 'in-stock');
                                $statusText = (int)$item['quantity'] === 0 ? 'Out of Stock' : 
                                             ((int)$item['quantity'] < 10 ? 'Low Stock' : 'In Stock');
                                ?>
                                <span class="status-badge <?php echo $statusClass; ?>">
                                    <?php echo $statusText; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon" onclick="viewQR('<?php echo htmlspecialchars($item['id']); ?>')">
                                        <i class="fas fa-qrcode"></i>
                                    </button>
                                    <button class="btn-icon" onclick="editItem('<?php echo htmlspecialchars($item['id']); ?>')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon" onclick="deleteItem('<?php echo htmlspecialchars($item['id']); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <button>&laquo;</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button>&raquo;</button>
        </div>
    </main>

    <script src="js/inventory.js"></script>
</body>
</html>
