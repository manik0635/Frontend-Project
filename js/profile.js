document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    const editBtn = document.getElementById('editContactBtn');
    const saveBtn = document.getElementById('saveContactBtn');
    const cancelBtn = document.getElementById('cancelContactBtn');
    const editActions = document.querySelector('.edit-actions');
    const displayValues = document.querySelectorAll('.display-value');
    const editInputs = document.querySelectorAll('.edit-input');
    
    function enterEditMode() {
        displayValues.forEach(span => span.classList.add('hidden'));
        editInputs.forEach(input => input.classList.remove('hidden'));
        editActions.classList.remove('hidden');
        editBtn.classList.add('hidden');
    }
    
    function exitEditMode() {
        displayValues.forEach(span => span.classList.remove('hidden'));
        editInputs.forEach(input => input.classList.add('hidden'));
        editActions.classList.add('hidden');
        editBtn.classList.remove('hidden');
    }
    
    editBtn.addEventListener('click', enterEditMode);
    
    // Add save functionality
    saveBtn.addEventListener('click', async function() {
        // Show loading state
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        
        try {
            const formData = new FormData(contactForm);
            
            // Debug log
            console.log('Sending form data:', Object.fromEntries(formData));
            
            const response = await fetch('update_profile.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            console.log('Server response:', data); // Debug log
            
            if (data.success) {
                // Update display values with new input values
                editInputs.forEach(input => {
                    const correspondingSpan = input.closest('.detail-content')
                        .querySelector('.display-value');
                    correspondingSpan.textContent = input.value || 'Not set';
                });
                
                showNotification('Profile updated successfully!', 'success');
                exitEditMode();
            } else {
                throw new Error(data.message || 'Failed to update profile');
            }
        } catch (error) {
            console.error('Error details:', error);
            showNotification(error.message || 'Failed to update profile', 'error');
        } finally {
            // Reset button state
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
        }
    });
    
    // Add cancel functionality
    cancelBtn.addEventListener('click', exitEditMode);
});

// Add notification function if not already present
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
