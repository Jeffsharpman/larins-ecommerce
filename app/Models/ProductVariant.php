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

    public static function getLowStockReport()
    {
        return static::where('stock', '<=', 5)
            ->with('product') // Eager load the parent product for the email
            ->get();
    }
}
