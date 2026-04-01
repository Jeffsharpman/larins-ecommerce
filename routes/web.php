<?php

use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\StripeController;
use App\Livewire\AboutPage;
use App\Livewire\AccountPage;
use App\Livewire\Auth\ForgetPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPage;
use App\Livewire\BrandDetailsPage;
use App\Livewire\BrandsPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CategoryDetailsPage;
use App\Livewire\CheckoutPage;
use App\Livewire\ContactPage;
use App\Livewire\ErrorPage;
use App\Livewire\FaqPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrdersDetailPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\PrivacyPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\ShippingPage;
use App\Livewire\SuccessPage;
use App\Livewire\TermsPage;
use App\Livewire\WishlistPage;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('index');
Route::get('/categories', CategoriesPage::class)->name('categories');
Route::get('/categories/{slug}', CategoryDetailsPage::class)->name('categories.show');
Route::get('/brands', BrandsPage::class)->name('brands');
Route::get('/brands/{slug}', BrandDetailsPage::class)->name('brands.show');
Route::get('/products', ProductsPage::class)->name('shop');
Route::get('/cart', CartPage::class)->name('cart');
Route::get('/products/{slug}', ProductDetailPage::class)->name('product.details');
Route::get('/error', ErrorPage::class);
Route::get('/about', AboutPage::class)->name('about');
Route::get('/account', AccountPage::class)->name('account');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/faq', FaqPage::class)->name('faq');
Route::get('/terms', TermsPage::class)->name('terms');
Route::get('/privacy', PrivacyPage::class)->name('privacy');
Route::get('/shipping', ShippingPage::class)->name('shipping');
Route::get('/wishlist', WishlistPage::class)->name('wishlist');

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class);
    Route::get('/forgot', ForgetPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPage::class)->name('password.reset');
});

Route::get('/cancel', CancelPage::class)->name('cancel');
Route::get('/success/{order_id}', SuccessPage::class)->name('success');

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        auth()->logout();

        return redirect()->to('/');
    });
    Route::get('/checkout', CheckoutPage::class)->middleware('verified');
    Route::get('/my-orders', MyOrdersPage::class)->name('my-orders')->middleware('verified');
    Route::get('/my-orders/{order_id}', MyOrdersDetailPage::class)->name('my-orders.show')->middleware('verified');
});

Route::middleware('verified')->group(function () {
    Route::get('/account', AccountPage::class)->name('account');
});

if (app(GeneralSettings::class)->maintenance_mode && ! request()->is('admin*')) {
    Route::get('/', function () {
        return view('errors.maintenance'); // Create a simple "Coming Soon" blade
    });
}

Route::prefix('checkout/paystack')->group(function () {
    Route::get('/callback', [PaystackController::class, 'callback'])->name('paystack.callback');
});

Route::post('/webhook/paystack', [PaystackController::class, 'webhook'])->name('paystack.webhook')->withoutMiddleware(['csrf']);

Route::prefix('checkout/stripe')->group(function () {
    Route::get('/success', [StripeController::class, 'success'])->name('stripe.success');
});

Route::post('/webhook/stripe', [StripeController::class, 'webhook'])->name('stripe.webhook')->withoutMiddleware(['csrf']);
