<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - QR Inventory Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reports.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="images/2.jpg" alt="Logo">
            <span>QR Inventory</span>
        </div>
        <ul>
            <li><a href="./index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="./scan.php"><i class="fas fa-qrcode"></i> Scan QR</a></li>
            <li><a href="./generate.php"><i class="fas fa-plus-circle"></i> Generate QR</a></li>
            <li><a href="./inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
            <li><a href="./reports.php" class="active"><i class="fas fa-chart-bar"></i> Reports</a></li>
        </ul>
    </nav>

    <main class="reports-container">
        <h2><i class="fas fa-chart-bar"></i> Reports & Analytics</h2>
        
        <!-- Date Range Filter -->
        <div class="filter-section">
            <div class="date-range">
                <input type="date" id="startDate">
                <span>to</span>
                <input type="date" id="endDate">
                <button onclick="updateReports()" class="btn primary">
                    <i class="fas fa-sync"></i> Update
                </button>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="charts-container">
            <div class="chart-card">
                <h3>Revenue Overview</h3>
                <canvas id="revenueChart"></canvas>
            </div>
            
            <div class="chart-card">
                <h3>Category Distribution</h3>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Report Table -->
        <div class="table-section">
            <h3>Inventory Summary</h3>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Value</th>
                        <th>Last Updated</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="js/reports.js"></script>
</body>
</html>
