<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Address extends Model
{
    use LogsActivity;

    protected $fillable = ['order_id', 'first_name', 'last_name', 'phone', 'street_address', 'city', 'state', 'zip_code'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
