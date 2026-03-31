<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home')]
class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();
        $reviews = [
            [
                'id' => 1,
                'user' => [
                    'name' => 'Aisha Bello',
                    'avatar' => 'https://i.pravatar.cc/100?img=1',
                    'role' => 'Customer',
                ],
                'rating' => 5,
                'comment' => 'Absolutely love the quality! Fast delivery and great packaging.',
                'likes_count' => 12,
                'created_at' => now()->subDays(2),
            ],
            [
                'id' => 2,
                'user' => [
                    'name' => 'David Okafor',
                    'avatar' => 'https://i.pravatar.cc/100?img=2',
                    'role' => 'Customer',
                ],
                'rating' => 4,
                'comment' => 'Very good experience overall. Product matched description.',
                'likes_count' => 8,
                'created_at' => now()->subDays(4),
            ],
            [
                'id' => 3,
                'user' => [
                    'name' => 'Fatima Yusuf',
                    'avatar' => 'https://i.pravatar.cc/100?img=3',
                    'role' => 'Customer',
                ],
                'rating' => 5,
                'comment' => 'Top-notch service! I’ll definitely shop here again.',
                'likes_count' => 15,
                'created_at' => now()->subDays(1),
            ],
            [
                'id' => 4,
                'user' => [
                    'name' => 'Michael Ade',
                    'avatar' => 'https://i.pravatar.cc/100?img=4',
                    'role' => 'Customer',
                ],
                'rating' => 3,
                'comment' => 'Product is okay, but delivery took longer than expected.',
                'likes_count' => 5,
                'created_at' => now()->subDays(6),
            ],
            [
                'id' => 5,
                'user' => [
                    'name' => 'Chioma Nwankwo',
                    'avatar' => 'https://i.pravatar.cc/100?img=5',
                    'role' => 'Customer',
                ],
                'rating' => 4,
                'comment' => 'Nice packaging and decent quality. Worth the price.',
                'likes_count' => 9,
                'created_at' => now()->subDays(3),
            ],
            [
                'id' => 6,
                'user' => [
                    'name' => 'Sadiq Ibrahim',
                    'avatar' => 'https://i.pravatar.cc/100?img=6',
                    'role' => 'Customer',
                ],
                'rating' => 5,
                'comment' => 'Exceeded my expectations. Highly recommend!',
                'likes_count' => 20,
                'created_at' => now()->subDays(7),
            ],
            [
                'id' => 7,
                'user' => [
                    'name' => 'Blessing Eze',
                    'avatar' => 'https://i.pravatar.cc/100?img=7',
                    'role' => 'Customer',
                ],
                'rating' => 4,
                'comment' => 'Good value for money. Will try more products soon.',
                'likes_count' => 6,
                'created_at' => now()->subDays(5),
            ],
        ];

        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
            'reviews' => $reviews,
        ])->layout('components.layouts.app');
    }
}
