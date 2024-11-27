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
    <style>
        .category-pills .nav-link {
            color: #6c757d;
            border: 1px solid #dee2e6;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .category-pills .nav-link.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
        .product-card {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .cart-item {
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main content -->
            <main class="col-md-12 px-md-4">
                <div class="d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0">Bakery POS</h4>
                    <div>
                        <a href="reports.php" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-graph-up"></i> Sales Report
                        </a>
                        <a href="dashboard.php" class="btn btn-outline-primary">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </div>
                </div>

                <div class="row">
                    <!-- Left side - Product selection -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Search Bar -->
<div class="mb-3">
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" class="form-control" id="productSearch" 
               placeholder="Search products... (Press '/' to focus)" 
               autocomplete="off">
    </div>
</div>
                                <!-- Category Pills -->
                                <ul class="nav nav-pills category-pills" id="categoryPills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#" data-category="all">All Items</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-category="bread">Bread</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-category="pastries">Pastries</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-category="cakes">Cakes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-category="cookies">Cookies</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-2 row-cols-md-4 g-3">
                                    <!-- Breads -->
                                    <div class="col" data-category="bread">
                                        <div class="card h-100 product-card" data-product data-product-id="1" 
                                             data-product-name="Pandesal" data-product-price="5">
                                            <img src="assets/images/bread.jpg" class="card-img-top p-2" alt="Pandesal">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Pandesal</h6>
                                                <p class="card-text fw-bold">₱5.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" data-category="bread">
                                        <div class="card h-100 product-card" data-product data-product-id="2" 
                                             data-product-name="Wheat Bread" data-product-price="50">
                                            <img src="assets/images/bread.jpg" class="card-img-top p-2" alt="Wheat Bread">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Wheat Bread</h6>
                                                <p class="card-text fw-bold">₱50.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Pastries -->
                                    <div class="col" data-category="pastries">
                                        <div class="card h-100 product-card" data-product data-product-id="3" 
                                             data-product-name="Ensaymada" data-product-price="35">
                                            <img src="assets/images/croissant.jpg" class="card-img-top p-2" alt="Ensaymada">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Ensaymada</h6>
                                                <p class="card-text fw-bold">₱35.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" data-category="pastries">
                                        <div class="card h-100 product-card" data-product data-product-id="4" 
                                             data-product-name="Spanish Bread" data-product-price="15">
                                            <img src="assets/images/croissant.jpg" class="card-img-top p-2" alt="Spanish Bread">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Spanish Bread</h6>
                                                <p class="card-text fw-bold">₱15.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cakes -->
                                    <div class="col" data-category="cakes">
                                        <div class="card h-100 product-card" data-product data-product-id="5" 
                                             data-product-name="Ube Cake" data-product-price="450">
                                            <img src="assets/images/chocolate-cake.jpg" class="card-img-top p-2" alt="Ube Cake">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Ube Cake</h6>
                                                <p class="card-text fw-bold">₱450.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" data-category="cakes">
                                        <div class="card h-100 product-card" data-product data-product-id="6" 
                                             data-product-name="Mango Cake" data-product-price="500">
                                            <img src="assets/images/chocolate-cake.jpg" class="card-img-top p-2" alt="Mango Cake">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Mango Cake</h6>
                                                <p class="card-text fw-bold">₱500.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cookies -->
                                    <div class="col" data-category="cookies">
                                        <div class="card h-100 product-card" data-product data-product-id="7" 
                                             data-product-name="Chocolate Chip Cookies" data-product-price="15">
                                            <img src="assets/images/donut.jpg" class="card-img-top p-2" alt="Chocolate Chip Cookies">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Chocolate Chip Cookies</h6>
                                                <p class="card-text fw-bold">₱15.00</p>
                                                <button class="btn btn-sm btn-primary w-100">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" data-category="cookies">
                                        <div class="card h-100 product-card" data-product data-product-id="8" 
                                             data-product-name="Oatmeal Cookies" data-product-price="15">
                                            <img src="assets/images/donut.jpg" class="card-img-top p-2" alt="Oatmeal Cookies">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Oatmeal Cookies</h6>
                                                <p class="card-text fw-bold">₱15.00</p>
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
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Current Sale</h5>
                            </div>
                            <div class="card-body">
                                <!-- Cart Items -->
                                <div id="cart-items" data-cart-items class="cart-items mb-3" style="height: 400px; overflow-y: auto;">
                                    <!-- Cart items will be inserted here by JavaScript -->
                                </div>

                                <!-- Cart Summary -->
                                <div class="cart-summary border-top pt-3">
                                    <div class="row mb-2">
                                        <div class="col">Subtotal:</div>
                                        <div class="col text-end">₱<span data-subtotal-amount>0.00</span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">Total:</div>
                                        <div class="col text-end">
                                            <h4 class="mb-0">₱<span data-total-amount>0.00</span></h4>
                                        </div>
                                    </div>

                                    <!-- Payment Section -->
                                    <div class="payment-section mt-3">
                                        <div class="mb-3">
                                            <label class="form-label">Cash Received</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₱</span>
                                                <input type="number" class="form-control form-control-lg" data-cash-received min="0" step="1">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Change</label>
                                            <h4 class="mb-0">₱<span data-change-amount>0.00</span></h4>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-success btn-lg" data-complete-sale disabled>
                                            <i class="bi bi-check-circle"></i> Complete Sale
                                        </button>
                                        <button class="btn btn-outline-secondary" data-clear-cart>
                                            <i class="bi bi-trash"></i> Clear Cart
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/utils.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
