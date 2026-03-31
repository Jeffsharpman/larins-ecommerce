// orders.js - simple mock order history stored in localStorage
let orders = JSON.parse(localStorage.getItem('larinsOrders')) || [];
// normalize older orders without a status
orders = orders.map(o => ({ status: o.status || 'received', ...o }));

const STATUS_STEPS = ['received','paid','ready','transported','delivered','cancelled'];

function saveOrders() {
    localStorage.setItem('larinsOrders', JSON.stringify(orders));
}

function cancelOrder(orderId) {
    const order = orders.find(o => o.id === orderId);
    if (order && ['received', 'paid'].includes(order.status)) {
        order.status = 'cancelled';
        saveOrders();
        renderOrders();
        showToast('Order cancelled successfully!');
    }
}

// Make cancelOrder globally available
window.cancelOrder = cancelOrder;

function getStatusIcon(status) {
    const icons = {
        'received': 'inbox',
        'paid': 'credit-card',
        'ready': 'package',
        'transported': 'truck',
        'delivered': 'check-circle',
        'cancelled': 'x-circle'
    };
    return icons[status] || 'package';
}

function getStatusColor(status) {
    const colors = {
        'received': 'bg-blue-100 text-blue-600',
        'paid': 'bg-green-100 text-green-600',
        'ready': 'bg-yellow-100 text-yellow-600',
        'transported': 'bg-orange-100 text-orange-600',
        'delivered': 'bg-green-100 text-green-600',
        'cancelled': 'bg-red-100 text-red-600'
    };
    return colors[status] || 'bg-gray-100 text-gray-600';
}

function renderOrders() {
    const container = document.getElementById('ordersContainer');
    const emptyMessage = document.getElementById('emptyOrdersMessage');
    if (!container) return;
    if (orders.length === 0) {
        container.innerHTML = '';
        if (emptyMessage) emptyMessage.classList.remove('hidden');
        return;
    }
    if (emptyMessage) emptyMessage.classList.add('hidden');
    container.innerHTML = '';
    orders.forEach(order => {
        const statusIcon = getStatusIcon(order.status);
        const statusColor = getStatusColor(order.status);
        const el = document.createElement('div');
        el.className = 'bg-gradient-to-br from-card to-card/95 p-6 rounded-xl shadow-lg border border-border/50 hover:shadow-xl transition-all duration-200 backdrop-blur-sm';
        el.innerHTML = `
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 ${statusColor} rounded-lg flex items-center justify-center">
                        <i data-lucide="${statusIcon}" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Order #${order.id}</h3>
                        <p class="text-sm text-muted-foreground flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            ${new Date(order.date).toLocaleDateString()}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-lg font-bold text-primary">$${order.total.toFixed(2)}</div>
                    <div class="text-sm ${statusColor.replace('bg-', 'text-').replace('/10', '')} capitalize font-medium">${order.status}</div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                    <i data-lucide="package" class="w-4 h-4"></i>
                    <span>${order.items.length} item${order.items.length !== 1 ? 's' : ''}</span>
                </div>
                <div class="flex gap-2">
                    <a href="order-details.html?id=${order.id}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                        View Details
                    </a>
                    ${['received', 'paid'].includes(order.status) ? `<button class="inline-flex items-center gap-2 px-4 py-2 bg-destructive text-destructive-foreground rounded-lg hover:bg-destructive/90 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 ml-2" onclick="cancelOrder(${order.id})">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                        Cancel
                    </button>` : ''}
                </div>
            </div>

            <details class="mt-4">
                <summary class="cursor-pointer text-sm font-medium text-muted-foreground hover:text-foreground transition-colors flex items-center gap-2">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    View items (${order.items.length})
                </summary>
                <div class="mt-3 space-y-2">
                    ${order.items.map(item => `
                        <div class="flex items-center justify-between py-2 px-3 bg-muted/30 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-muted rounded-md flex items-center justify-center">
                                    <i data-lucide="box" class="w-4 h-4 text-muted-foreground"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">${item.name}</div>
                                    <div class="text-xs text-muted-foreground">Qty: ${item.quantity}</div>
                                </div>
                            </div>
                            <div class="text-sm font-medium">$${(item.price * item.quantity).toFixed(2)}</div>
                        </div>
                    `).join('')}
                </div>
            </details>
        `;
        container.appendChild(el);
    });
}

function renderOrderDetails(order) {
    const container = document.getElementById('orderDetailsContainer');
    if (!container || !order) return;

    const statusIcon = getStatusIcon(order.status);
    const statusColor = getStatusColor(order.status);

    container.innerHTML = `
        <!-- Order Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 ${statusColor} rounded-xl flex items-center justify-center">
                    <i data-lucide="${statusIcon}" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Order #${order.id}</h1>
                    <div class="flex flex-wrap gap-4 text-sm text-muted-foreground mt-2">
                        <span class="flex items-center gap-1">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            ${new Date(order.date).toLocaleString()}
                        </span>
                        <span class="flex items-center gap-1 capitalize">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                            <span class="${order.status === 'cancelled' ? 'text-destructive' : order.status === 'delivered' ? 'text-green-600' : 'text-primary'} font-medium">${order.status}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                            <span class="font-semibold text-lg text-primary">$${order.total.toFixed(2)}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Progress -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">
                <i data-lucide="route" class="w-5 h-5 text-primary"></i>
                Order Progress
            </h2>
            <div class="flex justify-between items-center">
                ${STATUS_STEPS.filter(step => step !== 'cancelled').map((step, index) => {
                    const isCompleted = STATUS_STEPS.indexOf(step) <= STATUS_STEPS.indexOf(order.status);
                    const isCurrent = STATUS_STEPS.indexOf(step) === STATUS_STEPS.indexOf(order.status);
                    const stepIcon = getStatusIcon(step);
                    const stepColor = getStatusColor(step);

                    return `
                        <div class="flex-1 text-center relative">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 ${isCompleted ? stepColor : 'bg-muted'} rounded-full flex items-center justify-center mb-3 shadow-md ${isCurrent ? 'ring-2 ring-primary ring-offset-2' : ''} transition-all duration-200">
                                    ${isCompleted ? `<i data-lucide="${stepIcon}" class="w-6 h-6"></i>` : `<span class="text-sm font-bold">${index + 1}</span>`}
                                </div>
                                <span class="text-sm font-medium capitalize ${isCompleted ? 'text-foreground' : 'text-muted-foreground'}">${step}</span>
                            </div>
                            ${index < STATUS_STEPS.filter(s => s !== 'cancelled').length - 1 ? `
                                <div class="absolute top-6 left-1/2 w-full h-0.5 ${isCompleted ? 'bg-primary' : 'bg-muted'} -z-10" style="transform: translateX(50%);"></div>
                            ` : ''}
                        </div>
                    `;
                }).join('')}
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2">
                <i data-lucide="shopping-cart" class="w-5 h-5 text-primary"></i>
                Order Items
            </h2>
            <div class="space-y-4">
                ${order.items.map(item => `
                    <div class="flex items-center gap-6 p-4 bg-gradient-to-r from-muted/20 to-muted/10 rounded-xl border border-border/30 hover:shadow-md transition-all duration-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="box" class="w-8 h-8 text-primary"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg mb-1">${item.name}</h3>
                            <div class="flex items-center gap-4 text-sm text-muted-foreground">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="hash" class="w-3 h-3"></i>
                                    Quantity: ${item.quantity}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="tag" class="w-3 h-3"></i>
                                    $${item.price.toFixed(2)} each
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-bold text-primary">$${(item.price * item.quantity).toFixed(2)}</div>
                            <div class="text-sm text-muted-foreground">Subtotal</div>
                        </div>
                    </div>
                `).join('')}
            </div>

            <!-- Order Total -->
            <div class="mt-6 pt-6 border-t border-border/50">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i data-lucide="receipt" class="w-5 h-5 text-primary"></i>
                        <span class="text-lg font-semibold">Order Total</span>
                    </div>
                    <div class="text-2xl font-bold text-primary">$${order.total.toFixed(2)}</div>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
        </div>
    `;

    // Add action buttons container
    const actionsContainer = document.createElement('div');
    actionsContainer.className = 'flex gap-4';

    // show button to advance status for demo
    if (order.status !== 'delivered' && order.status !== 'cancelled') {
        const btn = document.createElement('button');
        btn.className = 'inline-flex items-center gap-2 px-6 py-3 bg-secondary text-secondary-foreground rounded-xl hover:bg-secondary/80 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5';
        btn.innerHTML = '<i data-lucide="arrow-right" class="w-4 h-4"></i> Advance Status';
        btn.addEventListener('click', () => {
            const idx = STATUS_STEPS.indexOf(order.status);
            order.status = STATUS_STEPS[Math.min(idx + 1, STATUS_STEPS.length - 1)];
            saveOrders();
            renderOrderDetails(order);
            renderOrders();
        });
        actionsContainer.appendChild(btn);
    }

    // show cancel button if order can be cancelled
    if (['received', 'paid'].includes(order.status)) {
        const cancelBtn = document.createElement('button');
        cancelBtn.className = 'inline-flex items-center gap-2 px-6 py-3 bg-destructive text-destructive-foreground rounded-xl hover:bg-destructive/90 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5';
        cancelBtn.innerHTML = '<i data-lucide="x-circle" class="w-4 h-4"></i> Cancel Order';
        cancelBtn.addEventListener('click', () => {
            cancelOrder(order.id);
            renderOrderDetails(order);
        });
        actionsContainer.appendChild(cancelBtn);
    }

    if (actionsContainer.children.length > 0) {
        container.appendChild(actionsContainer);
    }
}

function getOrderFromUrl() {
    const params = new URLSearchParams(window.location.search);
    const id = parseInt(params.get('id'), 10);
    return orders.find(o => o.id === id);
}

// for demonstration create a fake order when cart is 'checked out'
document.addEventListener('cartCheckout', e => {
    const cart = e.detail || [];
    if (cart.length === 0) return;
    const total = cart.reduce((sum,i)=> sum + i.price*i.quantity,0);
    const newOrder = {
        id: orders.length + 1,
        date: Date.now(),
        items: cart,
        total,
        status: 'received'
    };
    orders.unshift(newOrder);
    saveOrders();
    renderOrders();
    showToast('Order placed successfully!');
    // notify others (checkout page will redirect based on this event)
    document.dispatchEvent(new CustomEvent('orderPlaced', { detail: newOrder }));
});

// initialise any order-specific UI on DOM load
document.addEventListener('DOMContentLoaded', () => {
    renderOrders();
    const detailsOrder = getOrderFromUrl();
    if (detailsOrder) {
        renderOrderDetails(detailsOrder);
    }
    // Handle order success page
    if (window.location.pathname.includes('order-success.html') && detailsOrder) {
        renderOrderDetails(detailsOrder);
    }
});
