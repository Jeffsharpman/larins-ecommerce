<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Review;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Reviews')]
class ReviewsPage extends Component
{
    use WithPagination;

    public $selected_product_id;

    public $selected_rating;

    public function mount()
    {
        $this->selected_product_id = request()->query('product');
    }

    public function render()
    {
        $reviewsQuery = Review::with(['user', 'product'])
            ->where('is_approved', true)
            ->latest();

        if ($this->selected_product_id) {
            $reviewsQuery->where('product_id', $this->selected_product_id);
        }

        if ($this->selected_rating) {
            $reviewsQuery->where('rating', $this->selected_rating);
        }

        $reviews = $reviewsQuery->paginate(12);

        $products = Product::where('is_active', 1)
            ->has('reviews')
            ->withCount('approvedReviews')
            ->orderBy('approved_reviews_count', 'desc')
            ->get(['id', 'name', 'slug']);

        $stats = [
            'total' => Review::where('is_approved', true)->count(),
            'average' => Review::where('is_approved', true)->avg('rating') ?? 0,
            'distribution' => Review::where('is_approved', true)
                ->selectRaw('rating, COUNT(*) as count')
                ->groupBy('rating')
                ->pluck('count', 'rating')
                ->toArray(),
        ];

        for ($i = 1; $i <= 5; $i++) {
            if (! isset($stats['distribution'][$i])) {
                $stats['distribution'][$i] = 0;
            }
        }

        return view('livewire.reviews-page', [
            'reviews' => $reviews,
            'products' => $products,
            'stats' => $stats,
        ])->layout('components.layouts.app');
    }

    public function filterByProduct($productId = null)
    {
        $this->selected_product_id = $productId;
        $this->resetPage();
    }

    public function filterByRating($rating = null)
    {
        $this->selected_rating = $rating;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->selected_product_id = null;
        $this->selected_rating = null;
        $this->resetPage();
    }
}
