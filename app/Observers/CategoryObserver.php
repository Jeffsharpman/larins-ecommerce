<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryObserver
{
    /**
     * Delete old image when a new image is uploaded (on update)
     */
    public function saved(Category $category): void
    {
        if ($category->isDirty('image') && $category->getOriginal('image')) {
            Storage::disk('public')->delete($category->getOriginal('image'));
        }
    }

    /**
     * Delete image when category is deleted
     */
    public function deleted(Category $category): void
    {
        if (!empty($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
    }

    /**
     * Handle force delete (if using SoftDeletes)
     */
    public function forceDeleted(Category $category): void
    {
        $this->deleted($category);
    }
}