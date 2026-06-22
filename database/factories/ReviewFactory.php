<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $comments = [
            ['title' => 'Exceeded Expectations', 'comment' => 'Absolutely stunning quality. The attention to detail is remarkable. Will definitely be ordering again.'],
            ['title' => 'Five Stars', 'comment' => 'Perfect in every way. Fast delivery, beautiful packaging, and the product itself is impeccable.'],
            ['title' => 'Worth Every Penny', 'comment' => 'Premium quality that you can feel immediately. This is what luxury should be. Highly recommend!'],
            ['title' => 'Impressive craftsmanship', 'comment' => 'The craftsmanship is evident from the moment you open the package. True artisans at work here.'],
            ['title' => 'Love it!', 'comment' => 'This has become my go-to for all my luxury essentials. Consistent quality every single time.'],
            ['title' => 'Exceptional Service', 'comment' => 'From browsing to delivery, the experience was flawless. Customer service went above and beyond.'],
        ];

        $current = $comments[$index % count($comments)];
        $index++;

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'rating' => $this->faker->numberBetween(3, 5),
            'title' => $current['title'],
            'comment' => $current['comment'],
            'is_approved' => true,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }

    public function fiveStars(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 5,
        ]);
    }
}
