<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class ProductVariant extends Model
{
    use LogsActivity;

    protected $fillable = ['product_id', 'sku', 'name', 'price', 'stock', 'attributes'];

    protected $casts = ['attributes' => 'array'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted(): void
    {
        static::saved(function (ProductVariant $variant) {
            if ($variant->product) {
                $variant->product->refreshStockStatus();
            }
        });
    }

    public static function getLowStockReport()
    {
        return static::where('stock', '<=', 5)
            ->with('product')
            ->get();
    }
}
