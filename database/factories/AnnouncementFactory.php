<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $announcements = [
            [
                'title' => 'Free Shipping on Orders Over ₦100,000',
                'content' => 'Use code FREESHIP at checkout',
                'type' => 'info',
                'dismissible' => true,
            ],
            [
                'title' => 'New Collection Arriving Soon',
                'content' => 'Exclusive preview available now',
                'type' => 'success',
                'dismissible' => true,
            ],
            [
                'title' => 'Flash Sale - 24 Hours Only',
                'content' => 'Up to 50% off on selected items',
                'type' => 'warning',
                'dismissible' => true,
            ],
            [
                'title' => 'Holiday Delivery Notice',
                'content' => 'Orders may experience delays during festive season',
                'type' => 'info',
                'dismissible' => false,
            ],
        ];

        $current = $announcements[$index % count($announcements)];
        $index++;

        return [
            'title' => $current['title'],
            'content' => $current['content'],
            'type' => $current['type'],
            'link' => null,
            'is_active' => true,
            'starts_at' => now()->subHour(),
            'ends_at' => now()->addMonth(),
            'dismissible' => $current['dismissible'],
        ];
    }

    public function forType(string $type): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => $type,
        ]);
    }
}
