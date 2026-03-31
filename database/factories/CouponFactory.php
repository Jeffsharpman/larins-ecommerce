<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $coupons = [
            ['code' => 'WELCOME20', 'type' => 'percentage', 'value' => 20, 'min_order_amount' => 50000, 'max_discount' => 10000],
            ['code' => 'SAVE50', 'type' => 'fixed', 'value' => 5000, 'min_order_amount' => 25000, 'max_discount' => null],
            ['code' => 'VIP15', 'type' => 'percentage', 'value' => 15, 'min_order_amount' => 100000, 'max_discount' => 25000],
            ['code' => 'FREESHIP', 'type' => 'percentage', 'value' => 100, 'min_order_amount' => 50000, 'max_discount' => 5000],
            ['code' => 'NEWUSER', 'type' => 'percentage', 'value' => 10, 'min_order_amount' => 0, 'max_discount' => 5000],
        ];

        $current = $coupons[$index % count($coupons)];
        $index++;

        return [
            'code' => $current['code'],
            'type' => $current['type'],
            'value' => $current['value'],
            'min_order_amount' => $current['min_order_amount'],
            'max_discount' => $current['max_discount'],
            'usage_limit' => rand(50, 500),
            'used_count' => 0,
            'starts_at' => now()->subDay(),
            'expires_at' => now()->addMonths(3),
            'is_active' => true,
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => now()->subDay(),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
