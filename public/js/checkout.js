// checkout.js
const checkoutCart = JSON.parse(localStorage.getItem('larinsCart')) || [
  {
    id: 1,
    name: "Luxury Hair Serum Set",
    variant: "50ml",
    price: 48,
    quantity: 1,
    image: "https://images.unsplash.com/photo-1625772299848-361b803ffa25?w=400",
    description: "Premium hair treatment with argan oil"
  },
  {
    id: 2,
    name: "Amber Elegance Eau de Parfum",
    variant: "100ml",
    price: 92,
    quantity: 2,
    image: "https://images.unsplash.com/photo-1615634576129-933cc6e0d0e0?w=400",
    description: "Luxurious amber fragrance for everyday wear"
  },
  {
    id: 3,
    name: "Hydrating Facial Cream",
    variant: "30ml",
    price: 65,
    quantity: 1,
    image: "https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400",
    description: "Deep moisturizing cream for all skin types"
  }
];

function renderCheckoutSummary() {
    const container = document.getElementById('checkoutSummary');
    if (!container) return;

    let subtotal = 0;
    let shipping = 8.99;
    let tax = 0;

    container.innerHTML = `
        <h3 class="text-xl font-bold mb-6">Order Summary</h3>

        <!-- Order Items -->
        <div class="space-y-4 mb-6">
    `;

    checkoutCart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        container.innerHTML += `
            <div class="flex gap-3">
                <div class="w-12 h-12 bg-muted rounded-lg overflow-hidden flex-shrink-0">
                    <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-foreground text-sm truncate">${item.name}</p>
                    <p class="text-xs text-muted-foreground">${item.variant} × ${item.quantity}</p>
                    <p class="text-sm font-semibold text-foreground">$${itemTotal.toFixed(2)}</p>
                </div>
            </div>
        `;
    });

    // Calculate totals
    tax = subtotal * 0.08; // 8% tax
    const total = subtotal + shipping + tax;

    container.innerHTML += `
        </div>

        <!-- Order Totals -->
        <div class="border-t border-border pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Subtotal</span>
                <span class="text-foreground">$${subtotal.toFixed(2)}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Shipping</span>
                <span class="text-foreground">$${shipping.toFixed(2)}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-muted-foreground">Tax</span>
                <span class="text-foreground">$${tax.toFixed(2)}</span>
            </div>
            <div class="flex justify-between text-lg font-bold pt-2 border-t border-border">
                <span>Total</span>
                <span class="text-primary">$${total.toFixed(2)}</span>
            </div>
        </div>

        <!-- Place Order Button -->
        <button id="placeOrderBtn" class="w-full mt-6 px-6 py-3 bg-primary text-primary-foreground font-semibold rounded-lg hover:bg-gold-dark transition-colors flex items-center justify-center gap-2">
            <i data-lucide="credit-card" class="w-5 h-5"></i>
            Place Order
        </button>

        <!-- Security Notice -->
        <div class="mt-4 flex items-center gap-2 text-xs text-muted-foreground">
            <i data-lucide="lock" class="w-4 h-4"></i>
            <span>Secure checkout powered by Stripe</span>
        </div>
    `;
} 

document.addEventListener('DOMContentLoaded', () => {
    renderCheckoutSummary();
    const btn = document.getElementById('placeOrderBtn');
    btn?.addEventListener('click', () => {
        // fire the checkout event; orders.js will listen and create order
        document.dispatchEvent(new CustomEvent('cartCheckout', { detail: checkoutCart }));
    });

    document.addEventListener('orderPlaced', e => {
        // clear cart and redirect to success page
        localStorage.removeItem('larinsCart');
        window.location.href = `order-success.html?id=${e.detail.id}`;
    });
});