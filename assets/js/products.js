// Products Page Management

const ProductsManager = {
    elements: {
        searchInput: document.querySelector('#productSearch'),
        categoryFilter: document.querySelector('#categoryFilter'),
        productsTable: document.querySelector('#productsTable tbody'),
        addProductForm: document.querySelector('#addProductForm'),
        editProductForm: document.querySelector('#editProductForm'),
        editButtons: document.querySelectorAll('.edit-product'),
        deleteButtons: document.querySelectorAll('.delete-product')
    },

    // Search and Filter
    search: {
        filterProducts() {
            const searchTerm = ProductsManager.elements.searchInput.value.toLowerCase();
            const selectedCategory = ProductsManager.elements.categoryFilter.value;
            
            const rows = ProductsManager.elements.productsTable.querySelectorAll('tr');
            rows.forEach(row => {
                const name = row.querySelector('[data-name]').textContent.toLowerCase();
                const category = row.querySelector('[data-category]').textContent;
                
                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = selectedCategory === 'all' || category === selectedCategory;
                
                row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
            });
        }
    },

    // Product Management
    products: {
        addProduct(event) {
            event.preventDefault();
            const formData = new FormData(ProductsManager.elements.addProductForm);
            
            // For frontend demo, we'll just add the product to the table
            const newProduct = {
                id: Math.floor(Math.random() * 1000), // Demo ID
                name: formData.get('name'),
                category: formData.get('category'),
                price: formData.get('price'),
                stock: formData.get('stock'),
                status: 'active'
            };

            // Add new row to table
            const newRow = `
                <tr data-product-id="${newProduct.id}">
                    <td>${newProduct.id}</td>
                    <td><img src="assets/images/placeholder.jpg" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" data-image-path="assets/images/placeholder.jpg"></td>
                    <td data-name>${newProduct.name}</td>
                    <td data-category>${newProduct.category}</td>
                    <td data-price>₱${parseFloat(newProduct.price).toFixed(2)}</td>
                    <td data-stock>${newProduct.stock}</td>
                    <td><span class="badge bg-success" data-status>Active</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary edit-product"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger delete-product"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `;
            ProductsManager.elements.productsTable.insertAdjacentHTML('beforeend', newRow);
            
            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(document.querySelector('#addProductModal'));
            modal.hide();
            event.target.reset();
            
            // Show success message
            this.showToast('Product added successfully!', 'success');

            // Reattach event listeners to new buttons
            this.attachEventListeners();
        },

        editProduct(productId) {
            const row = document.querySelector(`tr[data-product-id="${productId}"]`);
            if (!row) return;

            // Get product data from the row
            const name = row.querySelector('[data-name]').textContent;
            const category = row.querySelector('[data-category]').textContent;
            const price = row.querySelector('[data-price]').textContent.replace('₱', '');
            const stock = row.querySelector('[data-stock]').textContent;
            const status = row.querySelector('[data-status]').textContent.toLowerCase();

            // Fill the edit form
            document.getElementById('editProductId').value = productId;
            document.getElementById('editProductName').value = name;
            document.getElementById('editProductCategory').value = category;
            document.getElementById('editProductPrice').value = price;
            document.getElementById('editProductStock').value = stock;
            document.getElementById('editProductStatus').value = status;

            // Show the edit modal
            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        },

        saveEdit() {
            const productId = document.getElementById('editProductId').value;
            const name = document.getElementById('editProductName').value;
            const category = document.getElementById('editProductCategory').value;
            const price = document.getElementById('editProductPrice').value;
            const stock = document.getElementById('editProductStock').value;
            const status = document.getElementById('editProductStatus').value;

            const row = document.querySelector(`tr[data-product-id="${productId}"]`);
            if (!row) return;

            // Update the row with new values
            row.querySelector('[data-name]').textContent = name;
            row.querySelector('[data-category]').textContent = category;
            row.querySelector('[data-price]').textContent = `₱${parseFloat(price).toFixed(2)}`;
            row.querySelector('[data-stock]').textContent = stock;
            const statusBadge = row.querySelector('td:nth-child(7) .badge');
            statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            statusBadge.className = `badge bg-${status === 'active' ? 'success' : 'danger'}`;

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
            modal.hide();

            // Show success message
            this.showToast('Product updated successfully!', 'success');
        },

        deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                if (row) {
                    row.remove();
                    this.showToast('Product deleted successfully!', 'success');
                }
            }
        },

        attachEventListeners() {
            // Attach edit and delete handlers to all buttons
            document.querySelectorAll('.edit-product').forEach(button => {
                button.addEventListener('click', () => {
                    const productId = button.closest('tr').dataset.productId;
                    this.editProduct(productId);
                });
            });

            document.querySelectorAll('.delete-product').forEach(button => {
                button.addEventListener('click', () => {
                    const productId = button.closest('tr').dataset.productId;
                    this.deleteProduct(productId);
                });
            });
        },

        showToast(message, type = 'success') {
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }

            const toastHtml = `
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
    },

    // Initialize
    init() {
        // Search and filter handlers
        if (this.elements.searchInput) {
            this.elements.searchInput.addEventListener('input', () => this.search.filterProducts());
        }
        if (this.elements.categoryFilter) {
            this.elements.categoryFilter.addEventListener('change', () => this.search.filterProducts());
        }

        // Add product form handler
        if (this.elements.addProductForm) {
            this.elements.addProductForm.addEventListener('submit', (e) => this.products.addProduct.call(this.products, e));
        }

        // Initial event listeners
        this.products.attachEventListeners();
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => ProductsManager.init());
