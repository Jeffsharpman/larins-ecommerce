// wishlist.js
// store wishlist in localStorage under key 'larinsWishlist'
let wishlist = JSON.parse(localStorage.getItem('larinsWishlist')) || [];

const wishlistContainer = document.getElementById('wishlistContainer');
const emptyMsg = document.getElementById('wishlistEmpty');

function renderWishlist() {
    if (!wishlistContainer) return;

    // Add dateAdded to existing items if not present
    wishlist.forEach(item => {
        if (!item.dateAdded) {
            item.dateAdded = Date.now();
        }
    });

    if (wishlist.length === 0) {
        emptyMsg?.classList.remove('hidden');
        // Show default items when wishlist is empty
        const defaultItems = wishlistContainer.querySelectorAll('[data-default-item]');
        defaultItems.forEach(item => item.style.display = 'block');
        wishlistContainer.classList.remove('hidden');
    } else {
        emptyMsg?.classList.add('hidden');
        // Hide default items when there are wishlist items
        const defaultItems = wishlistContainer.querySelectorAll('[data-default-item]');
        defaultItems.forEach(item => item.style.display = 'none');

        // Clear existing wishlist items (keep default items)
        const existingItems = wishlistContainer.querySelectorAll('.wishlist-item');
        existingItems.forEach(item => item.remove());

        // Render wishlist items
        wishlist.forEach(item => {
            const el = document.createElement('div');
            el.className = 'wishlist-item bg-card rounded-xl overflow-hidden shadow-soft border hover:shadow-card transition-all duration-300';
            el.innerHTML = `
                <div class="relative aspect-square bg-muted overflow-hidden group">
                    <img src="${item.image || 'https://via.placeholder.com/300x300?text=No+Image'}" alt="${item.name}"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <button class="absolute top-3 right-3 w-9 h-9 bg-white/85 backdrop-blur-sm border-0 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-250 remove-btn cursor-pointer" data-id="${item.id}" aria-label="Remove from wishlist">
                        <i data-lucide="x" class="w-5 h-5 text-destructive"></i>
                    </button>
                    <div class="absolute inset-x-0 bottom-0 w-full p-3 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="w-full px-0 py-2.5 bg-primary text-primary-foreground border-0 rounded-lg font-semibold flex items-center justify-center gap-2 cursor-pointer hover:bg-primary/90 transition-colors duration-200 move-to-cart-btn" data-id="${item.id}">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-primary font-medium">${item.brand || 'Brand'}</span>
                        <span class="text-xs text-muted-foreground">${item.category || 'Category'}</span>
                    </div>
                    <h3 class="text-sm font-medium mb-2">
                        <a href="details.html?product=${item.id}" class="text-foreground hover:text-primary no-underline">${item.name}</a>
                    </h3>
                    <div class="flex items-center gap-1 mb-3 text-xs">
                        <div class="flex gap-0.5">
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                            <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i>
                        </div>
                        <span>${item.rating || '4.5'}</span>
                        <span class="text-muted-foreground">(${item.reviews || '0'})</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="font-semibold text-foreground">${item.price || '$0.00'}</div>
                        <span class="text-xs text-primary font-medium">In Wishlist</span>
                    </div>
                </div>
            `;
            wishlistContainer.appendChild(el);
        });
    }

    // Update stats if function exists
    if (typeof updateWishlistStats === 'function') {
        updateWishlistStats();
    }

    // Re-create icons for new elements
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
}

function saveWishlist() {
    localStorage.setItem('larinsWishlist', JSON.stringify(wishlist));
}

function addToWishlist(item) {
    // Check if item already exists
    if (wishlist.find(i => i.id === item.id)) {
        if (typeof showToast === 'function') {
            showToast('Item already in wishlist', 'info');
        }
        return;
    }

    // Add dateAdded timestamp
    item.dateAdded = Date.now();

    wishlist.push(item);
    saveWishlist();
    renderWishlist();

    if (typeof showToast === 'function') {
        showToast('Added to wishlist');
    }
}

function removeFromWishlist(id) {
    wishlist = wishlist.filter(i => i.id !== id);
    saveWishlist();
    renderWishlist();

    if (typeof showToast === 'function') {
        showToast('Removed from wishlist');
    }
}

function moveToCart(id) {
    const idx = wishlist.findIndex(i => i.id === id);
    if (idx !== -1) {
        const item = wishlist[idx];
        // Dispatch custom event for cart integration
        document.dispatchEvent(new CustomEvent('addToCartFromWishlist', { detail: item }));
        removeFromWishlist(id);
    }
}

// Enhanced event delegation
if (wishlistContainer) {
    wishlistContainer.addEventListener('click', e => {
        const btn = e.target.closest('button');
        if (!btn) return;

        const id = Number(btn.dataset.id);

        if (btn.classList.contains('remove-btn')) {
            removeFromWishlist(id);
        }
        if (btn.classList.contains('move-to-cart-btn')) {
            moveToCart(id);
        }
    });
}

// Handle wishlist button clicks from product cards
document.addEventListener('click', e => {
    const target = e.target.closest('.wishlist-btn');
    if (target) {
        const card = target.closest('.product-card, [data-product-id]');
        if (card) {
            const pid = Number(card.dataset.productId);
            const name = card.querySelector('.product-name, h3')?.innerText || 'Product';
            const brand = card.querySelector('.product-brand, .text-primary')?.innerText || 'Brand';
            const category = card.querySelector('.text-muted-foreground')?.innerText || 'Category';
            const image = card.querySelector('img')?.src || '';
            const price = card.querySelector('.font-semibold, .text-foreground')?.innerText || '$0.00';
            const rating = card.querySelector('.flex.items-center.gap-1 span:first-child')?.innerText || '4.5';
            const reviews = card.querySelector('.text-muted-foreground')?.innerText?.replace(/[()]/g, '') || '0';

            addToWishlist({
                id: pid,
                name,
                brand,
                category,
                image,
                price,
                rating,
                reviews
            });
        }
    }
});

// Handle add to cart buttons on default items
document.addEventListener('click', e => {
    const target = e.target.closest('.add-to-cart-btn');
    if (target && !target.closest('.wishlist-item')) {
        // This is a default item add to cart button
        const card = target.closest('[data-default-item]');
        if (card) {
            const pid = Number(card.dataset.productId) || Math.floor(Math.random() * 10000);
            const name = card.querySelector('h3 a')?.innerText || 'Product';
            const brand = card.querySelector('.text-primary')?.innerText || 'Brand';
            const category = card.querySelector('.text-muted-foreground')?.innerText || 'Category';
            const image = card.querySelector('img')?.src || '';
            const price = card.querySelector('.font-semibold')?.innerText || '$0.00';

            // Add to cart (dispatch event)
            document.dispatchEvent(new CustomEvent('addToCartFromWishlist', {
                detail: { id: pid, name, brand, category, image, price }
            }));

            if (typeof showToast === 'function') {
                showToast('Added to cart');
            }
        }
    }
});

// Initialize wishlist on page load
document.addEventListener('DOMContentLoaded', () => {
    renderWishlist();
});
