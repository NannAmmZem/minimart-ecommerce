@extends('layouts.admin')

@section('title', 'Point of Sale (POS)')

@section('content')
<div class="pos-container">
    <!-- Top Bar with Stats -->
    <div class="pos-stats-bar">
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <div class="stat-label">Today's Sales</div>
                <div class="stat-value" id="todaySales">${{ number_format($todayStats['sales'], 2) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🛒</div>
            <div class="stat-info">
                <div class="stat-label">Transactions</div>
                <div class="stat-value" id="todayTransactions">{{ $todayStats['transactions'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <div class="stat-label">Items Sold</div>
                <div class="stat-value" id="todayItems">{{ $todayStats['items_sold'] }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏰</div>
            <div class="stat-info">
                <div class="stat-label">Time</div>
                <div class="stat-value" id="currentTime">--:--</div>
            </div>
        </div>
    </div>

    <div class="pos-layout">
        <!-- Left Side: Products -->
        <div class="pos-products-panel">
            <!-- Search Bar -->
            <div class="pos-search">
                <input type="text" id="productSearch" placeholder="🔍 Search products by name or scan barcode..." class="pos-search-input">
            </div>

            <!-- Category Filter -->
            <div class="pos-categories">
                <a href="{{ route('admin.pos.index') }}" class="category-btn {{ !$selectedCategory ? 'active' : '' }}">
                    All
                </a>
                @foreach($categories as $category)
                <a href="{{ route('admin.pos.index', ['category' => $category->id]) }}" 
                   class="category-btn {{ $selectedCategory == $category->id ? 'active' : '' }}">
                    {{ $category->name }} ({{ $category->products_count }})
                </a>
                @endforeach
            </div>

            <!-- Products Grid -->
            <div class="pos-products-grid" id="productsGrid">
                @foreach($products as $product)
                <div class="pos-product-card" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock_quantity }})">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="product-placeholder">📦</div>
                        @endif
                        @if($product->stock_quantity <= $product->low_stock_alert)
                            <span class="low-stock-badge">Low Stock</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <h4>{{ $product->name }}</h4>
                        <p class="product-category">{{ $product->category->name }}</p>
                        <div class="product-footer">
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                            <span class="product-stock">{{ $product->stock_quantity }} in stock</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Side: Cart & Checkout -->
        <div class="pos-cart-panel">
            <div class="pos-cart-header">
                <h2>🛒 Current Sale</h2>
                <div class="cart-actions">
                    <button onclick="holdTransaction()" class="btn-icon" title="Hold Transaction">📋</button>
                    <button onclick="showHeldTransactions()" class="btn-icon" title="Held Transactions">📌</button>
                    <button onclick="clearCart()" class="btn-icon btn-danger" title="Clear Cart">🗑️</button>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="pos-cart-items" id="cartItems">
                <div class="empty-cart">
                    <div class="empty-cart-icon">🛒</div>
                    <p>Cart is empty</p>
                    <p class="text-muted">Add products to start a sale</p>
                </div>
            </div>

            <!-- Cart Footer -->
            <div class="pos-cart-footer">
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="cartSubtotal">$0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax (0%)</span>
                        <span id="cartTax">$0.00</span>
                    </div>
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span id="cartTotal">$0.00</span>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button onclick="showCheckoutModal()" class="btn-checkout" id="checkoutBtn" disabled>
                    💳 Checkout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="pos-modal">
    <div class="pos-modal-content">
        <div class="pos-modal-header">
            <h2>💳 Complete Payment</h2>
            <button onclick="closeCheckoutModal()" class="modal-close">&times;</button>
        </div>
        <div class="pos-modal-body">
            <div class="checkout-total">
                <h3>Total Amount</h3>
                <div class="checkout-amount" id="checkoutTotal">$0.00</div>
            </div>

            <div class="form-group">
                <label>Payment Method</label>
                <div class="payment-methods">
                    <button onclick="selectPaymentMethod('cash')" class="payment-btn active" data-method="cash">
                        💵 Cash
                    </button>
                    <button onclick="selectPaymentMethod('card')" class="payment-btn" data-method="card">
                        💳 Card
                    </button>
                    <button onclick="selectPaymentMethod('mobile_money')" class="payment-btn" data-method="mobile_money">
                        📱 Mobile Money
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>Customer Name (Optional)</label>
                <input type="text" id="customerName" class="form-input" placeholder="Walk-in Customer">
            </div>

            <div class="form-group">
                <label>Customer Phone (Optional)</label>
                <input type="text" id="customerPhone" class="form-input" placeholder="+1234567890">
            </div>

            <div class="form-group">
                <label>Amount Paid</label>
                <input type="number" id="amountPaid" class="form-input amount-input" placeholder="0.00" step="0.01" min="0">
            </div>

            <div class="change-display" id="changeDisplay" style="display: none;">
                <span>Change:</span>
                <span class="change-amount" id="changeAmount">$0.00</span>
            </div>

            <div class="form-group">
                <label>Notes (Optional)</label>
                <textarea id="saleNotes" class="form-input" rows="2" placeholder="Add any notes..."></textarea>
            </div>
        </div>
        <div class="pos-modal-footer">
            <button onclick="closeCheckoutModal()" class="btn-secondary">Cancel</button>
            <button onclick="completeSale()" class="btn-primary" id="completeSaleBtn">Complete Sale</button>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div id="receiptModal" class="pos-modal">
    <div class="pos-modal-content">
        <div class="pos-modal-header">
            <h2>🧾 Receipt</h2>
            <button onclick="closeReceiptModal()" class="modal-close">&times;</button>
        </div>
        <div class="pos-modal-body">
            <div id="receiptContent"></div>
        </div>
        <div class="pos-modal-footer">
            <button onclick="printReceipt()" class="btn-secondary">🖨️ Print</button>
            <button onclick="closeReceiptModal()" class="btn-primary">New Sale</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/pos.css') }}">
<script src="{{ asset('js/pos.js') }}"></script>

<script>
// Initialize POS
const POS = {
    cart: [],
    selectedPaymentMethod: 'cash',
    updateInterval: null
};

// Add product to cart
function addToCart(productId, productName, price, stock) {
    if (stock <= 0) {
        alert('This product is out of stock!');
        return;
    }

    const existingItem = POS.cart.find(item => item.product_id === productId);
    
    if (existingItem) {
        if (existingItem.quantity >= stock) {
            alert(`Only ${stock} units available!`);
            return;
        }
        existingItem.quantity++;
    } else {
        POS.cart.push({
            product_id: productId,
            name: productName,
            price: parseFloat(price),
            quantity: 1,
            stock: stock
        });
    }
    
    renderCart();
    playSound('beep');
}

// Remove item from cart
function removeFromCart(productId) {
    POS.cart = POS.cart.filter(item => item.product_id !== productId);
    renderCart();
}

// Update quantity
function updateQuantity(productId, change) {
    const item = POS.cart.find(item => item.product_id === productId);
    if (!item) return;
    
    const newQuantity = item.quantity + change;
    
    if (newQuantity <= 0) {
        removeFromCart(productId);
        return;
    }
    
    if (newQuantity > item.stock) {
        alert(`Only ${item.stock} units available!`);
        return;
    }
    
    item.quantity = newQuantity;
    renderCart();
}

// Render cart
function renderCart() {
    const cartItems = document.getElementById('cartItems');
    const checkoutBtn = document.getElementById('checkoutBtn');
    
    if (POS.cart.length === 0) {
        cartItems.innerHTML = `
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <p>Cart is empty</p>
                <p class="text-muted">Add products to start a sale</p>
            </div>
        `;
        checkoutBtn.disabled = true;
        updateCartTotals();
        return;
    }
    
    checkoutBtn.disabled = false;
    
    cartItems.innerHTML = POS.cart.map(item => `
        <div class="cart-item">
            <div class="cart-item-info">
                <h4>${item.name}</h4>
                <p class="cart-item-price">$${item.price.toFixed(2)} each</p>
            </div>
            <div class="cart-item-controls">
                <div class="quantity-controls">
                    <button onclick="updateQuantity(${item.product_id}, -1)" class="qty-btn">-</button>
                    <span class="quantity">${item.quantity}</span>
                    <button onclick="updateQuantity(${item.product_id}, 1)" class="qty-btn">+</button>
                </div>
                <div class="cart-item-total">$${(item.price * item.quantity).toFixed(2)}</div>
                <button onclick="removeFromCart(${item.product_id})" class="btn-remove">×</button>
            </div>
        </div>
    `).join('');
    
    updateCartTotals();
}

// Update cart totals
function updateCartTotals() {
    const subtotal = POS.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = 0; // Add tax calculation if needed
    const total = subtotal + tax;
    
    document.getElementById('cartSubtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('cartTax').textContent = '$' + tax.toFixed(2);
    document.getElementById('cartTotal').textContent = '$' + total.toFixed(2);
}

// Clear cart
function clearCart() {
    if (POS.cart.length === 0) return;
    
    if (confirm('Clear cart? This will remove all items.')) {
        POS.cart = [];
        renderCart();
    }
}

// Show checkout modal
function showCheckoutModal() {
    if (POS.cart.length === 0) return;
    
    const total = POS.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('checkoutTotal').textContent = '$' + total.toFixed(2);
    document.getElementById('amountPaid').value = total.toFixed(2);
    document.getElementById('checkoutModal').style.display = 'flex';
    
    // Focus on amount paid
    setTimeout(() => document.getElementById('amountPaid').select(), 100);
}

// Close checkout modal
function closeCheckoutModal() {
    document.getElementById('checkoutModal').style.display = 'none';
}

// Select payment method
function selectPaymentMethod(method) {
    POS.selectedPaymentMethod = method;
    document.querySelectorAll('.payment-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.method === method);
    });
}

// Calculate change
document.getElementById('amountPaid')?.addEventListener('input', function() {
    const total = POS.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const paid = parseFloat(this.value) || 0;
    const change = paid - total;
    
    const changeDisplay = document.getElementById('changeDisplay');
    const changeAmount = document.getElementById('changeAmount');
    
    if (change >= 0) {
        changeDisplay.style.display = 'flex';
        changeAmount.textContent = '$' + change.toFixed(2);
        changeAmount.style.color = change > 0 ? '#2ecc71' : '#333';
    } else {
        changeDisplay.style.display = 'none';
    }
});

// Complete sale
async function completeSale() {
    if (POS.cart.length === 0) return;
    
    const total = POS.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const amountPaid = parseFloat(document.getElementById('amountPaid').value) || 0;
    
    if (amountPaid < total) {
        alert('Amount paid is less than total!');
        return;
    }
    
    const btn = document.getElementById('completeSaleBtn');
    btn.disabled = true;
    btn.textContent = 'Processing...';
    
    try {
        const response = await fetch('{{ route("admin.pos.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                items: POS.cart,
                customer_name: document.getElementById('customerName').value,
                customer_phone: document.getElementById('customerPhone').value,
                payment_method: POS.selectedPaymentMethod,
                amount_paid: amountPaid,
                notes: document.getElementById('saleNotes').value
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            playSound('success');
            showReceipt(data.order, data.change);
            POS.cart = [];
            renderCart();
            closeCheckoutModal();
            updateStats();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Error processing sale: ' + error.message);
    } finally {
        btn.disabled = false;
        btn.textContent = 'Complete Sale';
    }
}

// Show receipt
function showReceipt(order, change) {
    const receiptContent = document.getElementById('receiptContent');
    receiptContent.innerHTML = `
        <div class="receipt">
            <h2>Mini Mart</h2>
            <p>Thank you for your purchase!</p>
            <div class="receipt-divider"></div>
            <p><strong>Order #:</strong> ${order.order_number}</p>
            <p><strong>Date:</strong> ${new Date().toLocaleString()}</p>
            <div class="receipt-divider"></div>
            <table class="receipt-items">
                ${order.items.map(item => `
                    <tr>
                        <td>${item.product.name}</td>
                        <td>${item.quantity} x $${parseFloat(item.price).toFixed(2)}</td>
                        <td>$${(item.quantity * parseFloat(item.price)).toFixed(2)}</td>
                    </tr>
                `).join('')}
            </table>
            <div class="receipt-divider"></div>
            <p class="receipt-total"><strong>Total:</strong> $${parseFloat(order.total_amount).toFixed(2)}</p>
            <p><strong>Paid:</strong> $${(parseFloat(order.total_amount) + change).toFixed(2)}</p>
            <p><strong>Change:</strong> $${change.toFixed(2)}</p>
            <div class="receipt-divider"></div>
            <p class="text-center">Visit us again!</p>
        </div>
    `;
    document.getElementById('receiptModal').style.display = 'flex';
}

// Close receipt modal
function closeReceiptModal() {
    document.getElementById('receiptModal').style.display = 'none';
}

// Print receipt
function printReceipt() {
    window.print();
}

// Update current time
function updateTime() {
    const now = new Date();
    const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    document.getElementById('currentTime').textContent = timeStr;
}
setInterval(updateTime, 1000);
updateTime();

// Update stats
async function updateStats() {
    try {
        const response = await fetch('{{ route("admin.pos.stats") }}');
        const data = await response.json();
        
        document.getElementById('todaySales').textContent = '$' + data.today.sales.toFixed(2);
        document.getElementById('todayTransactions').textContent = data.today.transactions;
        document.getElementById('todayItems').textContent = data.today.items_sold;
    } catch (error) {
        console.error('Error updating stats:', error);
    }
}

// Auto-update stats every 30 seconds
setInterval(updateStats, 30000);

// Product search
let searchTimeout;
document.getElementById('productSearch').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const query = e.target.value;
        if (query.length >= 2) {
            searchProducts(query);
        }
    }, 300);
});

async function searchProducts(query) {
    try {
        const response = await fetch(`{{ route('admin.pos.search') }}?q=${encodeURIComponent(query)}`);
        const products = await response.json();
        renderSearchResults(products);
    } catch (error) {
        console.error('Error searching products:', error);
    }
}

function renderSearchResults(products) {
    const grid = document.getElementById('productsGrid');
    // Render products in grid...
}

// Play sound effects
function playSound(type) {
    // Add sound effects here if needed
    console.log('Sound:', type);
}

// Hold transaction
function holdTransaction() {
    if (POS.cart.length === 0) {
        alert('Cart is empty!');
        return;
    }
    
    const holdName = prompt('Enter a name for this transaction:');
    if (!holdName) return;
    
    // Save to session/local storage
    fetch('{{ route("admin.pos.hold") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            items: POS.cart,
            hold_name: holdName
        })
    }).then(() => {
        alert('Transaction held successfully!');
        POS.cart = [];
        renderCart();
    });
}

// Show held transactions
function showHeldTransactions() {
    // Implement held transactions list
    alert('Feature coming soon!');
}

// Initialize
renderCart();
</script>

@endsection
