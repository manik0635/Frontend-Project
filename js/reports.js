document.addEventListener('DOMContentLoaded', function() {
    // Add console log to verify the script is running
    console.log('Reports.js loaded');

    // Set default date range (last 30 days)
    const endDate = new Date();
    const startDate = new Date();
    startDate.setDate(startDate.getDate() - 30);
    
    document.getElementById('startDate').valueAsDate = startDate;
    document.getElementById('endDate').valueAsDate = endDate;
    
    try {
        // Verify canvas elements exist
        const revenueCanvas = document.getElementById('revenueChart');
        const categoryCanvas = document.getElementById('categoryChart');
        
        if (!revenueCanvas || !categoryCanvas) {
            console.error('Canvas elements not found');
            return;
        }

        // Initialize charts
        initializeCharts();
        
        // Load initial data
        loadReportData();
    } catch (error) {
        console.error('Error initializing reports:', error);
    }
});

function initializeCharts() {
    try {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: '#4CAF50',
                    backgroundColor: 'rgba(76, 175, 80, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Electronics', 'Furniture', 'Clothing', 'Other'],
                datasets: [{
                    data: [30, 25, 25, 20],
                    backgroundColor: [
                        '#4CAF50',
                        '#2196F3',
                        '#9C27B0',
                        '#FF9800'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        console.log('Charts initialized successfully');
    } catch (error) {
        console.error('Error in initializeCharts:', error);
    }
}

function loadReportData() {
    // Simulate loading data
    const sampleData = [
        {
            name: 'Laptop Dell XPS 13',
            category: 'Electronics',
            stock: 45,
            value: '$1,299.99',
            lastUpdated: '2024-01-15',
            status: 'In Stock'
        },
        {
            name: 'Office Chair',
            category: 'Furniture',
            stock: 12,
            value: '$299.99',
            lastUpdated: '2024-01-14',
            status: 'Low Stock'
        },
        // Add more sample data as needed
    ];

    const tbody = document.querySelector('.report-table tbody');
    tbody.innerHTML = sampleData.map(item => `
        <tr>
            <td>${item.name}</td>
            <td>${item.category}</td>
            <td>${item.stock}</td>
            <td>${item.value}</td>
            <td>${item.lastUpdated}</td>
            <td>
                <span class="status-badge ${item.status.toLowerCase().replace(' ', '-')}">
                    ${item.status}
                </span>
            </td>
        </tr>
    `).join('');
}

function updateReports() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    // Add loading animation
    const container = document.querySelector('.reports-container');
    container.style.opacity = '0.7';
    
    // Simulate API call
    setTimeout(() => {
        // Refresh data
        initializeCharts();
        loadReportData();
        
        // Remove loading state
        container.style.opacity = '1';
        
        // Show success notification
        showNotification('Reports updated successfully', 'success');
    }, 1000);
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
