@php
    $stock = $product->total_stock;
    $isLowStock = $stock > 0 && $stock <= 5;
    $isOutOfStock = $stock <= 0;
@endphp

<div class="group relative bg-card border {{ $isOutOfStock ? 'border-destructive/30' : 'border-border/40' }} rounded-[2.5rem] overflow-hidden hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-2 transition-all duration-500 {{ $isOutOfStock ? 'opacity-60' : '' }}">
    <div class="relative aspect-[4/5] overflow-hidden bg-muted">
        <a wire:navigate href="{{ route('product.details', $product->slug) }}">
            @if($product->images && count($product->images) > 0)
            <img src="{{ url('storage', $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            @else
            <div class="w-full h-full flex items-center justify-center bg-muted">
                <x-lucide-image class="w-12 h-12 text-muted-foreground" />
            </div>
            @endif
        </a>
        
        {{-- Stock Badge --}}
        <div class="absolute bottom-5 left-5 z-20">
            @if($isOutOfStock)
                <span class="px-3 py-1.5 text-[8px] font-black uppercase tracking-[0.2em] bg-destructive text-destructive-foreground rounded-full">
                    Out of Stock
                </span>
            @elseif($isLowStock)
                <span class="px-3 py-1.5 text-[8px] font-black uppercase tracking-[0.2em] bg-amber-500 text-white rounded-full animate-pulse">
                    Only {{ $stock }} left
                </span>
            @endif
        </div>
        
        <div class="absolute top-5 right-5 flex flex-col gap-3 translate-x-12 group-hover:translate-x-0 transition-transform duration-500">
            <button 
                wire:click="removeFromWishlist({{ $product->id }})"
                class="w-10 h-10 bg-background/90 backdrop-blur-md rounded-full flex items-center justify-center text-destructive shadow-lg hover:bg-destructive hover:text-white transition-all">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        @if(!$isOutOfStock)
        <div class="absolute inset-x-0 bottom-0 p-6 translate-y-full group-hover:translate-y-0 transition-transform duration-500 bg-gradient-to-t from-black/80 to-transparent">
            <button 
                wire:click="{{ $action }}"
                class="w-full py-4 bg-primary text-primary-foreground font-black uppercase tracking-tighter italic rounded-2xl flex items-center justify-center gap-3 hover:scale-[1.02] active:scale-95 transition-all">
                <x-lucide-shopping-bag class="w-5 h-5" />
                {{ $buttonText }}
            </button>
        </div>
        @endif
    </div>

    <div class="p-6">
        <div class="flex justify-between items-start mb-3">
            <div>
                @if($product->category)
                <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-1">{{ $product->category->name }}</p>
                @endif
                <a wire:navigate href="{{ route('product.details', $product->slug) }}">
                    <h3 class="font-bold text-foreground leading-tight hover:text-primary transition-colors">{{ $product->name }}</h3>
                </a>
            </div>
        </div>
        
        {{-- Stock Progress --}}
        <div class="mb-4">
            <div class="w-full bg-muted rounded-full h-1 overflow-hidden">
                <div class="h-full rounded-full transition-all duration-500 {{ $isLowStock ? 'bg-amber-500' : 'bg-primary' }}"
                     style="width: {{ min(100, max(5, ($stock / 10) * 100)) }}%">
                </div>
            </div>
            <p class="text-[8px] text-muted-foreground uppercase tracking-widest mt-1">
                {{ $stock }} available
            </p>
        </div>
        
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-border/50">
            <div class="flex flex-col">
                @if($product->on_sale && $product->sale_price && $product->sale_price < $product->price)
                    <span class="text-lg font-black italic tracking-tighter text-emerald-500">&#x20A6;{{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-[10px] text-muted-foreground line-through">&#x20A6;{{ number_format($product->old_price ?? $product->price, 2) }}</span>
                @else
                    <span class="text-lg font-black italic tracking-tighter">&#x20A6;{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            @if($product->on_sale && $product->sale_price && $product->sale_price < $product->price)
            <div class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[10px] font-black rounded-lg uppercase">
                Sale
            </div>
            @endif
        </div>
    </div>
</div>
