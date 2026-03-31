<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    public function definition(): array
    {
        static $index = 0;
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h2>Welcome to Larins</h2><p>Larins is a premium e-commerce platform dedicated to bringing you the finest selection of luxury essentials. Our curated collection features timeless pieces crafted with exceptional attention to quality and detail.</p><h3>Our Mission</h3><p>To provide an unparalleled shopping experience that combines elegance, quality, and accessibility. Every product in our collection represents the pinnacle of craftsmanship and design excellence.</p>',
                'meta_title' => 'About Larins - Premium E-commerce',
                'meta_description' => 'Discover the story behind Larins and our commitment to luxury e-commerce excellence.',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '<h2>Get in Touch</h2><p>We\'d love to hear from you. Our concierge team is available 24/7 to assist with any inquiries.</p><h3>Contact Information</h3><p>Email: concierge@larins.com<br>Phone: +234 801 000 0000<br>Address: 123 Luxury Avenue, Lagos, Nigeria</p>',
                'meta_title' => 'Contact Us - Larins Concierge',
                'meta_description' => 'Contact the Larins concierge team for assistance with your orders.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2>Privacy Policy</h2><p>At Larins, we take your privacy seriously. This policy outlines how we collect, use, and protect your personal information.</p><h3>Information We Collect</h3><p>We collect information you provide directly, including name, email, shipping address, and payment details. This information is used solely for order processing and improving your shopping experience.</p>',
                'meta_title' => 'Privacy Policy - Larins',
                'meta_description' => 'Read Larins privacy policy to understand how we protect your data.',
            ],
            [
                'title' => 'Return Policy',
                'slug' => 'return-policy',
                'content' => '<h2>Returns & Refunds</h2><p>We want you to be completely satisfied with your purchase. If you\'re not happy with your order, we offer a hassle-free return policy.</p><h3>Return Window</h3><p>You have 14 days from delivery to initiate a return. Items must be unused and in original packaging.</p><h3>Refund Process</h3><p>Once we receive your return, refunds are processed within 5-7 business days to your original payment method.</p>',
                'meta_title' => 'Return Policy - Larins',
                'meta_description' => 'Learn about Larins return and refund policy for stress-free shopping.',
            ],
        ];

        $current = $pages[$index % count($pages)];
        $index++;

        return [
            'title' => $current['title'],
            'slug' => $current['slug'],
            'content' => $current['content'],
            'meta_title' => $current['meta_title'],
            'meta_description' => $current['meta_description'],
            'is_active' => true,
        ];
    }
}
