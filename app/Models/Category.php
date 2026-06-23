<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Category extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name', 'slug', 'image', 'description', 'is_active'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
