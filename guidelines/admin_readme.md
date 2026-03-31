To align with the high-end, editorial aesthetic of the **Larins Maison**, I have refactored your `admin.md` file. The language has been shifted from "Food Delivery/QuickBite" to "Luxury ERP & Archival Management," using the sophisticated terminology we've established for the project.

---

# 🏛️ Larins Maison | Enterprise Resource Planning (ERP)
**The Digital Heart of the Maison.** A high-performance, real-time ERP system engineered on **Laravel 11** and **Filament v3**. This backend governs the entire Larins ecosystem—from managing artisan brands to tracking high-value archival acquisitions and global logistics.

---

## 💎 Core Tech Stack
* **Framework:** Laravel 11 (The Architecture)
* **Admin Suite:** Filament v3 (TALL Stack: Tailwind, Alpine.js, Laravel, Livewire)
* **Database:** PostgreSQL (Production) / SQLite (Development)
* **Real-time Intelligence:** Laravel Reverb (WebSockets for Instant Notifications)
* **Performance Layer:** Redis + Laravel Horizon (Asynchronous Task Processing)
* **Security & RBAC:** Filament Shield (Spatie-powered Granular Permissions)

---

## 🛠️ Key Architectures

### 1. Real-Time Acquisition Alerts
The system utilizes **Laravel Reverb** to broadcast high-priority events. When a client secures an item (Acquisition) on the frontend, a `NewOrderNotification` is instantly dispatched, triggering a sophisticated Toast notification within the Filament Dashboard—eliminating the need for manual refreshes.

### 2. Document Automation (Invoicing & Certificates)
* **Engine:** `barryvdh/laravel-dompdf`
* **Workflow:** Authenticity Certificates and Invoices are rendered in-memory using bespoke Blade templates. They are dispatched via the queue to ensure the Admin UI remains fluid and responsive.
* **Audit Trail:** Every issued document is timestamped in the `invoiced_at` column, ensuring a permanent historical record.

### 3. Global Analytics & Visitor Flow
* **Maison Pulse:** A live visitor counter implemented via custom Middleware that "pings" a Redis/Cache key (`active_collector_{ip}`) with a 5-minute TTL.
* **Archival Exports:** Utilizing `maatwebsite/excel` with `FromQuery` implementation to handle large-scale inventory exports via database chunking for maximum efficiency.

### 4. Security & Sovereign Control
* **RBAC:** Granular access tiers managed via **Filament Shield**. Roles include `Curator` (Super Admin), `Maison Manager`, and `Staff`.
* **Activity Logs:** Powered by `spatie/laravel-activitylog`. Every "Dirty" change to Products, Orders, or Brand Profiles is logged with the responsible ID for total transparency.

---

## 📦 Installation & Setup

**Clone & Provision:**
```bash
git clone https://github.com/Jeffsharpman/larins_ecommerce.git
composer install
npm install && npm run build
```

**Environment & Security:**
```bash
cp .env.example .env
php artisan key:generate
```

**Database & Roles:**
```bash
php artisan migrate --seed
php artisan shield:install
php artisan shield:super-admin --user=1
```

**Live Services:**
```bash
php artisan reverb:start
php artisan queue:work
```

---

## 📈 Optimization Features
* **Filament Caching:** Optimized UI via `php artisan filament:optimize` for lightning-fast asset loading.
* **Visual Assets:** Integration of **Spatie Media Library** and Filament Image Editor for high-resolution product cropping and server-side thumbnail optimization.

---

## 💡 The Larins Roadmap
* [ ] **Paystack Integration:** Automated refund processing and secure payment initialization for NGN/USD.
* [ ] **WhatsApp Alerts:** Automated notifications for low-stock "Last Chance" items sent to Maison Managers.
* [ ] **Density Mapping:** Heatmaps for identifying high-density acquisition zones for logistics planning.

---

**Would you like me to help you create a custom "Dashboard Widget" for Filament that shows the "Total Value of Current Inventory" in ₦ directly on your home screen?**