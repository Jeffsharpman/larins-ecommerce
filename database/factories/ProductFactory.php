<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $items = [
            ['name' => 'Midnight Slate Timepiece', 'price' => 125000.00],
            ['name' => 'Aurelius Silk Scarf', 'price' => 45000.00],
            ['name' => 'Heritage Leather Portfolio', 'price' => 85000.00],
            ['name' => 'Vanguard Titanium Cardholder', 'price' => 32000.00],
            ['name' => 'Obsidian Fountain Pen', 'price' => 55000.00],
            ['name' => 'Ivory Ceramic Vase', 'price' => 95000.00],
            ['name' => 'Slate Linen Minimalist Shirt', 'price' => 28000.00],
            ['name' => 'Gold-Leaf Embossed Journal', 'price' => 15000.00],
            ['name' => 'Elite Carbon Fiber Umbrella', 'price' => 42000.00],
            ['name' => 'Maison Fragrance No. 01', 'price' => 68000.00],
            ['name' => 'Brushed Aluminum Desk Lamp', 'price' => 110000.00],
            ['name' => 'Cashmere Throw - Slate', 'price' => 145000.00],
            ['name' => 'Hand-Forged Steel Letter Opener', 'price' => 12000.00],
            ['name' => 'Luxury Velvet Cushion', 'price' => 22000.00],
            ['name' => 'Cognac Leather Weekender', 'price' => 210000.00],
            ['name' => 'Silver-Plated Coaster Set', 'price' => 38000.00],
            ['name' => 'Minimalist Concrete Clock', 'price' => 48000.00],
            ['name' => 'Polished Marble Tray', 'price' => 52000.00],
            ['name' => 'Vanguard Performance Cap', 'price' => 18000.00],
            ['name' => 'Signature Maison Robe', 'price' => 75000.00],
        ];

        $current = $items[$index % count($items)];
        $index++;
        $stock = rand(0, 50);
        $isOnSale = $this->faker->boolean(30);
        $salePrice = $isOnSale ? $current['price'] * 0.8 : $current['price'];
        $oldPrice = $isOnSale ? $current['price'] : $current['price'];

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'brand_id' => Brand::inRandomOrder()->first()->id ?? 1,
            'name' => $current['name'],
            'slug' => Str::slug($current['name']).'-'.Str::random(4),
            'images' => ['products/placeholder.jpg', 'products/placeholder1.jpg', 'products/placeholder2.jpg', 'products/placeholder3.jpg', 'products/placeholder4.jpg'],
            'description' => 'An exquisite piece representing the pinnacle of Larins craftsmanship.',
            'price' => $current['price'],
            'old_price' => $oldPrice,
            'sale_price' => $salePrice,
            'stock' => $stock,
            'is_active' => $stock > 0,
            'is_featured' => $current['price'] > 100000,
            'in_stock' => $stock > 0,
            'on_sale' => $isOnSale && $stock > 0,
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
            'is_active' => false,
            'in_stock' => false,
            'on_sale' => false,
        ]);
    }

    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => rand(1, 5),
        ]);
    }

    public function onSale(): static
    {
        return $this->state(fn (array $attributes) => [
            'on_sale' => true,
            'sale_price' => $attributes['price'] * 0.8,
            'old_price' => $attributes['price'],
            'is_active' => true,
            'in_stock' => true,
        ]);
    }
}
