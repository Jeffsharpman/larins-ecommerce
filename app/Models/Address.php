<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Address extends Model
{
    use LogsActivity;

    protected $fillable = ['user_id', 'order_id', 'title', 'phone', 'street_address', 'city', 'state', 'zip_code', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFullNameAttribute(): string
    {
        return $this->user?->name ?? 'N/A';
    }

    public function setAsActive(): void
    {
        self::where('user_id', $this->user_id)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }
}
