document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('generateQRForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        generateQRCode();
    });
});

function generateQRCode() {
    const form = document.getElementById('generateQRForm');
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Disable form while generating
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
    
    try {
        // Validate inputs
        const itemName = document.getElementById('itemName').value.trim();
        const itemCategory = document.getElementById('itemCategory').value;
        const quantity = parseInt(document.getElementById('quantity').value);
        const price = parseFloat(document.getElementById('price').value);

        if (!itemName) {
            throw new Error('Item name is required');
        }
        if (!itemCategory) {
            throw new Error('Category is required');
        }
        if (isNaN(quantity) || quantity < 0) {
            throw new Error('Invalid quantity');
        }
        if (isNaN(price) || price < 0) {
            throw new Error('Invalid price');
        }

        // Create QR code data
        const qrData = {
            id: Date.now().toString(),
            itemName: itemName,
            itemCategory: itemCategory,
            quantity: quantity,
            price: price.toFixed(2)
        };
        
        // Convert to JSON string
        const qrString = JSON.stringify(qrData);
        
        // Clear previous QR code
        const qrResult = document.getElementById('qrResult');
        qrResult.innerHTML = '';
        
        // Create a wrapper for the QR code
        const qrWrapper = document.createElement('div');
        qrWrapper.className = 'qr-wrapper';
        qrResult.appendChild(qrWrapper);
        
        // Generate QR code
        new QRCode(qrWrapper, {
            text: qrString,
            width: 300,
            height: 300
        });
        
        // Add preview
        const previewData = document.createElement('div');
        previewData.className = 'qr-preview';
        previewData.innerHTML = `
            <h4>Item Details:</h4>
            <p><strong>ID:</strong> ${qrData.id}</p>
            <p><strong>Name:</strong> ${qrData.itemName}</p>
            <p><strong>Category:</strong> ${qrData.itemCategory}</p>
            <p><strong>Quantity:</strong> ${qrData.quantity}</p>
            <p><strong>Price:</strong> $${qrData.price}</p>
        `;
        qrResult.appendChild(previewData);
        
        // Add buttons
        const buttonContainer = document.createElement('div');
        buttonContainer.className = 'button-container';
        
        // Download button
        const downloadBtn = document.createElement('button');
        downloadBtn.className = 'btn secondary';
        downloadBtn.innerHTML = '<i class="fas fa-download"></i> Download QR';
        downloadBtn.addEventListener('click', downloadQRCode);
        buttonContainer.appendChild(downloadBtn);
        
        // Save button
        const saveBtn = document.createElement('button');
        saveBtn.className = 'btn primary';
        saveBtn.innerHTML = '<i class="fas fa-save"></i> Save & Close';
        saveBtn.addEventListener('click', async function() {
            try {
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                
                const itemData = {
                    id: qrData.id,
                    itemName: qrData.itemName,
                    itemCategory: qrData.itemCategory,
                    quantity: parseInt(qrData.quantity),
                    price: parseFloat(qrData.price)
                };

                console.log('Sending data:', itemData);
                
                const response = await fetch('save_item.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(itemData)
                });

                const data = await response.json();
                console.log('Server response:', data);

                if (data.success) {
                    showNotification('Item saved successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = 'inventory.php';
                    }, 1500);
                } else {
                    throw new Error(data.message || 'Failed to save item');
                }
            } catch (error) {
                console.error('Save error:', error);
                showNotification(error.message || 'Error saving item', 'error');
            } finally {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Save & Close';
            }
        });
        buttonContainer.appendChild(saveBtn);
        
        // Test button
        const testBtn = document.createElement('button');
        testBtn.className = 'btn secondary';
        testBtn.innerHTML = '<i class="fas fa-qrcode"></i> Test Scan';
        testBtn.addEventListener('click', function() {
            window.location.href = `scan.php?test=${encodeURIComponent(qrString)}`;
        });
        buttonContainer.appendChild(testBtn);
        
        qrResult.appendChild(buttonContainer);
        
    } catch (error) {
        console.error('QR Generation Error:', error);
        document.getElementById('qrResult').innerHTML = `
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                ${error.message || 'Failed to generate QR code. Please try again.'}
            </div>
        `;
    } finally {
        // Re-enable form
        submitButton.disabled = false;
        submitButton.innerHTML = 'Generate QR Code';
    }
}

function downloadQRCode() {
    const canvas = document.querySelector('#qrResult .qr-wrapper canvas');
    if (!canvas) return;
    
    const tempCanvas = document.createElement('canvas');
    const padding = 20;
    tempCanvas.width = canvas.width + (padding * 2);
    tempCanvas.height = canvas.height + (padding * 2);
    
    const ctx = tempCanvas.getContext('2d');
    ctx.fillStyle = '#FFFFFF';
    ctx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);
    ctx.drawImage(canvas, padding, padding);
    
    const link = document.createElement('a');
    link.href = tempCanvas.toDataURL('image/png', 1.0);
    link.download = `qr-${Date.now()}.png`;
    link.click();
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

