document.addEventListener('DOMContentLoaded', function() {
    // Create instance of HTML5 QR code scanner
    const html5QrCode = new Html5Qrcode("reader");

    // Configure scanner settings
    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 },  // Made square and slightly smaller
        aspectRatio: 1.0,
        formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ],
        experimentalFeatures: {
            useBarCodeDetectorIfSupported: true
        },
        rememberLastUsedCamera: true,
        showTorchButtonIfSupported: true
    };

    // Start scanning
    html5QrCode.start(
        { facingMode: "environment" },
        config,
        onScanSuccess,
        onScanError
    ).catch(err => {
        console.error("Error starting scanner:", err);
        document.getElementById('result').innerHTML = `
            <div class="scan-result" style="border-color: #f44336;">
                <h3><i class="fas fa-exclamation-circle"></i> Scanner Error</h3>
                <p>Please make sure you've given camera permissions.</p>
            </div>
        `;
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        html5QrCode.stop().catch(console.error);
    });
});

function onScanSuccess(decodedText) {
    try {
        let qrData;
        decodedText = decodedText.trim();
        
        // Try to parse as inventory QR code
        try {
            qrData = JSON.parse(decodedText);
            // If it's our inventory QR code (has expected properties)
            if (qrData.id && qrData.itemName) {
                showInventoryResult(qrData);
            } else {
                // Show as regular QR code
                showGeneralResult(decodedText);
            }
        } catch (e) {
            // Not JSON - show as regular QR code
            showGeneralResult(decodedText);
        }

        // Play success sound
        const audio = new Audio('assets/beep.mp3');
        audio.play().catch(() => {});

        // Add to history
        addToHistory(decodedText);
        
        // Update scan count
        updateScanCount();

    } catch (error) {
        console.error('Processing error:', error, 'Raw data:', decodedText);
        document.getElementById('result').innerHTML = `
            <div class="scan-result" style="border-color: #f44336;">
                <h3><i class="fas fa-exclamation-circle"></i> Error</h3>
                <p>Could not process the QR code.</p>
            </div>
        `;
    }
}

function showInventoryResult(qrData) {
    document.getElementById('result').innerHTML = `
        <div class="scan-result">
            <h3><i class="fas fa-box"></i> Inventory Item Found!</h3>
            <div style="margin: 1rem 0;">
                <p><strong>Item Name:</strong> ${qrData.itemName || 'N/A'}</p>
                <p><strong>Category:</strong> ${qrData.itemCategory || 'N/A'}</p>
                <p><strong>Quantity:</strong> ${qrData.quantity || 'N/A'}</p>
                <p><strong>Price:</strong> ${qrData.price ? '$' + qrData.price : 'N/A'}</p>
            </div>
            <button onclick="updateInventory('${encodeURIComponent(JSON.stringify(qrData))}')" class="btn primary">
                <i class="fas fa-sync"></i> Update Inventory
            </button>
        </div>
    `;
}

function showGeneralResult(decodedText) {
    // Check if it's a URL
    const isUrl = decodedText.match(/^(http|https):\/\/[^ "]+$/);
    
    document.getElementById('result').innerHTML = `
        <div class="scan-result">
            <h3><i class="fas fa-qrcode"></i> QR Code Scanned</h3>
            <div style="margin: 1rem 0;">
                <p class="qr-content">${decodedText}</p>
            </div>
            ${isUrl ? `
                <a href="${decodedText}" target="_blank" class="btn primary">
                    <i class="fas fa-external-link-alt"></i> Open Link
                </a>
            ` : `
                <button onclick="copyToClipboard('${decodedText.replace(/'/g, "\\'")}')" class="btn secondary">
                    <i class="fas fa-copy"></i> Copy Text
                </button>
            `}
        </div>
    `;
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('Copied to clipboard!', 'success');
    }).catch(err => {
        console.error('Failed to copy:', err);
        showNotification('Failed to copy text', 'error');
    });
}

function onScanError(err) {
    // Only log the error, don't show it to user unless it's critical
    console.warn("Scan error:", err);
}

function addToHistory(content) {
    const historyList = document.querySelector('.history-list');
    const historyItem = document.createElement('div');
    historyItem.className = 'history-item';
    
    // If it's JSON, try to get the item name
    let displayText;
    try {
        const data = JSON.parse(content);
        displayText = data.itemName || 'QR Code';
    } catch (e) {
        // If not JSON, show first 20 characters
        displayText = content.length > 20 ? content.substring(0, 20) + '...' : content;
    }

    historyItem.innerHTML = `
        <div class="history-item-content">
            <span class="code">
                <span class="status-indicator"></span>
                ${displayText}
            </span>
            <span class="time">${new Date().toLocaleTimeString()}</span>
        </div>
        <i class="fas fa-chevron-right" style="color: var(--text-muted)"></i>
    `;
    historyList.insertBefore(historyItem, historyList.firstChild);
}

function updateScanCount() {
    const countElement = document.getElementById('todayCount');
    const currentCount = parseInt(countElement.textContent) || 0;
    countElement.textContent = currentCount + 1;
}

function updateInventory(qrCode) {
    const btn = document.querySelector('.scan-result button');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    btn.disabled = true;
    
    fetch('update_inventory.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ qrCode: qrCode })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showNotification('Inventory updated successfully!', 'success');
        } else {
            showNotification('Error updating inventory', 'error');
        }
        btn.innerHTML = '<i class="fas fa-sync"></i> Update Inventory';
        btn.disabled = false;
    });
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
        notification.remove();
    }, 3000);
}

// Video Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videoModal');
    const btn = document.getElementById('demoVideoBtn');
    const closeBtn = document.querySelector('.close-modal');
    const video = document.getElementById('demoVideo');

    // Add error handling for video
    function videoError() {
        console.error('Video failed to load. Check file path: ' + video.querySelector('source').src);
        alert('Video failed to load. Please check console for details.');
    }
    window.videoError = videoError;

    // Check if video is loaded correctly
    video.addEventListener('loadeddata', function() {
        console.log('Video loaded successfully');
    });

    // Open modal with error handling
    btn.addEventListener('click', function() {
        modal.style.display = 'block';
        // Pause scanner while video is playing
        if (typeof html5QrCode !== 'undefined') {
            html5QrCode.pause();
        }
        // Play video with error handling
        video.play().catch(function(error) {
            console.error("Video play failed:", error);
            alert('Failed to play video. Please check console for details.');
        });
    });

    // Close modal
    function closeModal() {
        modal.style.display = 'none';
        video.pause();
        video.currentTime = 0;
        // Resume scanner
        if (typeof html5QrCode !== 'undefined') {
            html5QrCode.resume();
        }
    }

    // Close button click
    closeBtn.addEventListener('click', closeModal);

    // Click outside modal
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Close on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });

    // When video ends
    video.addEventListener('ended', function() {
        closeModal();
    });
});
