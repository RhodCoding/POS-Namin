<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery POS - Daily Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="pos.php">
                                <i class="bi bi-cart"></i> New Sale
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="products.php">
                                <i class="bi bi-box"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="reports.php">
                                <i class="bi bi-graph-up"></i> Sales Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="settings.php">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Daily Sales Report</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-outline-secondary me-2" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print Report
                        </button>
                        <input type="date" class="form-control" id="reportDate" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>

                <!-- Today's Summary -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary h-100">
                            <div class="card-body">
                                <h5 class="card-title">Today's Total Sales</h5>
                                <h2 class="mb-0">₱0.00</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success h-100">
                            <div class="card-body">
                                <h5 class="card-title">Items Sold Today</h5>
                                <h2 class="mb-0">0 items</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-info h-100">
                            <div class="card-body">
                                <h5 class="card-title">Average Sale</h5>
                                <h2 class="mb-0">₱0.00</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Breakdown -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Hourly Sales</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="hourlySalesChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Top Selling Items</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="topItemsChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Sales List -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Today's Sales</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sales will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hourly Sales Chart
        const hourlyCtx = document.getElementById('hourlySalesChart').getContext('2d');
        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: ['6AM', '7AM', '8AM', '9AM', '10AM', '11AM', '12PM', '1PM', '2PM', '3PM', '4PM', '5PM'],
                datasets: [{
                    label: 'Sales (₱)',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Top Items Chart
        const itemsCtx = document.getElementById('topItemsChart').getContext('2d');
        new Chart(itemsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Bread', 'Cakes', 'Pastries'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });

        // Date change handler
        document.getElementById('reportDate').addEventListener('change', function() {
            // TODO: Load sales data for selected date
            console.log('Selected date:', this.value);
        });
    </script>
</body>
</html>
