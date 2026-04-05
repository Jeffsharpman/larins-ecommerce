@props(['product'])

<div wire:key="product-{{ $product->id }}"
    class="group relative bg-card dark:bg-card rounded-[2.5rem] overflow-hidden border border-border dark:border-border shadow-sm hover:shadow-2xl hover:shadow-primary/10 hover:-translate-y-2 transition-all duration-700 flex flex-col h-full min-h-[480px]">

    {{-- Image Container --}}
    <div class="relative aspect-[4/5] bg-muted dark:bg-black overflow-hidden group-hover:bg-background dark:group-hover:bg-background transition-colors duration-700">
        <img src="{{ url('storage', $product->images[0]) }}" 
             alt="{{ $product->name }}"
             class="absolute inset-0 w-full h-full object-contain p-8 transform group-hover:scale-110 transition-transform duration-1000 ease-out"
             loading="lazy">

        {{-- Badges --}}
        <div class="absolute top-5 left-5 flex flex-col gap-2 z-20">
            <span class="px-3 py-1.5 text-[8px] font-black uppercase tracking-[0.3em] bg-card/90 dark:bg-background/80 text-foreground dark:text-primary backdrop-blur-md rounded-full border border-border dark:border-border shadow-sm">
                {{ $product->category->name }}
            </span>
        </div>

        {{-- Wishlist Button --}}
        <div class="absolute top-5 right-5 z-30 transition-opacity duration-300">
            <livewire:wishlist-button :product-id="$product->id" />
        </div>

        {{-- Quick Add (Desktop) --}}
        <div class="absolute inset-x-0 bottom-0 p-6 translate-y-full group-hover:translate-y-0 transition-transform duration-500 bg-gradient-to-t from-card dark:from-card via-card/80 dark:via-card/80 to-transparent hidden lg:block z-30">
            <button wire:click.prevent="addToCart({{ $product->id }})"
                    class="w-full py-4 bg-foreground dark:bg-background text-card dark:text-foreground rounded-full text-[10px] font-black uppercase tracking-[0.3em] flex items-center justify-center gap-3 hover:bg-primary dark:hover:bg-primary hover:text-white transition-all duration-300">
                
                <div wire:loading.remove wire:target="addToCart({{ $product->id }})" class="flex items-center gap-3">
                    <x-lucide-shopping-bag class="w-4 h-4" />
                    <span>Acquire Item</span>
                </div>

                <div wire:loading.flex wire:target="addToCart({{ $product->id }})" class="items-center gap-3">
                    <x-lucide-refresh-cw class="w-4 h-4 animate-spin" />
                    <span>Processing...</span>
                </div>
            </button>
        </div>
    </div>

    {{-- Details Section --}}
    <div class="p-8 flex-1 flex flex-col relative z-10 bg-card dark:bg-card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-primary">
                {{ $product->brand->name }}
            </span>
            <div class="flex items-center gap-1.5 px-2 py-1 bg-muted dark:bg-muted rounded-md">
                <x-lucide-star class="w-3 h-3 fill-primary text-primary" />
                <span class="text-[10px] font-black text-foreground">{{ $product->rating ?? '5.0' }}</span>
            </div>
        </div>

        <h3 class="text-2xl font-black italic tracking-tighter text-foreground mb-6 leading-[0.9] line-clamp-2">
            <a wire:navigate href="{{ route('product.details', $product->slug) }}" class="hover:text-primary transition-colors">
                {{ $product->name }}
            </a>
        </h3>

        {{-- Mobile Action --}}
        <div class="lg:hidden mb-6">
            <button wire:click.prevent="addToCart({{ $product->id }})"
                    class="w-full py-3 bg-muted dark:bg-muted text-foreground dark:text-foreground border border-border dark:border-border rounded-full text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-2 active:bg-primary active:text-white transition-all">
                <x-lucide-shopping-bag class="w-4 h-4" wire:loading.remove wire:target="addToCart({{ $product->id }})" />
                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                <x-lucide-refresh-cw wire:loading wire:target="addToCart({{ $product->id }})" class="w-4 h-4 animate-spin" />
            </button>
        </div>

        <div class="mt-auto flex items-end justify-between pt-4 border-t border-border dark:border-border">
            <div class="flex flex-col">
                <span class="text-[9px] text-muted-foreground font-black uppercase tracking-[0.2em] mb-1">Valuation</span>
                <span class="text-2xl font-black italic tracking-tighter text-foreground">
                    ₦{{ number_format($product->price, 2) }}
                </span>
            </div>

            <a wire:navigate href="{{ route('product.details', $product->slug) }}"
                class="w-12 h-12 rounded-full border border-border flex items-center justify-center text-muted-foreground group-hover:bg-primary group-hover:border-primary group-hover:text-white transition-all duration-500 transform group-hover:rotate-[-45deg]">
                <x-lucide-arrow-right class="w-5 h-5" />
            </a>
        </div>
    </div>
</div>
