// sample product data (should match products.js entries)
const productData = {
  1: {
    id:1,name:"Bond Maintenance No.3 Hair Perfector",brand:"Olaplex",category:"Hair Care",price:32,originalPrice:38,
    rating:4.8,reviews:1240,
    images:[
      "https://images.unsplash.com/photo-1625772299848-361b803ffa25?w=800",
      "https://images.unsplash.com/photo-1608248597788-3532597f0f3f?w=800",
      "https://images.unsplash.com/photo-1591370871779-8b446a82e7db?w=800",
      "https://images.unsplash.com/photo-1615634576129-933cc6e0d0e0?w=800"
    ],
    description:"A multi-award winning, concentrated reparative treatment that rebuilds hair bonds from the inside out. Ideal for damaged hair caused by chemical processes, heat styling, and mechanical damage.",
    features:["Reduces breakage up to 68%","Improves elasticity & strength","Protects color & prevents dryness","Suitable for all hair types","Cruelty-free & vegan"]
  }
};

// utility to populate from id
function loadProduct() {
  const params = new URLSearchParams(window.location.search);
  const pid = params.get('product');
  if (!pid || !productData[pid]) return;
  const prod = productData[pid];

  // Update brand link
  const brandLink = document.getElementById('brandLink');
  if (brandLink) {
    brandLink.textContent = prod.brand;
    brandLink.href = `brand.html?brand=${encodeURIComponent(prod.brand)}`;
  }

  // Update category link
  const categoryLink = document.getElementById('categoryLink');
  if (categoryLink && prod.category) {
    categoryLink.textContent = prod.category;
    categoryLink.href = `category.html?cat=${encodeURIComponent(prod.category)}`;
  }

  // Update product title
  const titleElem = document.querySelector('h1');
  if (titleElem) titleElem.textContent = prod.name;

  // Update rating
  const ratingValue = document.querySelector('.rating-value');
  if (ratingValue) ratingValue.textContent = prod.rating;

  const reviewCount = document.querySelector('.review-count');
  if (reviewCount) reviewCount.textContent = `(${prod.reviews} reviews)`;

  // Update price
  const currentPrice = document.querySelector('.current-price');
  if (currentPrice) currentPrice.textContent = `$${prod.price.toFixed(2)}`;

  const originalPrice = document.querySelector('.original-price');
  if (originalPrice && prod.originalPrice) {
    originalPrice.textContent = `$${prod.originalPrice.toFixed(2)}`;
  }

  // Update description
  const description = document.querySelector('.description');
  if (description) description.textContent = prod.description;

  // Update features
  const featureList = document.querySelector('.feature-list');
  if (featureList) {
    featureList.innerHTML = '';
    prod.features.forEach(f => {
      const li = document.createElement('li');
      li.className = 'flex items-center gap-2';
      li.innerHTML = `<i data-lucide="check" class="w-4 h-4 text-green-500"></i>${f}`;
      featureList.appendChild(li);
    });
  }

  // Update images
  const mainImg = document.getElementById('mainImage');
  if (mainImg && prod.images && prod.images.length > 0) {
    mainImg.src = prod.images[0];
  }

  // Update thumbnails
  const thumbsContainer = document.querySelector('.grid.grid-cols-4');
  if (thumbsContainer && prod.images) {
    thumbsContainer.innerHTML = '';
    prod.images.forEach((src, i) => {
      const button = document.createElement('button');
      button.className = `aspect-square bg-muted rounded-lg overflow-hidden border-2 ${i === 0 ? 'border-primary' : 'border-transparent hover:border-primary'} transition-colors`;
      button.dataset.index = i;
      button.innerHTML = `<img src="${src.replace('w=800', 'w=200')}" alt="View ${i + 1}" class="w-full h-full object-cover" />`;
      thumbsContainer.appendChild(button);
    });
    initGallery();
  }
}

// Image gallery
function initGallery(){
  const mainImage = document.getElementById('mainImage');
  const thumbBtns = document.querySelectorAll('.grid.grid-cols-4 button');

  thumbBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      // Remove active border from all buttons
      thumbBtns.forEach(b => b.classList.remove('border-primary'));
      thumbBtns.forEach(b => b.classList.add('border-transparent'));

      // Add active border to clicked button
      btn.classList.remove('border-transparent');
      btn.classList.add('border-primary');

      // Update main image
      const img = btn.querySelector('img');
      if (img) {
        mainImage.src = img.src.replace('w=200', 'w=800');
      }
    });
  });
}

// Variant selection + price update
const variantBtns = document.querySelectorAll('.flex.gap-2 button');
variantBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    variantBtns.forEach(b => {
      b.classList.remove('bg-primary', 'text-primary-foreground');
      b.classList.add('bg-card', 'text-foreground', 'border-border');
    });
    btn.classList.remove('bg-card', 'text-foreground', 'border-border');
    btn.classList.add('bg-primary', 'text-primary-foreground');
    // You can update price here if variants have different prices
  });
});

// add to cart from details
const addBtn = document.querySelector('.flex.gap-3 .flex-1');
if (addBtn) {
  addBtn.addEventListener('click', () => {
    const params = new URLSearchParams(window.location.search);
    const pid = params.get('product');
    if (pid && productData[pid]) {
      addToCart(productData[pid]);
      showToast('Added to cart!');
    }
  });
}
      showToast('Added to cart!');
    }
  });
}
    const pid = params.get('product');
    if (pid && productData[pid]) {
      const prod = productData[pid];
      const item = { id: Number(pid), name: prod.name, price: prod.price, quantity, image: prod.images[0] };
      // use global addToCart if available
      if (typeof addToCart === 'function') addToCart(item);
    }
  });
}

// Quantity
let quantity = 1;
const qtyDisplay = document.getElementById('quantityDisplay');
document.getElementById('decreaseQty').addEventListener('click', () => {
  if (quantity > 1) {
    quantity--;
    qtyDisplay.textContent = quantity;
  }
});
document.getElementById('increaseQty').addEventListener('click', () => {
  quantity++;
  qtyDisplay.textContent = quantity;
});

// run loader
loadProduct();

// Tabs
const tabBtns = document.querySelectorAll('.flex.gap-1 button');
const tabContents = document.querySelectorAll('.space-y-6');

tabBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    // Update button styles
    tabBtns.forEach(b => {
      b.classList.remove('bg-primary', 'text-primary-foreground');
      b.classList.add('bg-muted', 'text-muted-foreground');
    });
    btn.classList.remove('bg-muted', 'text-muted-foreground');
    btn.classList.add('bg-primary', 'text-primary-foreground');

    // Update content visibility
    tabContents.forEach(c => c.classList.add('hidden'));
    if (btn.dataset.tab === 'description') {
      document.getElementById('description').classList.remove('hidden');
    } else if (btn.dataset.tab === 'reviews') {
      document.getElementById('reviews').classList.remove('hidden');
    }
  });
});