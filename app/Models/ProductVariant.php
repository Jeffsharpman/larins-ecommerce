<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'sku', 'name', 'price', 'stock', 'attributes'];

    protected $casts = ['attributes' => 'array'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public static function getLowStockReport()
    {
        return static::where('stock', '<=', 5)
            ->with('product') // Eager load the parent product for the email
            ->get();
    }
}
