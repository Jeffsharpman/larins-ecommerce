<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $fillable = ['category_id', 'brand_id', 'name', 'slug', 'images', 'description', 'price', 'is_active', 'is_featured', 'in_stock', 'on_sale', 'stock'];

    protected $casts = ['images' => 'array'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('is_approved', true);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // In app/Models/Product.php

    public function getTotalInventoryAttribute(): int
    {
        if ($this->variants()->exists()) {
            return (int) $this->variants()->sum('stock');
        }

        return (int) $this->stock;
    }

    // In Product.php
    public function scopeLowStock($query, $threshold = 5)
    {
        return $query->where(function ($q) use ($threshold) {
            $q->where('stock', '<=', $threshold)
                ->orWhereRaw('id IN (SELECT product_id FROM product_variants WHERE stock <= ?)', [$threshold]);
        });
    }

    /**
     * Get the total stock by summing all variants.
     */
    public function getTotalStockAttribute(): int
    {
        if ($this->variants()->exists()) {
            return (int) $this->variants()->sum('stock');
        }

        return (int) $this->stock;
    }

    /**
     * Determine if the product is in stock.
     */
    public function getIsInStockAttribute(): bool
    {
        return $this->total_stock > 0;
    }

    /**
     * Determine if the product is low on stock.
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->total_stock > 0 && $this->total_stock <= 5;
    }

    /**
     * Determine if the product is out of stock.
     */
    public function getIsOutOfStockAttribute(): bool
    {
        return $this->total_stock <= 0;
    }

    public function registerMediaCollections(?Media $media = null): void
    {
        $this->addMediaCollection('images');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('optimized')
            ->width(800)
            ->height(800)
            ->withResponsiveImages();
    }
}
