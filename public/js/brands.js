// brands.js handles both brands list page and single brand view

// sample brands data; you can expand with logos, descriptions, etc.
const brandsData = [
  {
    name: "Olaplex",
    description: "Innovative hair care science focused on repairing and protecting.",
    tagline: "Hair Repair Experts",
    founded: "2014",
    specialty: "Bond Building Technology"
  },
  {
    name: "Kérastase",
    description: "Luxury haircare from L'Oréal worth of salon-quality treatments.",
    tagline: "Salon Luxury at Home",
    founded: "1964",
    specialty: "Professional Hair Care"
  },
  {
    name: "Moroccanoil",
    description: "Argan oil-infused products that restore shine and strength.",
    tagline: "The Oil Your Hair Deserves",
    founded: "2002",
    specialty: "Argan Oil Formulations"
  },
  {
    name: "Aveda",
    description: "Plant-based formulas rooted in Ayurvedic traditions.",
    tagline: "Pure, Plant-Based Beauty",
    founded: "1978",
    specialty: "Natural & Organic Beauty"
  },
  {
    name: "Briogeo",
    description: "Clean, naturally derived hair products formulated for all.",
    tagline: "Clean Beauty for All Hair",
    founded: "2013",
    specialty: "Clean & Sustainable Beauty"
  }
];

// helper to get unique brands from products list (if products.js loaded first)
function getUniqueBrands() {
    if (window.products) {
        const unique = [...new Set(products.map(p => p.brand))];
        return unique;
    }
    return brandsData.map(b => b.name);
}

// page detection
const isBrandsList = document.body.classList.contains('brands-list-page') || document.getElementById('brandsGrid');
const isBrandDetail = document.body.classList.contains('brand-detail-page') || document.getElementById('brandTitle');

function renderBrandsListing() {
    const grid = document.getElementById('brandsGrid');
    if (!grid) return;
    grid.innerHTML = '';
    const names = getUniqueBrands();
    // apply optional limit attribute
    const limit = grid.dataset.limit ? parseInt(grid.dataset.limit, 10) : null;
    const list = limit ? names.slice(0, limit) : names;
    list.forEach(name => {
        const info = brandsData.find(b => b.name === name) || {
            name,
            description: '',
            tagline: 'Premium Beauty Brand',
            specialty: 'Quality Products'
        };
        const card = document.createElement('a');
        card.href = `brand.html?brand=${encodeURIComponent(name)}`;
        card.className = 'brand-card';
        card.innerHTML = `
            <div class="brand-content">
                <div class="brand-header">
                    <div class="brand-icon">
                        <i data-lucide="award" class="w-6 h-6"></i>
                    </div>
                    <div class="brand-meta">
                        <span class="brand-tagline">${info.tagline || 'Premium Brand'}</span>
                        <span class="brand-specialty">${info.specialty || 'Quality Products'}</span>
                    </div>
                </div>
                <h3>${name}</h3>
                <p>${info.description}</p>
                <div class="brand-link">
                    <span>Explore Products</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });

    // Initialize icons for the new cards
    if (window.lucide) {
        lucide.createIcons();
    }

    if (limit && names.length > list.length) {
        const header = grid.closest('section')?.querySelector('.section-header .view-more-link');
        if (!header) {
            const moreWrapper = document.createElement('div');
            moreWrapper.className = 'more-link-wrapper';
            moreWrapper.innerHTML = '<a href="brands.html" class="view-more-link">More brands →</a>';
            grid.parentNode.appendChild(moreWrapper);
        }
    }
}

function renderBrandPage() {
    const params = new URLSearchParams(window.location.search);
    const current = params.get('brand');
    if (!current) return;
    // set title/desc
    const titleEl = document.getElementById('brandTitle');
    const descEl = document.getElementById('brandDesc');
    if (titleEl) titleEl.textContent = current;
    const info = brandsData.find(b => b.name === current);
    if (descEl) descEl.textContent = info ? info.description : '';

    // reuse category/product display but filter by brand
    let sortBy = 'featured';
    const productsGrid = document.getElementById('productsGrid');
    const productCount = document.getElementById('productCount');

    function renderProducts() {
        let filtered = products.filter(p => p.brand === current);
        if (sortBy === 'price-low')  filtered.sort((a,b) => a.price - b.price);
        if (sortBy === 'price-high') filtered.sort((a,b) => b.price - a.price);
        if (sortBy === 'rating')     filtered.sort((a,b) => b.rating - a.rating);

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

    document.getElementById('sortSelect').addEventListener('change', e => {
        sortBy = e.target.value;
        renderProducts();
    });

    renderProducts();
}

if (isBrandsList) renderBrandsListing();
if (isBrandDetail) renderBrandPage();

// when on listing page we might also want to load icons
