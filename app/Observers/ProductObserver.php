<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{
    /**
     * Handle the Product "saved" event (for update - when image is replaced)
     */
    public function saved(Product $product): void
    {
        // Single image field (e.g., 'image')
        if ($product->isDirty('image') && $product->getOriginal('image')) {
            Storage::disk('public')->delete($product->getOriginal('image'));
        }

        // Multiple images field (e.g., 'images' stored as JSON array)
        if ($product->isDirty('images')) {
            $oldImages = $product->getOriginal('images') ?? [];
            $newImages = $product->images ?? [];

            $imagesToDelete = array_diff($oldImages, $newImages);

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image);
            }
        }
    }

    /**
     * Handle the Product "deleted" event
     */
    public function deleted(Product $product): void
    {
        // Single image
        if (! empty($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Multiple images (JSON array)
        if (! empty($product->images)) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
    }

    // Optional: Also handle force deleted if using soft deletes
    public function forceDeleted(Product $product): void
    {
        $this->deleted($product);
    }
}
