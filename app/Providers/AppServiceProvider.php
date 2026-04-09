<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\ProductVariantObserver;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        ini_set('max_execution_time', '300');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        Brand::observe(BrandObserver::class);
        Category::observe(CategoryObserver::class);
        ProductVariant::observe(ProductVariantObserver::class);
        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        View::composer('*', function ($view) {
            $view->with('site', app(GeneralSettings::class));
        });

    }
}
