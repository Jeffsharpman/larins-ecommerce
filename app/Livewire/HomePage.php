<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home')]
class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();

        $reviews = Review::with(['user', 'product'])
            ->where('is_approved', true)
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($review) {
                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'title' => $review->title,
                    'created_at' => $review->created_at,
                    'user' => [
                        'name' => $review->user->name ?? 'Anonymous',
                        'avatar' => $review->user?->avatar
                            ? asset('storage/'.$review->user->avatar)
                            : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name ?? 'A').'&background=random',
                        'role' => 'Verified Buyer',
                    ],
                    'product' => $review->product ? [
                        'name' => $review->product->name,
                        'slug' => $review->product->slug,
                    ] : null,
                    'likes_count' => 0,
                ];
            });

        $featuredProducts = Product::featured()
            ->with(['reviews', 'brand', 'category'])
            ->latest()
            ->take(4)
            ->get();

        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
            'reviews' => $reviews,
            'featuredProducts' => $featuredProducts,
        ])->layout('components.layouts.app');
    }
}
