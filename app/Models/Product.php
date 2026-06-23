<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['category_id', 'brand_id', 'name', 'slug', 'images', 'description', 'price', 'sale_price', 'old_price', 'is_active', 'is_featured', 'in_stock', 'on_sale', 'stock'];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'in_stock' => 'boolean',
        'on_sale' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            $totalStock = $product->variants()->exists()
                ? $product->variants()->sum('stock')
                : (int) $product->stock;

            $hasStock = $totalStock > 0;

            $product->in_stock = $hasStock;
            $product->is_active = $hasStock;

            if (! $hasStock) {
                $product->on_sale = false;
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('in_stock', true);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_active', true)->where('in_stock', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('on_sale', true)->where('is_active', true)->where('in_stock', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true)->where('in_stock', true);
    }

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

    public static function deductStockForOrderItem(int $productId, int $quantity): bool
    {
        $product = static::find($productId);

        if (! $product) {
            return false;
        }

        if ($product->variants()->exists()) {
            $variant = $product->variants()->first();
            if ($variant && $variant->stock >= $quantity) {
                $variant->decrement('stock', $quantity);
                $product->refreshStockStatus();

                return true;
            }

            return false;
        }

        if ($product->stock >= $quantity) {
            $product->decrement('stock', $quantity);
            $product->refreshStockStatus();

            return true;
        }

        return false;
    }

    public function refreshStockStatus(): void
    {
        $totalStock = $this->variants()->exists()
            ? $this->variants()->sum('stock')
            : (int) $this->stock;

        $hasStock = $totalStock > 0;

        $this->update([
            'in_stock' => $hasStock,
            'is_active' => $hasStock,
            'on_sale' => $hasStock ? $this->on_sale : false,
        ]);
    }

    public static function restoreStockForOrderItem(int $productId, int $quantity): bool
    {
        $product = static::find($productId);

        if (! $product) {
            return false;
        }

        if ($product->variants()->exists()) {
            $variant = $product->variants()->first();
            if ($variant) {
                $variant->increment('stock', $quantity);
                $product->refreshStockStatus();

                return true;
            }
        }

        $product->increment('stock', $quantity);
        $product->refreshStockStatus();

        return true;
    }
}
