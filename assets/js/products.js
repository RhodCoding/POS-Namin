// Product Management System
const ProductManager = {
    products: [],
    categories: ['Bread', 'Cake', 'Pastry', 'Beverage'],
    currentView: 'grid',
    
    init() {
        this.loadProducts();
        this.setupEventListeners();
        this.loadCategories();
    },

    setupEventListeners() {
        // Search and filters
        document.getElementById('searchProduct').addEventListener('input', (e) => this.filterProducts());
        document.getElementById('categoryFilter').addEventListener('change', () => this.filterProducts());
        document.getElementById('stockFilter').addEventListener('change', () => this.filterProducts());
        
        // View toggles
        document.getElementById('gridView').addEventListener('click', () => this.toggleView('grid'));
        document.getElementById('listView').addEventListener('click', () => this.toggleView('list'));
        
        // Export button
        document.getElementById('exportProducts').addEventListener('click', () => this.exportProducts());
        
        // Image preview
        document.getElementById('image').addEventListener('change', this.handleImageUpload.bind(this));
        
        // Product form
        document.getElementById('productForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.saveProduct();
        });
        
        // Save button
        document.getElementById('saveProduct').addEventListener('click', () => {
            document.getElementById('productForm').dispatchEvent(new Event('submit'));
        });

        // Modal events
        const productModal = document.getElementById('productModal');
        productModal.addEventListener('hidden.bs.modal', () => this.resetForm());
        productModal.addEventListener('show.bs.modal', (e) => {
            if (e.relatedTarget) {
                const button = e.relatedTarget;
                if (button.dataset.action === 'edit') {
                    this.loadProductForEdit(button.dataset.id);
                }
            }
        });
    },

    loadCategories() {
        const categorySelect = document.getElementById('category');
        const categoryFilter = document.getElementById('categoryFilter');
        
        // Clear existing options
        categorySelect.innerHTML = '<option value="">Select Category</option>';
        categoryFilter.innerHTML = '<option value="">All Categories</option>';
        
        // Add categories
        this.categories.forEach(category => {
            categorySelect.innerHTML += `<option value="${category}">${category}</option>`;
            categoryFilter.innerHTML += `<option value="${category}">${category}</option>`;
        });
    },

    async loadProducts() {
        try {
            const response = await api.get('/api/products.php');
            if (response.success) {
                this.products = response.data;
                this.displayProducts(this.products);
            } else {
                this.showToast('Error loading products', 'error');
            }
        } catch (error) {
            console.error('Error loading products:', error);
            this.showToast('Failed to load products', 'error');
        }
    },

    toggleView(view) {
        this.currentView = view;
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const gridContainer = document.getElementById('gridView');
        const listContainer = document.getElementById('listView');
        
        if (view === 'grid') {
            gridView.classList.add('active');
            listView.classList.remove('active');
            gridContainer.classList.remove('d-none');
            listContainer.classList.add('d-none');
        } else {
            listView.classList.add('active');
            gridView.classList.remove('active');
            listContainer.classList.remove('d-none');
            gridContainer.classList.add('d-none');
        }
        
        this.displayProducts(this.filterProducts());
    },

    filterProducts() {
        const searchQuery = document.getElementById('searchProduct').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const stockFilter = document.getElementById('stockFilter').value;
        
        return this.products.filter(product => {
            const matchesSearch = product.name.toLowerCase().includes(searchQuery);
            const matchesCategory = !categoryFilter || product.category === categoryFilter;
            const matchesStock = this.matchesStockFilter(product, stockFilter);
            
            return matchesSearch && matchesCategory && matchesStock;
        });
    },

    matchesStockFilter(product, filter) {
        switch (filter) {
            case 'low':
                return product.stock <= product.alert_threshold;
            case 'medium':
                return product.stock > product.alert_threshold && product.stock <= product.alert_threshold * 2;
            case 'high':
                return product.stock > product.alert_threshold * 2;
            default:
                return true;
        }
    },

    displayProducts(products) {
        const gridContainer = document.getElementById('gridView');
        const listContainer = document.getElementById('productsTableBody');
        
        if (this.currentView === 'grid') {
            gridContainer.innerHTML = products.map(product => this.createProductCard(product)).join('');
        } else {
            listContainer.innerHTML = products.map(product => this.createProductRow(product)).join('');
        }
    },

    createProductCard(product) {
        const stockBadgeClass = this.getStockBadgeClass(product);
        return `
            <div class="product-card position-relative">
                <span class="stock-badge ${stockBadgeClass}">
                    ${product.stock} in stock
                </span>
                ${product.image ? 
                    `<img src="${product.image}" class="product-image" alt="${product.name}">` :
                    `<div class="product-image-placeholder"><i class="bi bi-image"></i></div>`
                }
                <div class="p-3">
                    <h5 class="mb-2">${product.name}</h5>
                    <p class="mb-2">${product.description || ''}</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="h5 mb-0">₱${parseFloat(product.price).toFixed(2)}</span>
                        <span class="badge ${product.status === 'active' ? 'bg-success' : 'bg-danger'}">
                            ${product.status}
                        </span>
                    </div>
                    <div class="btn-group w-100">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#productModal" data-action="edit" data-id="${product.id}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-outline-danger" onclick="ProductManager.deleteProduct(${product.id})">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        `;
    },

    createProductRow(product) {
        const stockBadgeClass = this.getStockBadgeClass(product);
        return `
            <tr>
                <td>
                    ${product.image ? 
                        `<img src="${product.image}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="${product.name}">` :
                        `<div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-image text-muted"></i>
                        </div>`
                    }
                </td>
                <td>
                    <div class="fw-bold">${product.name}</div>
                    <small class="text-muted">${product.description || ''}</small>
                </td>
                <td>${product.category}</td>
                <td>₱${parseFloat(product.price).toFixed(2)}</td>
                <td>
                    <span class="badge ${stockBadgeClass}">${product.stock} in stock</span>
                </td>
                <td>
                    <span class="badge ${product.status === 'active' ? 'bg-success' : 'bg-danger'}">
                        ${product.status}
                    </span>
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#productModal" data-action="edit" data-id="${product.id}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="ProductManager.deleteProduct(${product.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    },

    getStockBadgeClass(product) {
        if (product.stock <= product.alert_threshold) {
            return 'low-stock';
        } else if (product.stock <= product.alert_threshold * 2) {
            return 'medium-stock';
        } else {
            return 'high-stock';
        }
    },

    handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById('imagePreview');
                preview.innerHTML = `<img src="${e.target.result}" class="product-image" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        }
    },

    async loadProductForEdit(id) {
        try {
            const response = await api.get(`/api/products.php?id=${id}`);
            if (response.success) {
                const product = response.data;
                document.getElementById('productId').value = product.id;
                document.getElementById('name').value = product.name;
                document.getElementById('description').value = product.description || '';
                document.getElementById('category').value = product.category;
                document.getElementById('price').value = product.price;
                document.getElementById('stock').value = product.stock;
                document.getElementById('alertThreshold').value = product.alert_threshold;
                document.getElementById('status').value = product.status;
                
                if (product.image) {
                    const preview = document.getElementById('imagePreview');
                    preview.innerHTML = `<img src="${product.image}" class="product-image" alt="${product.name}">`;
                }
                
                document.getElementById('modalTitle').textContent = 'Edit Product';
            } else {
                this.showToast('Error loading product details', 'error');
            }
        } catch (error) {
            console.error('Error loading product:', error);
            this.showToast('Failed to load product details', 'error');
        }
    },

    async saveProduct() {
        const formData = new FormData();
        const productId = document.getElementById('productId').value;
        
        // Add all form fields to FormData
        formData.append('name', document.getElementById('name').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('category', document.getElementById('category').value);
        formData.append('price', document.getElementById('price').value);
        formData.append('stock', document.getElementById('stock').value);
        formData.append('alert_threshold', document.getElementById('alertThreshold').value);
        formData.append('status', document.getElementById('status').value);
        
        // Add image if selected
        const imageFile = document.getElementById('image').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }
        
        try {
            const response = await api.post('/api/products.php', formData, {
                method: productId ? 'PUT' : 'POST',
                headers: {
                    'X-Product-Id': productId
                }
            });
            
            if (response.success) {
                this.showToast(`Product ${productId ? 'updated' : 'added'} successfully`, 'success');
                bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
                this.loadProducts();
            } else {
                this.showToast(response.message || 'Error saving product', 'error');
            }
        } catch (error) {
            console.error('Error saving product:', error);
            this.showToast('Failed to save product', 'error');
        }
    },

    async deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            try {
                const response = await api.delete(`/api/products.php?id=${id}`);
                if (response.success) {
                    this.showToast('Product deleted successfully', 'success');
                    this.loadProducts();
                } else {
                    this.showToast('Error deleting product', 'error');
                }
            } catch (error) {
                console.error('Error deleting product:', error);
                this.showToast('Failed to delete product', 'error');
            }
        }
    },

    async exportProducts() {
        try {
            const response = await api.get('/api/products.php?export=true', {
                responseType: 'blob'
            });
            
            const blob = new Blob([response], { type: 'application/vnd.ms-excel' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `products_${new Date().toISOString().split('T')[0]}.xlsx`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        } catch (error) {
            console.error('Error exporting products:', error);
            this.showToast('Failed to export products', 'error');
        }
    },

    resetForm() {
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('modalTitle').textContent = 'Add Product';
        document.getElementById('imagePreview').innerHTML = `
            <div class="product-image-placeholder">
                <i class="bi bi-image"></i>
            </div>
        `;
    },

    showToast(message, type = 'info') {
        const toast = document.getElementById('toast');
        const toastBody = toast.querySelector('.toast-body');
        
        toast.classList.remove('bg-success', 'bg-danger', 'bg-info');
        switch (type) {
            case 'success':
                toast.classList.add('bg-success', 'text-white');
                break;
            case 'error':
                toast.classList.add('bg-danger', 'text-white');
                break;
            default:
                toast.classList.add('bg-info', 'text-white');
        }
        
        toastBody.textContent = message;
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => ProductManager.init());
