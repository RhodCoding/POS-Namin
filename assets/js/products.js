// Product Management System
const ProductManager = {
    // Sample products data (for frontend development)
    sampleProducts: [
        { id: 1, name: 'Pandesal', price: 5.00, stock: 100, image: 'assets/images/products/pandesal.png' },
        { id: 2, name: 'Ensaymada', price: 20.00, stock: 50, image: 'assets/images/products/pandesal.png' },
        { id: 3, name: 'Chocolate Cake', price: 450.00, stock: 5, image: 'assets/images/products/pandesal.png' },
        { id: 4, name: 'Cheese Bread', price: 15.00, stock: 30, image: 'assets/images/products/pandesal.png' },
        { id: 5, name: 'Ube Cake', price: 500.00, stock: 3, image: 'assets/images/products/pandesal.png' },
        { id: 6, name: 'Spanish Bread', price: 10.00, stock: 40, image: 'assets/images/products/pandesal.png' }
    ],

    // Default product image
    defaultProductImage: 'assets/images/products/pandesal.png',
    selectedImage: null,

    // Initialize
    init() {
        this.loadProducts();
        this.setupEventListeners();
    },

    // Setup event listeners
    setupEventListeners() {
        // Image preview
        document.getElementById('productImage').addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const preview = document.querySelector('#imagePreview img');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    this.selectedImage = e.target.result; // Store the base64 image
                };
                reader.readAsDataURL(file);
            }
        });

        // Save product
        document.getElementById('saveProduct').addEventListener('click', () => {
            this.saveProduct();
        });

        // Reset form when modal is hidden
        document.getElementById('productModal').addEventListener('hidden.bs.modal', () => {
            this.resetForm();
        });

        // Search functionality
        document.getElementById('searchProduct').addEventListener('input', (e) => {
            this.searchProducts(e.target.value);
        });

        // Toggle view buttons
        document.getElementById('gridView').addEventListener('click', () => this.toggleView('grid'));
        document.getElementById('listView').addEventListener('click', () => this.toggleView('list'));
    },

    // Load products
    loadProducts() {
        // For now, using sample data
        this.displayProducts(this.sampleProducts);
    },

    // Toggle between grid and list view
    toggleView(view) {
        const gridBtn = document.getElementById('gridView');
        const listBtn = document.getElementById('listView');
        const gridView = document.getElementById('productsGrid');
        const tableView = document.getElementById('productsTable');

        if (view === 'grid') {
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            gridView.classList.remove('d-none');
            gridView.classList.add('row', 'row-cols-1', 'row-cols-md-3', 'g-4');
            tableView.classList.add('d-none');
        } else {
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            gridView.classList.add('d-none');
            tableView.classList.remove('d-none');
        }
    },

    // Display products
    displayProducts(products) {
        // Grid view
        const grid = document.getElementById('productsGrid');
        grid.innerHTML = '';

        // Table view
        const tableBody = document.querySelector('#productsTable tbody');
        tableBody.innerHTML = '';

        // Populate both views
        products.forEach(product => {
            // Grid view card
            const card = `
                <div class="col">
                    <div class="card h-100 product-item" data-id="${product.id}">
                        <img src="${product.image}" 
                             class="card-img-top" 
                             alt="${product.name}"
                             style="height: 200px; object-fit: cover;"
                             onerror="this.src='${this.defaultProductImage}'">
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text">
                                <strong>₱${product.price.toFixed(2)}</strong><br>
                                <small class="text-muted">Stock: ${product.stock}</small>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="btn-group w-100">
                                <button class="btn btn-sm btn-primary" onclick="ProductManager.editProduct(${product.id})">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="ProductManager.deleteProduct(${product.id})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            grid.insertAdjacentHTML('beforeend', card);

            // Table view row
            const row = `
                <tr>
                    <td>
                        <img src="${product.image}" 
                             alt="${product.name}" 
                             style="width: 50px; height: 50px; object-fit: cover;"
                             class="img-thumbnail"
                             onerror="this.src='${this.defaultProductImage}'">
                    </td>
                    <td>${product.name}</td>
                    <td>₱${product.price.toFixed(2)}</td>
                    <td>${product.stock}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-primary" onclick="ProductManager.editProduct(${product.id})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="ProductManager.deleteProduct(${product.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    },

    // Search products
    searchProducts(query) {
        const filteredProducts = this.sampleProducts.filter(product => 
            product.name.toLowerCase().includes(query.toLowerCase())
        );
        this.displayProducts(filteredProducts);
    },

    // Edit product
    editProduct(id) {
        const product = this.sampleProducts.find(p => p.id === id);
        if (product) {
            document.getElementById('productId').value = product.id;
            document.getElementById('productName').value = product.name;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productStock').value = product.stock;
            document.getElementById('imagePreview').src = product.image;
            document.getElementById('imagePreview').style.display = 'block';
            
            const modal = new bootstrap.Modal(document.getElementById('productModal'));
            modal.show();
        }
    },

    // Reset form
    resetForm() {
        document.getElementById('productId').value = '';
        document.getElementById('productName').value = '';
        document.getElementById('productPrice').value = '';
        document.getElementById('productStock').value = '';
        document.getElementById('productImage').value = '';
        const preview = document.querySelector('#imagePreview img');
        preview.src = '';
        preview.style.display = 'none';
        this.selectedImage = null;
        document.getElementById('productModalLabel').textContent = 'Add Product';
    },

    // Save product
    saveProduct() {
        const id = document.getElementById('productId').value;
        const name = document.getElementById('productName').value;
        const price = parseFloat(document.getElementById('productPrice').value);
        const stock = parseInt(document.getElementById('productStock').value);

        if (!name || isNaN(price) || isNaN(stock)) {
            alert('Please fill all fields correctly');
            return;
        }

        if (id) {
            // Update existing product
            const index = this.sampleProducts.findIndex(p => p.id === parseInt(id));
            if (index !== -1) {
                this.sampleProducts[index] = {
                    ...this.sampleProducts[index],
                    name,
                    price,
                    stock,
                    image: this.selectedImage || this.sampleProducts[index].image
                };
            }
        } else {
            // Add new product
            const newId = Math.max(...this.sampleProducts.map(p => p.id)) + 1;
            this.sampleProducts.push({
                id: newId,
                name,
                price,
                stock,
                image: this.selectedImage || this.defaultProductImage
            });
        }

        // Refresh display and close modal
        this.displayProducts(this.sampleProducts);
        bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
        this.showToast(id ? 'Product updated successfully!' : 'Product added successfully!');
    },

    // Show toast notification
    showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    },

    // Delete product
    deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            const index = this.sampleProducts.findIndex(p => p.id === id);
            if (index !== -1) {
                this.sampleProducts.splice(index, 1);
                this.loadProducts();
            }
        }
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => ProductManager.init());
