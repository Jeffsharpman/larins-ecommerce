@props(['product'])

@php
    $stock = $product->total_stock;
    $isLowStock = $stock > 0 && $stock <= 5;
    $isOutOfStock = $stock <= 0;
@endphp

<div wire:key="product-{{ $product->id }}"
    class="product-card group relative bg-card dark:bg-card rounded-[2.5rem] overflow-hidden border {{ $isOutOfStock ? 'border-destructive/20 opacity-60' : 'border-border/60 dark:border-white/10' }} shadow-sm hover:shadow-2xl hover:shadow-primary/5 hover:shadow-secondary/5 hover:-translate-y-2 hover:border-secondary/30 transition-all duration-700 flex flex-col h-full min-h-120">

    {{-- Secondary Ambient Glow --}}
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-secondary/5 blur-[80px] rounded-full pointer-events-none z-0"></div>

    {{-- Image Container --}}
    <div class="relative aspect-4/5 bg-muted dark:bg-linear-to-br dark:from-secondary/5 dark:to-black overflow-hidden">
       <img
        src="https://cdn.jsdelivr.net/gh/Jeffsharpman/larins-assets@main/images/products/6-piece-non-stick-baking-set7.jpg"
        alt="test"
        style="width:300px;height:auto;"
    >

        {{-- Hover Gradient Overlay --}}
        <div class="product-card-overlay"></div>

        {{-- Top Badges Row --}}
        <div class="absolute top-4 left-4 z-20 flex flex-col gap-2">
            <span class="px-3 py-1.5 text-[8px] font-black uppercase tracking-[0.3em] bg-muted/80 dark:bg-white/8 text-foreground/75 dark:text-white/85 backdrop-blur-md rounded-full border border-border/80 dark:border-white/15 shadow-sm">
                <x-lucide-tag class="w-2.5 h-2.5 inline -mt-0.5 mr-1" />
                {{ $product->category->name }}
            </span>
            @if($product->on_sale && !$isOutOfStock)
                <span class="badge badge-primary-outline text-[9px] px-3 py-1 border-2 border-primary/60 dark:border-primary/80 text-primary dark:text-primary bg-primary/5 dark:bg-primary/10 shadow-[0_0_12px_rgba(var(--primary-rgb),0.2)] dark:shadow-[0_0_16px_rgba(var(--primary-rgb),0.15)]">
                    <x-lucide-sparkles class="w-3 h-3" />
                    Sale
                </span>
            @endif
        </div>

        {{-- Stock Badge --}}
        <div class="absolute bottom-4 left-4 z-20">
            @if($isOutOfStock)
                <span class="badge bg-foreground/80 dark:bg-foreground/90 text-background dark:text-background border border-foreground/20 dark:border-foreground/10 shadow-lg backdrop-blur-sm">
                    <x-lucide-x-circle class="w-3 h-3" />
                    Out of Stock
                </span>
            @elseif($isLowStock)
                <span class="badge bg-secondary/20 dark:bg-secondary/30 text-secondary-foreground dark:text-foreground border border-secondary/30 dark:border-secondary/40 shadow-lg backdrop-blur-sm">
                    <x-lucide-clock class="w-3 h-3" />
                    Only {{ $stock }} left
                </span>
            @endif
        </div>

        {{-- Wishlist Button --}}
        <div class="absolute top-4 right-4 z-30">
            <livewire:wishlist-button :product-id="$product->id" />
        </div>

        {{-- Quick Acquire Overlay (Desktop) --}}
        @if(!$isOutOfStock)
        <div class="absolute inset-x-0 bottom-0 p-5 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-expo bg-linear-to-t from-card via-card/95 to-transparent z-30 hidden lg:block">
            <button wire:click.prevent="addToCart({{ $product->id }})"
                    class="btn btn-dark btn-md w-full group/btn">
                <div wire:loading.remove wire:target="addToCart({{ $product->id }})" class="flex items-center gap-3">
                    <x-lucide-shopping-bag class="w-4 h-4 transition-transform group-hover/btn:rotate-6" />
                    <span>Acquire Item</span>
                </div>
                <div wire:loading.flex wire:target="addToCart({{ $product->id }})" class="items-center gap-3">
                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Processing</span>
                </div>
            </button>
        </div>
        @endif
    </div>

    {{-- Details Section --}}
    <div class="p-6 flex-1 flex flex-col relative z-10 bg-card dark:bg-card">
        {{-- Brand & Rating --}}
        <div class="flex items-center justify-between mb-2">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-primary">
                {{ $product->brand->name }}
            </span>
            <div class="flex items-center gap-1 px-2 py-1 bg-muted dark:bg-muted rounded-md">
                <x-lucide-star class="w-3 h-3 fill-primary text-primary" />
                <span class="text-[10px] font-black text-foreground">{{ $product->rating ?? '5.0' }}</span>
            </div>
        </div>

        {{-- Product Name --}}
        <h3 class="text-xl font-black italic tracking-tighter text-foreground mb-3 leading-tight line-clamp-2">
            <a wire:navigate href="{{ route('product.details', $product->slug) }}" class="hover:text-primary transition-colors">
                {{ $product->name }}
            </a>
        </h3>

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

        {{-- Mobile Action --}}
        <div class="lg:hidden mb-4">
            @if(!$isOutOfStock)
                <button wire:click.prevent="addToCart({{ $product->id }})"
                        class="btn btn-secondary btn-sm w-full">
                    <x-lucide-shopping-bag class="w-4 h-4" wire:loading.remove wire:target="addToCart({{ $product->id }})" />
                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                    <x-lucide-refresh-cw wire:loading wire:target="addToCart({{ $product->id }})" class="w-4 h-4 animate-spin" />
                </button>
            @else
                <button disabled
                        class="btn btn-secondary btn-sm w-full opacity-50 cursor-not-allowed">
                    <x-lucide-x-circle class="w-4 h-4" />
                    Out of Stock
                </button>
            @endif
        </div>

        {{-- Price & View --}}
        <div class="mt-auto flex items-end justify-between pt-4 border-t border-border dark:border-border relative">
            <div class="absolute top-0 left-0 w-12 h-[1.5px] bg-secondary/30"></div>
            <div class="flex flex-col">
                <span class="text-[9px] text-muted-foreground font-black uppercase tracking-[0.2em] mb-1">Valuation</span>
                @if($product->on_sale && $product->sale_price && $product->sale_price < $product->price)
                    <div class="flex flex-col">
                        <span class="text-xl font-black italic tracking-tighter text-emerald-500">
                            ₦{{ number_format($product->sale_price, 2) }}
                        </span>
                        <span class="text-xs font-black italic tracking-tighter text-muted-foreground line-through">
                            ₦{{ number_format($product->old_price ?? $product->price, 2) }}
                        </span>
                    </div>
                @else
                    <span class="text-xl font-black italic tracking-tighter text-foreground">
                        ₦{{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            <a wire:navigate href="{{ route('product.details', $product->slug) }}"
                class="relative w-11 h-11 rounded-full flex items-center justify-center border-2 border-primary/20 dark:border-primary/25 text-primary dark:text-primary bg-linear-to-br from-primary/[0.08] to-primary/[0.03] dark:from-primary/[0.12] dark:to-primary/[0.05] shadow-sm shadow-primary/5 dark:shadow-primary/10 hover:scale-110 hover:border-primary hover:bg-primary hover:text-white hover:shadow-lg hover:shadow-primary/25 dark:hover:shadow-primary/20 transition-all duration-400 ease-spring group/arrow overflow-hidden active:scale-95">
                <span class="absolute inset-0 bg-linear-to-br from-primary to-primary/80 dark:from-primary/90 dark:to-primary/70 scale-0 group-hover/arrow:scale-100 transition-transform duration-500 ease-expo rounded-full"></span>
                <x-lucide-arrow-right class="relative z-10 w-4.5 h-[1.125rem] transition-all duration-500 group-hover/arrow:translate-x-1 group-hover/arrow:-translate-y-1" />
            </a>
        </div>
    </div>
</div>
