<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Bakery POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                            <a class="nav-link active text-white" href="settings.php">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Settings</h1>
                </div>

                <!-- Settings Sections -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <!-- Business Information -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Business Information</h5>
                            </div>
                            <div class="card-body">
                                <form id="businessForm">
                                    <div class="mb-3">
                                        <label class="form-label">Business Name</label>
                                        <input type="text" class="form-control" id="businessName">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" rows="2" id="businessAddress"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="businessContact">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <!-- Receipt Settings -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Receipt Settings</h5>
                            </div>
                            <div class="card-body">
                                <form id="receiptForm">
                                    <div class="mb-3">
                                        <label class="form-label">Receipt Header</label>
                                        <textarea class="form-control" rows="2" id="receiptHeader"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Receipt Footer</label>
                                        <textarea class="form-control" rows="2" id="receiptFooter"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="row mb-4">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary" id="saveSettings">
                            <i class="bi bi-save"></i> Save Settings
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/settings.js"></script>
</body>
</html>