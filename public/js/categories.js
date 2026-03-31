// Sample data – replace with your real categories array
const categories = [
  {
    id: 1,
    name: "Hair Care",
    description: "Shampoos, conditioners, masks & styling products for healthy, vibrant hair",
    href: "/hair-care",
    color: "#e0f2fe", // light blue
    icon: "scissors"   // Lucide icon name
  },
  {
    id: 2,
    name: "Perfumes",
    description: "Luxurious fragrances for everyday elegance and special occasions",
    href: "/perfumes",
    color: "#f3e8ff", // light purple
    icon: "spray-can"
  },
  {
    id: 3,
    name: "Skincare",
    description: "Cleansers, serums, moisturizers & treatments for glowing skin",
    href: "/skincare",
    color: "#ecfdf5", // light green
    icon: "sparkles"
  },
  {
    id: 4,
    name: "Makeup",
    description: "Premium cosmetics for natural looks and bold statements",
    href: "/makeup",
    color: "#fef2f2", // light rose
    icon: "palette"
  },
  {
    id: 5,
    name: "Lifestyle",
    description: "Curated essentials to complement your daily routine & well-being",
    href: "/lifestyle",
    color: "#f0f9ff", // very light cyan
    icon: "candle"
  }
];

document.addEventListener('DOMContentLoaded', () => {
  const grid = document.getElementById('categoryGrid');
  if (!grid) return;

  // optional limit attribute for previews (e.g. homepage)
  const limit = grid.dataset.limit ? parseInt(grid.dataset.limit, 10) : null;
  const list = limit ? categories.slice(0, limit) : categories;

  list.forEach(cat => {
    const card = document.createElement('a');
    // convert href to query param if internal
    if (cat.href.startsWith('/')) {
      card.href = `category.html?cat=${encodeURIComponent(cat.name)}`;
    } else {
      card.href = cat.href;
    }
    card.className = 'category-card';
    card.style.setProperty('--card-color', cat.color);

    card.innerHTML = `
      <div class="card-content">
        <div class="icon-wrapper">
          <i data-lucide="${cat.icon}" class="category-icon"></i>
        </div>
        <h3>${cat.name}</h3>
        <p>${cat.description}</p>
        <div class="shop-link">
          Shop Now <span class="arrow">→</span>
        </div>
      </div>
    `;

    grid.appendChild(card);
  });

  // Initialize Lucide icons for the newly added cards
  if (window.lucide) {
    lucide.createIcons();
  }

  // if we truncated, optionally add a link below the grid
  if (limit && categories.length > list.length) {
    // only append if header doesn't already include a link
    const header = grid.closest('section')?.querySelector('.section-header .view-more-link');
    if (!header) {
      const moreWrapper = document.createElement('div');
      moreWrapper.className = 'more-link-wrapper';
      moreWrapper.innerHTML = '<a href="categories.html" class="view-more-link">More categories →</a>';
      grid.parentNode.appendChild(moreWrapper);
    }
  }
});