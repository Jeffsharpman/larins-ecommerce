Implementing a robust **Roles and Permissions** system in Filament (using the industry-standard **Spatie Laravel-Permission** package) is the final step in turning your application into a secure, multi-user enterprise platform.

For a project like **Larins**, you likely need roles like `Super Admin` (full access), `Manager` (can edit products/orders), and `Editor` (can only update content).

---

## 🔐 The Spatie + Filament Security Protocol

### 01. Initial Setup & Migration
First, install the package and publish the migrations.

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

**The Model Requirement:**
Add the `HasRoles` trait to your `User` model so Filament can check for permissions.

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles; // Critical for role checks
    // ...
}
```

---

### 02. The "Shield" approach (Recommended)
While you can manually code every gate, the **Filament Shield** package is the "Pro" way to handle Spatie. It automatically generates permissions for every Filament Resource you create.

**Install Shield:**
```bash
composer require bezhansalleh/filament-shield
php artisan shield:install
```

This command will:
1. Create a `Role` resource in your admin panel.
2. Generate permissions like `view_order`, `create_order`, `edit_order`, etc., for all your existing tables.

---

### 03. Enforcing Permissions on Resources
Once Shield is installed, you need to tell your Resources (like `OrderResource` or `ProductResource`) to respect these permissions. Change the trait in your Resource files:

```php
namespace App\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class OrderResource extends Resource implements HasShieldPermissions
{
    // Filament Shield will now automatically check if the 
    // logged-in user has 'view_order' or 'edit_order' permissions.
}
```

---

### 04. Advanced: Granular UI Control
Sometimes you want to hide specific **Fields** or **Actions** based on a role, rather than the whole page.

**Hiding a Form Field:**
```php
Forms\Components\TextInput::make('cost_price')
    ->visible(fn () => auth()->user()->hasRole('super_admin')), 
    // Only the big boss sees the raw cost
```

**Hiding a Table Action:**
```php
Tables\Actions\DeleteAction::make()
    ->hidden(fn () => !auth()->user()->can('delete_orders')),
```

---

### 05. The "Super Admin" Global Gate
To ensure you never lock yourself out, define a global gate in your `AuthServiceProvider.php`. This makes sure a `super_admin` role bypasses all checks.

```php
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::before(function ($user, $ability) {
        return $user->hasRole('super_admin') ? true : null;
    });
}
```

---

### 🏗️ Role Architecture Logic



| Role | Permissions | Filament Access |
| :--- | :--- | :--- |
| **Super Admin** | `*` (All) | Access to System Settings, Roles, and Logs. |
| **Manager** | `view`, `create`, `edit` | Can manage Inventory and Orders but cannot delete. |
| **Logistics** | `view_orders`, `edit_status` | Only sees the Shipping/Order modules. |

---

### 💡 Pro Tip: Customizing the "Access Denied" Experience
If a user tries to access a URL they aren't allowed to see, Filament will throw a 403. You can customize this in your `PanelProvider`:

```php
->renderHook(
    'panels::auth.login.before',
    fn () => view('auth.alerts.security-notice'),
)
```

**Would you like me to help you create a Seeder that automatically sets up your `super_admin` role and assigns it to your email so you're ready for production?**