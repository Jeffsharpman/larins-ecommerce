<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use App\Models\Review;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail')]
class ProductDetailPage extends Component
{
    public $slug;

    public $quantity = 1;

    public $product;

    public $reviews;

    public $averageRating = 0;

    public $totalReviews = 0;

    public $ratingCounts = [];

    public $showReviewForm = false;

    #[Title('Leave a Review')]
    public $review_title;

    public $review_rating = 5;

    public $review_comment;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadProduct();
    }

    public function loadProduct()
    {
        $this->product = Product::where('slug', $this->slug)->firstOrFail();

        if (! $this->product->is_active) {
            return redirect('/products')->with('error', 'This product is no longer available.');
        }

        $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = $this->product->reviews()->approved()->with('user')->latest()->get();
        $this->totalReviews = $this->reviews->count();

        if ($this->totalReviews > 0) {
            $this->averageRating = round($this->reviews->avg('rating'), 1);
            $this->ratingCounts = $this->reviews->groupBy('rating')->map->count()->toArray();
            for ($i = 1; $i <= 5; $i++) {
                if (! isset($this->ratingCounts[$i])) {
                    $this->ratingCounts[$i] = 0;
                }
            }
        }
    }

    public function increaseQty()
    {
        $maxStock = $this->product->total_stock;
        if ($this->quantity < $maxStock) {
            $this->quantity++;
        }
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($product_id)
    {
        $result = CartManagement::addItemToCartWithQty($product_id, $this->quantity);

        $this->dispatch('update-cart-count', total_count: $result['count'])->to(Navbar::class);

        if ($result['success']) {
            $this->dispatch('swal:alert',
                icon: 'success',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Selection Logged</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">'.$this->quantity.' units have been added to your curated collection.</p>',
                position: 'bottom-end',
                timer: 4000,
                toast: true,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: [
                    'popup' => 'border border-primary/20 bg-background/95 backdrop-blur-xl rounded-[2rem] shadow-2xl shadow-primary/5',
                    'timerProgressBar' => 'bg-primary/40',
                    'icon' => 'border-primary text-primary scale-75',
                ]
            );
        } else {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Unable to Add</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">'.$result['message'].'</p>',
                position: 'bottom-end',
                timer: 4000,
                toast: true,
                timerProgressBar: true,
                showConfirmButton: false,
            );
        }
    }

    public function submitReview()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }

        $this->validate([
            'review_rating' => 'required|integer|min:1|max:5',
            'review_title' => 'required|string|max:255',
            'review_comment' => 'required|string|min:10|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->product->id,
            'rating' => $this->review_rating,
            'title' => $this->review_title,
            'comment' => $this->review_comment,
            'is_approved' => false,
        ]);

        $this->reset(['review_title', 'review_rating', 'review_comment', 'showReviewForm']);
        $this->dispatch('swal:alert',
            icon: 'success',
            title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Review Submitted</span>',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">Your review has been submitted and is pending approval.</p>',
            position: 'bottom-end',
            timer: 4000,
            toast: true,
        );
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => $this->product,
        ])->layout('components.layouts.app');
    }
}
