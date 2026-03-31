<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingMethodFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $methods = [
            [
                'name' => 'Standard Delivery',
                'code' => 'standard',
                'description' => 'Reliable delivery within 5-7 business days',
                'base_cost' => 2500,
                'min_order_amount' => 0,
                'max_order_amount' => null,
                'delivery_days_min' => 5,
                'delivery_days_max' => 7,
                'is_default' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Express Delivery',
                'code' => 'express',
                'description' => 'Fast delivery within 2-3 business days',
                'base_cost' => 5000,
                'min_order_amount' => 0,
                'max_order_amount' => null,
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'is_default' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Priority Delivery',
                'code' => 'priority',
                'description' => 'Next-day delivery for urgent orders',
                'base_cost' => 8500,
                'min_order_amount' => 50000,
                'max_order_amount' => null,
                'delivery_days_min' => 1,
                'delivery_days_max' => 1,
                'is_default' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Same Day Delivery',
                'code' => 'same_day',
                'description' => 'Delivery within 4 hours (Lagos only)',
                'base_cost' => 15000,
                'min_order_amount' => 25000,
                'max_order_amount' => 500000,
                'delivery_days_min' => 0,
                'delivery_days_max' => 0,
                'is_default' => false,
                'sort_order' => 4,
            ],
        ];

        $current = $methods[$index % count($methods)];
        $index++;

        return [
            'name' => $current['name'],
            'code' => $current['code'],
            'description' => $current['description'],
            'base_cost' => $current['base_cost'],
            'min_order_amount' => $current['min_order_amount'],
            'max_order_amount' => $current['max_order_amount'],
            'delivery_days_min' => $current['delivery_days_min'],
            'delivery_days_max' => $current['delivery_days_max'],
            'icon' => 'truck',
            'is_active' => true,
            'is_default' => $current['is_default'],
            'sort_order' => $current['sort_order'],
        ];
    }
}
