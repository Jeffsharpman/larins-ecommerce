// similar to category.js but shows all products and handles global search
const products = [
  { id: 1, name: "Bond Maintenance Shampoo", brand: "Olaplex", price: 32, originalPrice: 38, rating: 4.8, reviews: 1240, image: "https://images.unsplash.com/photo-1625772299848-361b803ffa25?w=800", badge: "Best Seller" },
  { id: 2, name: "Nutritive Bain Satin Shampoo", brand: "Kérastase", price: 42, rating: 4.7, reviews: 890, image: "https://images.unsplash.com/photo-1608248597788-3532597f0f3f?w=800" },
  { id: 3, name: "Hydrating Shampoo", brand: "Moroccanoil", price: 28, rating: 4.6, reviews: 670, image: "https://images.unsplash.com/photo-1591370871779-8b446a82e7db?w=800" },
  // ... more products
];

let sortBy = 'featured';
let searchTerm = '';

// grab search from query string
const params = new URLSearchParams(window.location.search);
if (params.has('search')) {
    searchTerm = params.get('search').toLowerCase();
}

const productsGrid = document.getElementById('productsGrid');
const productCount = document.getElementById('productCount');

function renderProducts() {
  let filtered = products.filter(p => {
    if (searchTerm && !p.name.toLowerCase().includes(searchTerm) && !p.brand.toLowerCase().includes(searchTerm)) return false;
    return true;
  });

  if (sortBy === 'price-low')  filtered.sort((a,b) => a.price - b.price);
  if (sortBy === 'price-high') filtered.sort((a,b) => b.price - a.price);
  if (sortBy === 'rating')     filtered.sort((a,b) => b.rating - a.rating);

  productCount.textContent = filtered.length;

  productsGrid.innerHTML = '';
  filtered.forEach(product => {
    const card = document.createElement('div');
    card.className = 'bg-card rounded-xl overflow-hidden shadow-soft hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between min-h-96 group cursor-pointer';
    card.dataset.productId = product.id;
    card.innerHTML = `
      <div class="relative aspect-square bg-muted overflow-hidden">
        <img src="${product.image}" alt="${product.name}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
        ${product.badge ? `<span class="absolute top-3 left-3 px-2.5 py-1 text-xs font-medium bg-primary text-primary-foreground rounded-full">${product.badge}</span>` : ''}
        <button class="absolute top-3 right-3 w-9 h-9 bg-white/85 backdrop-blur-sm border-0 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-250 cursor-pointer hover:bg-white" aria-label="Add to wishlist">
          <i data-lucide="heart" class="w-4 h-4"></i>
        </button>
        <div class="absolute inset-x-0 bottom-0 w-full p-3 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <button class="w-full px-0 py-2.5 bg-primary text-primary-foreground border-0 rounded-lg font-semibold flex items-center justify-center gap-2 cursor-pointer hover:bg-gold-dark transition-colors duration-200 add-to-cart-btn">
            <i data-lucide="shopping-bag" class="w-4 h-4"></i> Add to Cart
          </button>
        </div>
      </div>
      <div class="p-4 flex-1 flex flex-col">
        <span class="text-sm text-muted-foreground mb-1">${product.brand}</span>
        <h3 class="text-lg font-semibold mb-2 line-clamp-2"><a href="details.html?product=${product.id}" class="hover:text-primary transition-colors">${product.name}</a></h3>
        <div class="flex items-center gap-1 mb-2">
          <div class="flex gap-1">
            <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
          </div>
          <span class="text-sm font-medium">${product.rating}</span>
          <span class="text-sm text-muted-foreground">(${product.reviews})</span>
        </div>
        <div class="mt-auto">
          <div class="flex items-center gap-2">
            <span class="text-xl font-bold text-foreground">$${product.price.toFixed(2)}</span>
            ${product.originalPrice ? `<span class="text-lg text-muted-foreground line-through">$${product.originalPrice.toFixed(2)}</span>` : ''}
          </div>
        </div>
      </div>
    `;
    productsGrid.appendChild(card);
  });

  lucide.createIcons();
}

// handlers
document.getElementById('sortSelect').addEventListener('change', e => {
  sortBy = e.target.value;
  renderProducts();
});

const searchInput = document.getElementById('globalSearch');
if (searchInput && searchTerm) searchInput.value = searchTerm;
searchInput.addEventListener('input', e => {
  searchTerm = e.target.value.trim().toLowerCase();
  renderProducts();
});

renderProducts();
