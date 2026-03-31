<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'base_cost',
        'min_order_amount',
        'max_order_amount',
        'delivery_days_min',
        'delivery_days_max',
        'icon',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'base_cost' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_order_amount' => 'decimal:2',
        'delivery_days_min' => 'integer',
        'delivery_days_max' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDeliveryTimeAttribute(): string
    {
        if (! $this->delivery_days_min && ! $this->delivery_days_max) {
            return 'N/A';
        }

        if ($this->delivery_days_min === $this->delivery_days_max) {
            return $this->delivery_days_min.' day(s)';
        }

        return $this->delivery_days_min.'-'.$this->delivery_days_max.' days';
    }
}
