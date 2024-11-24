<?php
session_start();
// TODO: Add authentication check
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Point of Sale</title>
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
                            <a class="nav-link active text-white" href="pos.php">
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
                            <a class="nav-link text-white" href="settings.php">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="row mt-4">
                    <!-- Left side - Product selection -->
                    <div class="col-md-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Search Products...">
                                    </div>
                                    <div class="col">
                                        <select class="form-select">
                                            <option selected>All Categories</option>
                                            <option>Food</option>
                                            <option>Beverages</option>
                                            <option>Others</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-2 row-cols-md-4 g-4">
                                    <!-- Sample Product Items -->
                                    <div class="col">
                                        <div class="card h-100 product-card">
                                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Product">
                                            <div class="card-body">
                                                <h6 class="card-title">Product 1</h6>
                                                <p class="card-text">$10.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- More product cards would go here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right side - Cart -->
                    <div class="col-md-5">
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
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Sample Item</td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm" value="1" min="1" style="width: 60px;">
                                                </td>
                                                <td>$10.00</td>
                                                <td>$10.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Cart Summary -->
                                <div class="cart-summary">
                                    <div class="row mb-2">
                                        <div class="col">Subtotal:</div>
                                        <div class="col text-end">$10.00</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">Tax (10%):</div>
                                        <div class="col text-end">$1.00</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><strong>Total:</strong></div>
                                        <div class="col text-end"><strong>$11.00</strong></div>
                                    </div>

                                    <!-- Payment Buttons -->
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                            <i class="bi bi-cash"></i> Process Payment
                                        </button>
                                        <button class="btn btn-danger">
                                            <i class="bi bi-x-circle"></i> Cancel Sale
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
                    <h5 class="modal-title">Process Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="text" class="form-control" value="$11.00" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select">
                            <option>Cash</option>
                            <option>Card</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount Received</label>
                        <input type="number" class="form-control" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Complete Payment</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
