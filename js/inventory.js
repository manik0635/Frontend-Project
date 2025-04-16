// Search functionality
document.getElementById('searchInventory').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.inventory-table tbody tr');
    
    rows.forEach(row => {
        const itemName = row.querySelector('td:first-child').textContent.toLowerCase();
        const matches = itemName.includes(searchTerm);
        row.style.display = matches ? '' : 'none';
    });
});

// Category filter
document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
    const category = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.inventory-table tbody tr');
    
    rows.forEach(row => {
        const rowCategory = row.children[1].textContent.toLowerCase();
        row.style.display = !category || rowCategory === category ? '' : 'none';
    });
});

function viewQR(itemId) {
    // Implement QR code view functionality
    window.location.href = `generate.php?view=${itemId}`;
}

function editItem(itemId) {
    // Implement edit functionality
    window.location.href = `generate.php?edit=${itemId}`;
}

function deleteItem(itemId) {
    if (!itemId) {
        console.error('No item ID provided');
        showNotification('Error: Invalid item ID', 'error');
        return;
    }

    if (confirm('Are you sure you want to delete this item?')) {
        console.log('Attempting to delete item:', itemId);

        fetch('api/delete_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: itemId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Server response:', data);
            
            if (data.success) {
                // Find the row
                const row = document.querySelector(`tr[data-item-id="${itemId}"]`);
                
                if (!row) {
                    console.error('Row not found:', itemId);
                    showNotification('Error: Row not found', 'error');
                    return;
                }

                // Get item details before removal
                const quantity = parseInt(row.querySelector('td:nth-child(3)').textContent) || 0;
                const price = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace('$', '')) || 0;
                const statusElement = row.querySelector('.status-badge');
                const status = statusElement ? statusElement.textContent.trim() : '';

                // Remove the row with animation
                row.style.backgroundColor = '#ffebee';
                row.style.transition = 'all 0.3s ease';
                setTimeout(() => {
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        
                        // Update statistics
                        updateStats({
                            totalItems: -1,
                            totalQuantity: -quantity,
                            lowStock: status === 'Low Stock' ? -1 : 0,
                            price: -price
                        });
                        
                        showNotification('Item deleted successfully', 'success');
                    }, 300);
                }, 100);
            } else {
                console.error('Delete failed:', data.message);
                showNotification(data.message || 'Error deleting item', 'error');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            showNotification('Error deleting item: ' + error.message, 'error');
        });
    }
}

function updateStats(changes) {
    // Update total items
    const totalItemsElement = document.querySelector('.stat-card:nth-child(1) .value');
    if (totalItemsElement) {
        totalItemsElement.textContent = (parseInt(totalItemsElement.textContent) + changes.totalItems).toString();
    }

    // Update total quantity
    const totalQuantityElement = document.querySelector('.stat-card:nth-child(2) .value');
    if (totalQuantityElement) {
        totalQuantityElement.textContent = (parseInt(totalQuantityElement.textContent) + changes.totalQuantity).toString();
    }

    // Update low stock items
    const lowStockElement = document.querySelector('.stat-card:nth-child(3) .value');
    if (lowStockElement) {
        lowStockElement.textContent = (parseInt(lowStockElement.textContent) + changes.lowStock).toString();
    }

    // Update total revenue
    const totalRevenueElement = document.querySelector('.stat-card:nth-child(4) .value');
    if (totalRevenueElement) {
        const currentRevenue = parseFloat(totalRevenueElement.textContent.replace('$', '').replace(',', ''));
        const newRevenue = currentRevenue + (changes.price * changes.totalQuantity);
        totalRevenueElement.textContent = '$' + newRevenue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        ${message}
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
