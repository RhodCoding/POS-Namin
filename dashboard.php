<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Dashboard</title>
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
                                <i class="bi bi-cart"></i> New Sale
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="products.php">
                                <i class="bi bi-box"></i> Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="customers.php">
                                <i class="bi bi-people"></i> Customers
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
                            <i class="bi bi-plus"></i> New Sale
                        </a>
                    </div>
                </div>

                <!-- Dashboard Quick Stats -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Today's Sales</h6>
                                        <h2 class="card-text">₱1,250.00</h2>
                                    </div>
                                    <i class="bi bi-currency-dollar fs-1"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small>Compared to yesterday: <span class="text-success">+15%</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Products</h6>
                                        <h2 class="card-text">150</h2>
                                    </div>
                                    <i class="bi bi-box fs-1"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small>Active products: 145</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-warning text-dark h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Customers</h6>
                                        <h2 class="card-text">48</h2>
                                    </div>
                                    <i class="bi bi-people fs-1"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small>New this month: 5</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-danger text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Low Stock Items</h6>
                                        <h2 class="card-text">12</h2>
                                    </div>
                                    <i class="bi bi-exclamation-triangle fs-1"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small>Need immediate attention</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mt-4">
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                Sales Overview
                            </div>
                            <div class="card-body">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                Top Selling Products
                            </div>
                            <div class="card-body">
                                <canvas id="productsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Sales Table -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Recent Sales
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Invoice #</th>
                                                <th>Customer</th>
                                                <th>Products</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>INV-2023-001</td>
                                                <td>John Doe</td>
                                                <td>3 items</td>
                                                <td>₱150.00</td>
                                                <td>2023-06-20</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>INV-2023-002</td>
                                                <td>Jane Smith</td>
                                                <td>1 item</td>
                                                <td>₱75.00</td>
                                                <td>2023-06-20</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>INV-2023-003</td>
                                                <td>Bob Johnson</td>
                                                <td>5 items</td>
                                                <td>₱320.00</td>
                                                <td>2023-06-20</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales (₱)',
                    data: [1200, 1900, 1500, 2100, 1800, 2500, 1250],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Products Chart
        const productsCtx = document.getElementById('productsChart').getContext('2d');
        new Chart(productsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
                datasets: [{
                    data: [30, 25, 20, 15, 10],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
