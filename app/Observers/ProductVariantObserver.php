<?php

namespace App\Observers;

use App\Models\ProductVariant;

class ProductVariantObserver
{
    public function saved(ProductVariant $productVariant): void
    {
        $this->updateParentStock($productVariant);
    }

    public function deleted(ProductVariant $productVariant): void
    {
        $this->updateParentStock($productVariant);
    }

    protected function updateParentStock(ProductVariant $variant): void
    {
        $product = $variant->product;
        
        // Sum the stock of all variants belonging to this product
        $totalStock = $product->variants()->sum('stock');

        // Update the main product table (ensure you have a 'stock' column there)
        $product->update(['stock' => $totalStock]);
    }
}