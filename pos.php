<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale - Bakery POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        .product-item {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .product-item:hover {
            transform: scale(1.05);
        }
        .cart-container {
            height: calc(100vh - 280px);
            overflow-y: auto;
        }
        .product-image {
            height: 120px;
            object-fit: cover;
            width: 100%;
            border-radius: 4px;
        }
    </style>
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
                <div class="row mt-3">
                    <!-- Left side - Products -->
                    <div class="col-md-7">
                        <!-- Search Products -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" id="searchProducts" placeholder="Search products...">
                                </div>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div class="card">
                            <div class="card-body">
                                <div class="product-grid" id="productsGrid">
                                    <!-- Products will be loaded here via JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right side - Cart -->
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">Current Sale</h5>
                            </div>
                            <div class="card-body p-0">
                                <!-- Cart Items -->
                                <div class="cart-container">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cartItems">
                                            <!-- Cart items will be loaded here via JavaScript -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Cart Summary -->
                                <div class="p-3 border-top">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5>Subtotal:</h5>
                                        <h5>₱<span id="subtotal">0.00</span></h5>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <h4>Total:</h4>
                                        <h4>₱<span id="total">0.00</span></h4>
                                    </div>

                                    <!-- Payment Actions -->
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success btn-lg" id="checkoutBtn">
                                            <i class="bi bi-cash"></i> Process Payment
                                        </button>
                                        <button class="btn btn-outline-danger" id="clearCartBtn">
                                            <i class="bi bi-trash"></i> Clear Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <input type="text" class="form-control form-control-lg" id="totalAmount" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cash Received</label>
                                    <input type="number" class="form-control form-control-lg" id="cashReceived" min="0" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Change</label>
                                    <input type="text" class="form-control form-control-lg" id="changeAmount" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-success" id="completePaymentBtn">Complete Sale</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/pos.js"></script>
</body>
</html>
