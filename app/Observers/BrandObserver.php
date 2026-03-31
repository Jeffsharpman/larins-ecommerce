<?php

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandObserver
{
    /**
     * Delete old image when a new image is uploaded (on update)
     */
    public function saved(Brand $brand): void
    {
        if ($brand->isDirty('image') && $brand->getOriginal('image')) {
            Storage::disk('public')->delete($brand->getOriginal('image'));
        }
    }

    /**
     * Delete image when brand is deleted
     */
    public function deleted(Brand $brand): void
    {
        if (!empty($brand->image)) {
            Storage::disk('public')->delete($brand->image);
        }
    }

    /**
     * Handle force delete (if using SoftDeletes)
     */
    public function forceDeleted(Brand $brand): void
    {
        $this->deleted($brand);
    }
}