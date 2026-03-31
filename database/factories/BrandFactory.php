<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $brands = [
            ['name' => 'Larins Heritage', 'image' => 'brands/addidas.png'],
            ['name' => 'Aurelius Gold', 'image' => 'brands/bird.png'],
            ['name' => 'Slate & Silk', 'image' => 'brands/channel.png'],
            ['name' => 'Vanguard Elite', 'image' => 'brands/nike.png'],
        ];

        $current = $brands[$index % count($brands)];
        $index++;

        return [
            'name' => $current['name'],
            'slug' => Str::slug($current['name']),
            'image' => $current['image'],
            'description' => 'Crafted by ' . $current['name'] . ' for the modern connoisseur.',
            'is_active' => true,
        ];
    }
}
