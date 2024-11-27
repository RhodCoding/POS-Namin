<?php
session_start();
// TODO: Add authentication check
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Products</title>
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
                            <a class="nav-link active text-white" href="products.php">
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Products Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="bi bi-plus"></i> Add New Product
                        </button>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="productSearch" 
                                   placeholder="Search products..." autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="categoryFilter">
                            <option value="all">All Categories</option>
                            <option value="bread">Bread</option>
                            <option value="cakes">Cakes</option>
                            <option value="pastries">Pastries</option>
                            <option value="beverages">Beverages</option>
                        </select>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="productsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
    <tr data-product-id="1">
        <td>1</td>
        <td><img src="assets/images/pandesal.jpg" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" data-image-path="assets/images/pandesal.jpg"></td>
        <td data-name>Pandesal</td>
        <td data-category>bread</td>
        <td data-price>₱5.00</td>
        <td data-stock>100</td>
        <td><span class="badge bg-success" data-status>Active</span></td>
        <td>
            <button class="btn btn-sm btn-primary edit-product"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger delete-product"><i class="bi bi-trash"></i></button>
        </td>
    </tr>
    <tr data-product-id="2">
        <td>2</td>
        <td><img src="assets/images/chocolate-cake.jpg" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" data-image-path="assets/images/chocolate-cake.jpg"></td>
        <td data-name>Chocolate Cake</td>
        <td data-category>cakes</td>
        <td data-price>₱450.00</td>
        <td data-stock>5</td>
        <td><span class="badge bg-success" data-status>Active</span></td>
        <td>
            <button class="btn btn-sm btn-primary edit-product"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-danger delete-product"><i class="bi bi-trash"></i></button>
        </td>
    </tr>
</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category" required>
                                <option value="">Select Category</option>
                                <option value="bread">Bread</option>
                                <option value="cakes">Cakes</option>
                                <option value="pastries">Pastries</option>
                                <option value="beverages">Beverages</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" name="price" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Initial Stock</label>
                            <input type="number" class="form-control" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="addProductForm">Save Product</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/products.js"></script>

    <!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <input type="hidden" name="productId" id="editProductId">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="name" id="editProductName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category" id="editProductCategory" required>
                            <option value="">Select Category</option>
                            <option value="bread">Bread</option>
                            <option value="cakes">Cakes</option>
                            <option value="pastries">Pastries</option>
                            <option value="beverages">Beverages</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (₱)</label>
                        <input type="number" class="form-control" name="price" id="editProductPrice" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" name="stock" id="editProductStock" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="image" id="editProductImage" accept="image/*">
                        <div class="mt-2">
                            <img id="editProductImagePreview" src="" alt="Product Image" class="img-thumbnail" style="max-width: 100px; display: none;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="editProductDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="editProductStatus" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="ProductsManager.products.saveEdit()">Save Changes</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
