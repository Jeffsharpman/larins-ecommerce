@php
    $stock = $product->total_stock;
    $isLowStock = $stock > 0 && $stock <= 5;
    $isOutOfStock = $stock <= 0;
@endphp

<div class="product-card group relative bg-card border {{ $isOutOfStock ? 'border-destructive/20' : 'border-border/60 dark:border-white/10' }} rounded-[2.5rem] overflow-hidden hover:shadow-2xl hover:shadow-primary/5 hover:shadow-secondary/5 hover:-translate-y-2 hover:border-secondary/30 transition-all duration-500 {{ $isOutOfStock ? 'opacity-60' : '' }}">

    {{-- Secondary Ambient Glow --}}
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-secondary/5 blur-[80px] rounded-full pointer-events-none z-0"></div>
    <div class="relative aspect-[4/5] overflow-hidden bg-muted">
        <a wire:navigate href="{{ route('product.details', $product->slug) }}">
            @if($product->images && count($product->images) > 0)
            <img src="{{ url('storage', $product->images[0]) }}" alt="{{ $product->name }}" class="product-card-image w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center bg-muted">
                <x-lucide-image class="w-12 h-12 text-muted-foreground/30" />
            </div>
            @endif
        </a>

        <div class="product-card-overlay"></div>
        
        {{-- Stock Badge --}}
        <div class="absolute bottom-5 left-5 z-20">
            @if($isOutOfStock)
                <span class="badge badge-out-of-stock">
                    Out of Stock
                </span>
            @elseif($isLowStock)
                <span class="badge badge-low-stock animate-pulse">
                    Only {{ $stock }} left
                </span>
            @endif
        </div>
        
        {{-- Action Buttons --}}
        <div class="absolute top-5 right-5 flex flex-col gap-2 translate-x-12 group-hover:translate-x-0 transition-transform duration-500 ease-expo">
            <button 
                wire:click="removeFromWishlist({{ $product->id }})"
                class="w-10 h-10 bg-background/90 backdrop-blur-md rounded-full flex items-center justify-center text-destructive shadow-lg hover:bg-destructive hover:text-white transition-all duration-300">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        @if(!$isOutOfStock)
        <div class="absolute inset-x-0 bottom-0 p-5 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-expo bg-gradient-to-t from-black/80 to-transparent">
            <button 
                wire:click="{{ $action }}"
                class="btn btn-primary btn-md w-full">
                <x-lucide-shopping-bag class="w-4 h-4" />
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
        
        {{-- Availability Indicator --}}
        <div class="mb-4 flex items-center gap-3">
            @if($isOutOfStock)
                <span class="flex items-center gap-1.5 text-[9px] font-black uppercase tracking-widest text-destructive">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full rounded-full bg-destructive opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-destructive"></span>
                    </span>
                    Unavailable
                </span>
            @else
                <span class="flex items-center gap-1.5 text-[9px] font-black uppercase tracking-widest {{ $isLowStock ? 'text-amber-500' : 'text-emerald-500' }}">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full rounded-full {{ $isLowStock ? 'bg-amber-500' : 'bg-emerald-500' }} animate-ping opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 {{ $isLowStock ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                    </span>
                    {{ $isLowStock ? 'Low Stock' : 'In Stock' }}
                </span>
                <span class="text-[8px] font-bold text-muted-foreground/60 uppercase tracking-wider ml-auto">{{ $stock }} left</span>
            @endif
        </div>
        
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-border/50 relative">
            <div class="absolute top-0 left-0 w-12 h-[1.5px] bg-secondary/30"></div>
            <div class="flex flex-col">
                @if($product->on_sale && $product->sale_price && $product->sale_price < $product->price)
                    <span class="text-lg font-black italic tracking-tighter text-emerald-500">&#x20A6;{{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-[10px] text-muted-foreground line-through">&#x20A6;{{ number_format($product->old_price ?? $product->price, 2) }}</span>
                @else
                    <span class="text-lg font-black italic tracking-tighter">&#x20A6;{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            @if($product->on_sale && $product->sale_price && $product->sale_price < $product->price)
            <span class="badge badge-sale">
                Sale
            </span>
            @endif
        </div>
    </div>
</div>
