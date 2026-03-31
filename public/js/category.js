// Sample data
const products = [
  { id: 1, name: "Bond Maintenance Shampoo", brand: "Olaplex", price: 32, originalPrice: 38, rating: 4.8, reviews: 1240, image: "https://images.unsplash.com/photo-1625772299848-361b803ffa25?w=800", badge: "Best Seller", category: "Hair Care" },
  { id: 2, name: "Nutritive Bain Satin Shampoo", brand: "Kérastase", price: 42, rating: 4.7, reviews: 890, image: "https://images.unsplash.com/photo-1608248597788-3532597f0f3f?w=800", category: "Hair Care" },
  { id: 3, name: "Hydrating Shampoo", brand: "Moroccanoil", price: 28, rating: 4.6, reviews: 670, image: "https://images.unsplash.com/photo-1591370871779-8b446a82e7db?w=800", category: "Hair Care" },
  // ... more products with category field
];

let sortBy = 'featured';
let priceMin = 0;
let priceMax = 300;
let selectedBrands = [];
let minRating = 0;

// category from query
const params = new URLSearchParams(window.location.search);
const currentCategory = params.get('cat') || 'Hair Care';
// update page title/desc
const titleEl = document.getElementById('categoryTitle');
const descEl = document.getElementById('categoryDesc');
if (titleEl) titleEl.textContent = currentCategory;
if (descEl) descEl.textContent = `${currentCategory} products and accessories`;


const productsGrid = document.getElementById('productsGrid');
const productCount = document.getElementById('productCount');

function renderProducts() {
  let filtered = products.filter(p => {
    if (p.category && p.category !== currentCategory) return false;
    if (p.price < priceMin || p.price > priceMax) return false;
    if (selectedBrands.length > 0 && !selectedBrands.includes(p.brand)) return false;
    if (minRating > 0 && p.rating < minRating) return false;
    return true;
  });

  // Sorting
  if (sortBy === 'price-low')  filtered.sort((a,b) => a.price - b.price);
  if (sortBy === 'price-high') filtered.sort((a,b) => b.price - a.price);
  if (sortBy === 'rating')     filtered.sort((a,b) => b.rating - a.rating);
  // 'featured' = original order or custom logic

  productCount.textContent = filtered.length;

  productsGrid.innerHTML = '';
  filtered.forEach(product => {
    const card = document.createElement('div');
    card.className = 'product-card';
    card.dataset.productId = product.id;
    card.innerHTML = `
      <div class="product-image-wrapper">
        <img src="${product.image}" alt="${product.name}" loading="lazy" class="product-image">
        ${product.badge ? `<span class="product-badge">${product.badge}</span>` : ''}
        <button class="wishlist-btn" aria-label="Add to wishlist">
          <i data-lucide="heart"></i>
        </button>
        <div class="cart-overlay">
          <button class="add-to-cart-btn">
            <i data-lucide="shopping-bag"></i> Add to Cart
          </button>
        </div>
      </div>
      <div class="product-info">
        <span class="product-brand">${product.brand}</span>
        <h3 class="product-name"><a href="details.html?product=${product.id}">${product.name}</a></h3>
        <div class="product-rating">
          <i data-lucide="star" class="star-fill"></i>
          <span>${product.rating}</span>
          <span class="reviews">(${product.reviews})</span>
        </div>
        <div class="product-price">
          <span class="current-price">$${product.price.toFixed(2)}</span>
          ${product.originalPrice ? `<span class="original-price">$${product.originalPrice.toFixed(2)}</span>` : ''}
        </div>
      </div>
    `;
    productsGrid.appendChild(card);
  });

  lucide.createIcons();
}

// Filter & Sort listeners
document.getElementById('sortSelect').addEventListener('change', e => {
  sortBy = e.target.value;
  renderProducts();
});

// Mobile drawer
document.getElementById('openFilters').addEventListener('click', () => {
  document.getElementById('mobileFilters').classList.add('open');
});
document.getElementById('closeFilters').addEventListener('click', () => {
  document.getElementById('mobileFilters').classList.remove('open');
});

// Initial render
renderProducts();