<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $categories = [
            ['name' => 'Maison Essentials', 'image' => 'categories/essentials.jpg'],
            ['name' => 'Limited Editions', 'image' => 'categories/limited.jpg'],
            ['name' => 'Archive Collection', 'image' => 'categories/archive.jpg'],
            ['name' => 'Artisan Pieces', 'image' => 'categories/artisan.jpg'],
        ];

        $current = $categories[$index % count($categories)];
        $index++;

        return [
            'name' => $current['name'],
            'slug' => Str::slug($current['name']),
            'image' => $current['image'],
            'description' => 'A curated selection from the ' . $current['name'] . ' series.',
            'is_active' => true,
        ];
    }
}
