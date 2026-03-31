<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Order extends Model
{
    use LogsActivity;

    protected $fillable = ['user_id', 'order_number', 'grand_total', 'payments_method', 'payments_status', 'status', 'currency', 'shipping_amount', 'shipping_method', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
