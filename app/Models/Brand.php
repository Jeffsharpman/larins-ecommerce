<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Brand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $fillable = ['name', 'slug', 'image', 'description', 'is_active'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function registerMediaCollections(?Media $media = null): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }
}
