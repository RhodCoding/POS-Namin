<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery POS - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="pos.php">
                                <i class="bi bi-cart"></i> Point of Sale
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="products.php">
                                <i class="bi bi-box"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="reports.php">
                                <i class="bi bi-graph-up"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="settings.php">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a class="nav-link text-danger" href="index.php">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="pos.php" class="btn btn-primary">
                            <i class="bi bi-cart-plus"></i> New Sale
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Today's Sales</h6>
                                        <h3 class="mb-0">₱0.00</h3>
                                    </div>
                                    <i class="bi bi-cash-stack h1 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Pieces Sold Today</h6>
                                        <h3 class="mb-0">0 pcs</h3>
                                        <small class="text-white-50">Bread & Pastries</small>
                                    </div>
                                    <i class="bi bi-basket h1 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-info text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Best Seller Today</h6>
                                        <h3 class="mb-0">Pandesal</h3>
                                        <small class="text-white-50">150 pcs sold</small>
                                    </div>
                                    <i class="bi bi-star h1 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-warning text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Low Stock Alert</h6>
                                        <h3 class="mb-0">2</h3>
                                        <small class="text-white-50">Items to restock</small>
                                    </div>
                                    <i class="bi bi-exclamation-triangle h1 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Chart -->
                <div class="row mt-4">
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Today's Sales by Hour</h5>
                                <small class="text-muted">Most sales during breakfast time</small>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Top Selling Items</h5>
                                <small class="text-muted">By pieces sold</small>
                            </div>
                            <div class="card-body">
                                <canvas id="productsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Sales -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Sales</h5>
                        <small class="text-muted">Last 5 transactions</small>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Items</th>
                                        <th>Pieces</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>08:30 AM</td>
                                        <td>Pandesal, Cheese Bread</td>
                                        <td>25 pcs</td>
                                        <td>₱125.00</td>
                                    </tr>
                                    <tr>
                                        <td>08:15 AM</td>
                                        <td>Ensaymada, Spanish Bread</td>
                                        <td>10 pcs</td>
                                        <td>₱200.00</td>
                                    </tr>
                                    <tr>
                                        <td>07:45 AM</td>
                                        <td>Pandesal</td>
                                        <td>50 pcs</td>
                                        <td>₱250.00</td>
                                    </tr>
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
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['6AM', '7AM', '8AM', '9AM', '10AM', '11AM', '12PM', '1PM', '2PM', '3PM', '4PM', '5PM'],
                datasets: [{
                    label: 'Sales (₱)',
                    data: [300, 850, 1200, 1000, 800, 750, 950, 800, 600, 500, 500, 500],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value;
                            }
                        }
                    }
                }
            }
        });

        // Products Chart
        const productsCtx = document.getElementById('productsChart').getContext('2d');
        new Chart(productsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pandesal', 'Ensaymada', 'Cheese Bread', 'Spanish Bread', 'Chocolate Cake'],
                datasets: [{
                    data: [150, 25, 30, 20, 10],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>
