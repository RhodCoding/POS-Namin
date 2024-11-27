// POS System Management for Employees
const POSManager = {
    // Sample products data (will be replaced with database data later)
    sampleProducts: [
        { id: 1, name: 'Pandesal', price: 5.00, stock: 100, image: '../assets/images/products/pandesal.png' },
        { id: 2, name: 'Ensaymada', price: 20.00, stock: 50, image: '../assets/images/products/pandesal.png' },
        { id: 3, name: 'Chocolate Cake', price: 450.00, stock: 5, image: '../assets/images/products/pandesal.png' },
        { id: 4, name: 'Cheese Bread', price: 15.00, stock: 30, image: '../assets/images/products/pandesal.png' },
        { id: 5, name: 'Ube Cake', price: 500.00, stock: 3, image: '../assets/images/products/pandesal.png' },
        { id: 6, name: 'Spanish Bread', price: 10.00, stock: 40, image: '../assets/images/products/pandesal.png' }
    ],

    // Default product image
    defaultProductImage: '../assets/images/products/default.png',

    // Cart data
    cart: [],

    // Initialize POS system
    init() {
        this.loadProducts();
        this.setupEventListeners();
        this.updateCartSummary();
    },

    // Load products into the grid
    loadProducts() {
        const grid = document.querySelector('#productsGrid');
        grid.innerHTML = '';

        this.sampleProducts.forEach(product => {
            const productHtml = `
                <div class="card product-item" data-id="${product.id}">
                    <img src="${product.image}" 
                         class="product-image card-img-top" 
                         alt="${product.name}"
                         onerror="this.src='${this.defaultProductImage}'">
                    <div class="card-body text-center">
                        <h6 class="card-title">${product.name}</h6>
                        <p class="card-text">₱${product.price.toFixed(2)}</p>
                        <small class="text-muted">Stock: ${product.stock}</small>
                    </div>
                </div>
            `;
            grid.insertAdjacentHTML('beforeend', productHtml);
        });
    },

    // Add item to cart
    addToCart(productId) {
        const product = this.sampleProducts.find(p => p.id === productId);
        if (!product) return;

        const cartItem = this.cart.find(item => item.id === productId);
        if (cartItem) {
            if (cartItem.quantity < product.stock) {
                cartItem.quantity++;
                this.updateCartDisplay();
                this.showToast(`Added another ${product.name} to cart`);
            } else {
                this.showToast('Not enough stock!', 'danger');
            }
        } else {
            this.cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                quantity: 1
            });
            this.updateCartDisplay();
            this.showToast(`Added ${product.name} to cart`);
        }
    },

    // Update cart display
    updateCartDisplay() {
        const cartBody = document.querySelector('#cartItems');
        cartBody.innerHTML = '';

        this.cart.forEach(item => {
            const total = item.price * item.quantity;
            const row = `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary decrease-qty" data-id="${item.id}">-</button>
                            <span class="btn btn-outline-secondary disabled">${item.quantity}</span>
                            <button class="btn btn-outline-secondary increase-qty" data-id="${item.id}">+</button>
                        </div>
                    </td>
                    <td>₱${item.price.toFixed(2)}</td>
                    <td>₱${total.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger remove-item" data-id="${item.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            cartBody.insertAdjacentHTML('beforeend', row);
        });

        this.updateCartSummary();
    },

    // Update cart summary
    updateCartSummary() {
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.querySelector('#subtotal').textContent = subtotal.toFixed(2);
        document.querySelector('#total').textContent = subtotal.toFixed(2);

        // Update payment modal total if it's open
        const totalAmountInput = document.querySelector('#totalAmount');
        if (totalAmountInput) {
            totalAmountInput.value = `₱${subtotal.toFixed(2)}`;
        }
    },

    // Process payment
    processPayment() {
        const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const cash = parseFloat(document.querySelector('#cashReceived').value) || 0;
        const change = cash - total;

        document.querySelector('#totalAmount').value = `₱${total.toFixed(2)}`;
        document.querySelector('#changeAmount').value = change >= 0 ? `₱${change.toFixed(2)}` : '';
        
        const completeBtn = document.querySelector('#completePaymentBtn');
        completeBtn.disabled = change < 0 || cash === 0;

        return { total, cash, change };
    },

    // Complete sale
    completeSale() {
        const { total, cash, change } = this.processPayment();
        
        if (cash >= total) {
            // Here we'll add database integration later
            this.showToast('Sale completed successfully!', 'success');
            this.clearCart();
            
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.querySelector('#paymentModal'));
            if (modal) {
                modal.hide();
            }

            // Reset payment form
            document.querySelector('#cashReceived').value = '';
            document.querySelector('#changeAmount').value = '';
        } else {
            this.showToast('Insufficient cash amount!', 'danger');
        }
    },

    // Clear cart
    clearCart() {
        this.cart = [];
        this.updateCartDisplay();
    },

    // Setup event listeners
    setupEventListeners() {
        // Product search
        document.querySelector('#searchProducts').addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                const name = item.querySelector('.card-title').textContent.toLowerCase();
                item.style.display = name.includes(searchTerm) ? '' : 'none';
            });
        });

        // Add to cart
        document.querySelector('#productsGrid').addEventListener('click', (e) => {
            const productCard = e.target.closest('.product-item');
            if (productCard) {
                const productId = parseInt(productCard.dataset.id);
                this.addToCart(productId);
            }
        });

        // Cart quantity controls and remove item
        document.querySelector('#cartItems').addEventListener('click', (e) => {
            const button = e.target.closest('button');
            if (!button) return;

            const productId = parseInt(button.dataset.id);
            const cartItem = this.cart.find(item => item.id === productId);
            const product = this.sampleProducts.find(p => p.id === productId);

            if (!cartItem) return;

            if (button.classList.contains('increase-qty')) {
                if (cartItem.quantity < product.stock) {
                    cartItem.quantity++;
                    this.updateCartDisplay();
                } else {
                    this.showToast('Not enough stock!', 'danger');
                }
            } else if (button.classList.contains('decrease-qty')) {
                if (cartItem.quantity > 1) {
                    cartItem.quantity--;
                    this.updateCartDisplay();
                }
            } else if (button.classList.contains('remove-item')) {
                this.cart = this.cart.filter(item => item.id !== productId);
                this.updateCartDisplay();
                this.showToast('Item removed from cart', 'warning');
            }
        });

        // Clear cart
        document.querySelector('#clearCartBtn').addEventListener('click', () => {
            if (this.cart.length === 0) {
                this.showToast('Cart is already empty!', 'warning');
                return;
            }
            if (confirm('Are you sure you want to clear the cart?')) {
                this.clearCart();
                this.showToast('Cart cleared', 'warning');
            }
        });

        // Checkout process
        document.querySelector('#checkoutBtn').addEventListener('click', () => {
            if (this.cart.length === 0) {
                this.showToast('Cart is empty!', 'warning');
                return;
            }
            // Reset payment form
            document.querySelector('#cashReceived').value = '';
            document.querySelector('#changeAmount').value = '';
            // Update total in modal
            this.updateCartSummary();
            // Show modal
            new bootstrap.Modal(document.querySelector('#paymentModal')).show();
        });

        // Process payment calculation
        document.querySelector('#cashReceived').addEventListener('input', () => {
            this.processPayment();
        });

        // Complete sale
        document.querySelector('#completePaymentBtn').addEventListener('click', () => {
            this.completeSale();
        });

        // Handle payment modal close
        document.querySelector('#paymentModal').addEventListener('hidden.bs.modal', () => {
            document.querySelector('#cashReceived').value = '';
            document.querySelector('#changeAmount').value = '';
        });
    },

    // Show toast notification
    showToast(message, type = 'success') {
        let toastContainer = document.querySelector('.toast-container');
        
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        const toast = new bootstrap.Toast(toastContainer.lastElementChild, {
            autohide: true,
            delay: 3000
        });
        toast.show();

        // Remove toast after it's hidden
        toastContainer.lastElementChild.addEventListener('hidden.bs.toast', function () {
            this.remove();
        });
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => POSManager.init());
