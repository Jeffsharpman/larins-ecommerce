<?php

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
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\ReviewsPage;
use App\Livewire\SuccessPage;
use App\Livewire\TermsPage;
use App\Livewire\WishlistPage;
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
Route::get('/reviews', ReviewsPage::class)->name('reviews');
Route::get('/terms', TermsPage::class)->name('terms');
Route::get('/wishlist', WishlistPage::class)->name('wishlist');


Route::middleware('guest')->group(function (){
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class);
    Route::get('/forgot', ForgetPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPage::class)->name('password.reset');
});

Route::middleware('auth')->group(function (){
    Route::get('/logout', function (){
        auth()->logout();
        return redirect()->to('/');
    });
    Route::get('/checkout', CheckoutPage::class);
    Route::get('/my-orders', MyOrdersPage::class)->name('my-orders');
    Route::get('/my-orders/{order_id}', MyOrdersDetailPage::class)->name('my-orders.show');
    Route::get('/cancel', CancelPage::class)->name('cancel');
    Route::get('/success/{order_id}', SuccessPage::class)->name('success');
});


if (app(App\Settings\GeneralSettings::class)->maintenance_mode && !request()->is('admin*')) {
    Route::get('/', function () {
        return view('errors.maintenance'); // Create a simple "Coming Soon" blade
    });
}