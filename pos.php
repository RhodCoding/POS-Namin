<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main content -->
            <main class="col-md-12 px-md-4">
                <div class="d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0">Bakery POS</h4>
                    <a href="dashboard.php" class="btn btn-outline-primary">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </div>

                <div class="row">
                    <!-- Left side - Product selection -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" placeholder="Search Products...">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select">
                                            <option selected>All Items</option>
                                            <option>Bread</option>
                                            <option>Pastries</option>
                                            <option>Cakes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-2 row-cols-md-4 g-3">
                                    <!-- Bakery Products -->
                                    <div class="col">
                                        <div class="card h-100 product-card">
                                            <img src="assets/images/bread.jpg" class="card-img-top p-2" alt="White Bread">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">White Bread</h6>
                                                <p class="card-text fw-bold">₱50.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 product-card">
                                            <img src="assets/images/croissant.jpg" class="card-img-top p-2" alt="Croissant">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Croissant</h6>
                                                <p class="card-text fw-bold">₱75.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 product-card">
                                            <img src="assets/images/chocolate-cake.jpg" class="card-img-top p-2" alt="Chocolate Cake">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Chocolate Cake</h6>
                                                <p class="card-text fw-bold">₱450.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 product-card">
                                            <img src="assets/images/donut.jpg" class="card-img-top p-2" alt="Donut">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Donut</h6>
                                                <p class="card-text fw-bold">₱35.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right side - Cart -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Current Sale</h5>
                            </div>
                            <div class="card-body">
                                <!-- Cart Items -->
                                <div class="cart-items mb-3" style="height: 400px; overflow-y: auto;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>White Bread</td>
                                                <td>1</td>
                                                <td>₱50.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger">×</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Cart Summary -->
                                <div class="cart-summary border-top pt-3">
                                    <div class="row mb-2">
                                        <div class="col">Total:</div>
                                        <div class="col text-end"><h4 class="mb-0">₱50.00</h4></div>
                                    </div>

                                    <!-- Payment Button -->
                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                            Pay Now
                                        </button>
                                        <button class="btn btn-outline-secondary">
                                            Clear Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cash Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3>Total Amount</h3>
                        <h2 class="text-success">₱50.00</h2>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Cash Received</label>
                        <input type="number" class="form-control form-control-lg" step="1" min="50">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Change</label>
                        <input type="text" class="form-control form-control-lg" readonly value="₱0.00">
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-success btn-lg">
                            Complete Sale
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
