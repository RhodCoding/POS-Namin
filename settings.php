<?php
session_start();
// TODO: Add authentication check
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Settings</title>
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
                    <div class="col-md-3">
                        <div class="list-group mb-4">
                            <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                                General Settings
                            </a>
                            <a href="#company" class="list-group-item list-group-item-action" data-bs-toggle="list">
                                Company Information
                            </a>
                            <a href="#invoice" class="list-group-item list-group-item-action" data-bs-toggle="list">
                                Invoice Settings
                            </a>
                            <a href="#tax" class="list-group-item list-group-item-action" data-bs-toggle="list">
                                Tax Settings
                            </a>
                            <a href="#payment" class="list-group-item list-group-item-action" data-bs-toggle="list">
                                Payment Methods
                            </a>
                            <a href="#users" class="list-group-item list-group-item-action" data-bs-toggle="list">
                                User Management
                            </a>
                            <a href="#backup" class="list-group-item list-group-item-action" data-bs-toggle="list">
                                Backup & Restore
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content">
                            <!-- General Settings -->
                            <div class="tab-pane fade show active" id="general">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">General Settings</h5>
                                        <form>
                                            <div class="mb-3">
                                                <label class="form-label">Store Name</label>
                                                <input type="text" class="form-control" value="My POS Store">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Currency</label>
                                                <select class="form-select">
                                                    <option>USD ($)</option>
                                                    <option>EUR (€)</option>
                                                    <option>GBP (£)</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Time Zone</label>
                                                <select class="form-select">
                                                    <option>UTC-8 (Pacific Time)</option>
                                                    <option>UTC-5 (Eastern Time)</option>
                                                    <option>UTC+0 (GMT)</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Date Format</label>
                                                <select class="form-select">
                                                    <option>MM/DD/YYYY</option>
                                                    <option>DD/MM/YYYY</option>
                                                    <option>YYYY-MM-DD</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Company Information -->
                            <div class="tab-pane fade" id="company">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Company Information</h5>
                                        <form>
                                            <div class="mb-3">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" rows="3"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Phone</label>
                                                    <input type="tel" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tax ID/VAT Number</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Company Logo</label>
                                                <input type="file" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoice Settings -->
                            <div class="tab-pane fade" id="invoice">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Invoice Settings</h5>
                                        <form>
                                            <div class="mb-3">
                                                <label class="form-label">Invoice Prefix</label>
                                                <input type="text" class="form-control" value="INV-">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Next Invoice Number</label>
                                                <input type="number" class="form-control" value="1001">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Invoice Footer Text</label>
                                                <textarea class="form-control" rows="3"></textarea>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="showLogo">
                                                <label class="form-check-label" for="showLogo">Show Company Logo</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Other settings tabs would go here -->
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
