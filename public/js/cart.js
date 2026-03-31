// Sample cart data structure
let cart = JSON.parse(localStorage.getItem('larinsCart')) || [
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

const cartItemsContainer = document.querySelector('.cart-items-column');
const emptyCartEl = document.getElementById('emptyCart');
const cartWithItemsEl = document.getElementById('cartWithItems');

const subtotalEl = document.getElementById('subtotal');
const discountLineEl = document.getElementById('discountLine');
const discountAmountEl = document.getElementById('discountAmount');
const shippingEl = document.getElementById('shipping');
const freeShippingHintEl = document.getElementById('freeShippingHint');
const toFreeShippingEl = document.getElementById('toFreeShipping');
const totalEl = document.getElementById('total');

const promoInput = document.getElementById('promoCode');
const applyBtn = document.getElementById('applyPromoBtn');
const promoMsg = document.getElementById('promoMessage');
const checkoutBtn = document.querySelector('.checkout-btn');

// helper to know if we're on the actual cart page
function isCartPage() {
    return window.location.pathname.endsWith('cart.html') || window.location.pathname.endsWith('/cart.html');
}

let promoApplied = false;
const DISCOUNT_RATE = 0.15;
const FREE_SHIPPING_THRESHOLD = 50;

function renderCart() {
  if (cart.length === 0) {
    emptyCartEl.classList.remove('hidden');
    cartWithItemsEl.classList.add('hidden');
    return;
  }

  emptyCartEl.classList.add('hidden');
  cartWithItemsEl.classList.remove('hidden');

  cartItemsContainer.innerHTML = '';

  cart.forEach(item => {
    const itemEl = document.createElement('div');
    itemEl.className = 'bg-card rounded-xl p-6 border border-border shadow-soft hover:shadow-card transition-shadow';
    itemEl.innerHTML = `
      <div class="flex gap-4">
        <div class="w-20 h-20 bg-muted rounded-lg overflow-hidden flex-shrink-0">
          <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">
        </div>
        <div class="flex-1 min-w-0">
          <div class="flex justify-between items-start mb-2">
            <div class="min-w-0 flex-1">
              <h3 class="font-semibold text-lg text-foreground truncate">${item.name}</h3>
              <p class="text-sm text-muted-foreground">Size: ${item.variant}</p>
              ${item.description ? `<p class="text-xs text-muted-foreground mt-1">${item.description}</p>` : ''}
            </div>
            <button class="w-8 h-8 flex items-center justify-center text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-full transition-colors ml-2" data-id="${item.id}" aria-label="Remove item">
              <i data-lucide="x" class="w-4 h-4"></i>
            </button>
          </div>
          <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
              <div class="flex items-center gap-2 border border-border rounded-lg">
                <button class="w-8 h-8 flex items-center justify-center text-muted-foreground hover:text-foreground hover:bg-muted transition-colors" data-id="${item.id}" data-change="-1">
                  <i data-lucide="minus" class="w-4 h-4"></i>
                </button>
                <span class="w-8 text-center font-medium">${item.quantity}</span>
                <button class="w-8 h-8 flex items-center justify-center text-muted-foreground hover:text-foreground hover:bg-muted transition-colors" data-id="${item.id}" data-change="1">
                  <i data-lucide="plus" class="w-4 h-4"></i>
                </button>
              </div>
            </div>
            <span class="font-bold text-lg text-foreground">$${(item.price * item.quantity).toFixed(2)}</span>
          </div>
        </div>
      </div>
    `;
    cartItemsContainer.appendChild(itemEl);
  });

  lucide.createIcons(); // re-init icons after dynamic content

  updateSummary();
}

function updateSummary() {
  const subtotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
  const discount = promoApplied ? subtotal * DISCOUNT_RATE : 0;
  const shipping = subtotal >= FREE_SHIPPING_THRESHOLD ? 0 : 8.99; // example
  const total = subtotal - discount + shipping;

  subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
  totalEl.textContent = `$${total.toFixed(2)}`;

  if (promoApplied) {
    discountLineEl.classList.remove('hidden');
    discountAmountEl.textContent = `-$${discount.toFixed(2)}`;
  } else {
    discountLineEl.classList.add('hidden');
  }

  if (shipping === 0) {
    shippingEl.textContent = 'Free';
    freeShippingHintEl.classList.add('hidden');
  } else {
    shippingEl.textContent = `$${shipping.toFixed(2)}`;
    freeShippingHintEl.classList.remove('hidden');
    toFreeShippingEl.textContent = (FREE_SHIPPING_THRESHOLD - subtotal).toFixed(2);
  }
}

function changeQuantity(id, delta) {
  const item = cart.find(i => i.id === id);
  if (!item) return;
  
  item.quantity = Math.max(1, item.quantity + delta);
  saveCart();
  renderCart();
  showToast('Quantity updated');
}

function removeItem(id) {
  cart = cart.filter(i => i.id !== id);
  saveCart();
  renderCart();
  showToast('Item removed');
}

function saveCart() {
  localStorage.setItem('larinsCart', JSON.stringify(cart));
  document.dispatchEvent(new Event('cartUpdated'));
}

function applyPromo() {
  const code = promoInput.value.trim().toUpperCase();
  if (code === 'LARINS15' || code === 'WELCOME15') { // example codes
    promoApplied = true;
    promoMsg.classList.remove('hidden');
    applyBtn.disabled = true;
    promoInput.disabled = true;
    renderCart();
  } else {
    alert('Invalid promo code');
  }
}

// Event delegation
document.addEventListener('click', e => {
  const target = e.target.closest('button');
  if (!target) return;

  const id = Number(target.dataset.id);
  const change = Number(target.dataset.change);

  if (target.classList.contains('qty-btn') && !isNaN(change)) {
    changeQuantity(id, change);
  }
  if (target.classList.contains('remove-btn')) {
    removeItem(id);
  }
  if (target.classList.contains('add-to-cart-btn')) {
    // custom data attributes or fallback example
    const card = target.closest('.product-card');
    if (card) {
      const pid = card.dataset.productId || card.querySelector('a')?.getAttribute('href')?.match(/product=(\d+)/)?.[1];
      const name = card.querySelector('.product-name')?.innerText || '';
      const price = parseFloat(card.querySelector('.current-price')?.innerText.replace('$','')) || 0;
      const image = card.querySelector('img')?.src;
      if (pid) {
        addToCart({ id: Number(pid), name, price, quantity:1, image });
      }
    }
  }
});

function addToCart(item) {
  const existing = cart.find(i => i.id === item.id);
  if (existing) existing.quantity += item.quantity;
  else cart.push(item);
  saveCart();
  renderCart();
  showToast('Added to cart');
}

if (applyBtn) {
  applyBtn.addEventListener('click', applyPromo);
}
if (checkoutBtn) {
  checkoutBtn.addEventListener('click', () => {
      if (isCartPage()) {
          // go to checkout to complete purchase
          window.location.href = 'checkout.html';
      } else {
          // already on checkout page or elsewhere; signal order creation
          document.dispatchEvent(new CustomEvent('cartCheckout', { detail: cart }));
      }
  });
}

// Initial render
renderCart();