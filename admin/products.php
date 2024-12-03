<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Bakery POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block sidebar">
                <?php include 'components/sidebar.php'; ?>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3">
                    <h2>Products</h2>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="bi bi-plus-lg"></i> Add Product
                        </button>
                        <button class="btn btn-success" onclick="location.reload()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                </div>

                <!-- Products Content -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Product List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
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
                                            <!-- Products will be populated here -->
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
                            <select class="form-select" name="category_id" required>
                                <!-- Categories will be populated here -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveProduct()">Save Product</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function saveProduct() {
            const form = document.getElementById('addProductForm');
            const formData = new FormData(form);

            fetch('../api/products.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.error);
                }
            });
        }

        function loadProducts() {
            fetch('../api/products.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Populate products table
                    const tbody = document.querySelector('tbody');
                    tbody.innerHTML = '';
                    data.products.forEach(product => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${product.id}</td>
                                <td><img src="${product.image}" width="50" height="50" alt="${product.name}"></td>
                                <td>${product.name}</td>
                                <td>${product.category}</td>
                                <td>₱${parseFloat(product.price).toFixed(2)}</td>
                                <td>${product.stock}</td>
                                <td>${product.status}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editProduct(${product.id})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }
            });
        }

        // Load products when page loads
        document.addEventListener('DOMContentLoaded', loadProducts);
    </script>
</body>
</html>
