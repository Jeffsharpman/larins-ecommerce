<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="text-center mb-16 relative">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="w-64 h-64 bg-primary/5 rounded-full blur-3xl mx-auto translate-y-[-50%]"></div>
            <div class="w-48 h-48 bg-secondary/5 rounded-full blur-3xl absolute top-1/4 right-1/4"></div>
            <div class="w-32 h-32 bg-secondary/[0.03] dark:bg-secondary/[0.02] rounded-full blur-2xl absolute bottom-0 left-1/3"></div>
        </div>
        <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/10 rounded-3xl rotate-12 mb-8 border border-primary/20">
            <x-lucide-heart class="w-10 h-10 text-primary -rotate-12 fill-primary/20" />
        </div>
        <h1 class="text-5xl font-black tracking-tighter uppercase italic mb-4">
            Your <span class="text-primary text-stroke-sm">Wishlist</span>
        </h1>
        <p class="text-muted-foreground max-w-xl mx-auto font-medium">
            A curated collection of your future essentials. Items saved here will wait for your return.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        <div class="bg-card border border-border/50 p-6 rounded-[2rem] flex items-center gap-5 group hover:border-primary/50 hover:border-secondary/20 hover:shadow-secondary/5 transition-all">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                <x-lucide-package class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Items Saved</p>
                <h4 class="text-2xl font-black">{{ str_pad($this->itemCount, 2, '0', STR_PAD_LEFT) }}</h4>
            </div>
        </div>
        <div class="bg-card border border-border/50 p-6 rounded-[2rem] flex items-center gap-5 group hover:border-primary/50 hover:border-secondary/20 hover:shadow-secondary/5 transition-all">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                <x-lucide-banknote class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Total Value</p>
                <h4 class="text-2xl font-black">&#x20A6;{{ number_format($this->totalValue, 2) }}</h4>
            </div>
        </div>
        <div class="bg-card border border-border/50 p-6 rounded-[2rem] flex items-center gap-5 group hover:border-primary/50 hover:border-secondary/20 hover:shadow-secondary/5 transition-all">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                <x-lucide-trending-up class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Price Drops</p>
                <h4 class="text-2xl font-black text-green-500">00</h4>
            </div>
        </div>
    </div>

    @if($wishlistProducts->count() > 0)
    <div class="bg-card border border-border rounded-[3rem] p-10 md:p-14 hover:border-secondary/20 transition-all duration-500 relative">
        <div class="absolute -top-0 left-8 right-8 h-[2px] bg-gradient-to-r from-transparent via-secondary/20 to-transparent rounded-full"></div>
        @if($wishlistProducts->count() > 4)
        <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-10 border-b border-border pb-8">
            <div class="flex bg-muted/50 p-1.5 rounded-xl border border-border">
                <button wire:click="setSortBy('latest')" class="px-5 py-2 text-xs font-black uppercase tracking-wider rounded-lg transition-all {{ $sortBy === 'latest' ? 'bg-background shadow-sm text-primary' : 'text-muted-foreground hover:text-foreground' }}">
                    Latest
                </button>
                <button wire:click="setSortBy('price_asc')" class="px-5 py-2 text-xs font-black uppercase tracking-wider rounded-lg transition-all {{ $sortBy === 'price_asc' ? 'bg-background shadow-sm text-primary' : 'text-muted-foreground hover:text-foreground' }}">
                    Price
                </button>
                <button wire:click="setSortBy('price_desc')" class="px-5 py-2 text-xs font-black uppercase tracking-wider rounded-lg transition-all {{ $sortBy === 'price_desc' ? 'bg-background shadow-sm text-primary' : 'text-muted-foreground hover:text-foreground' }}">
                    Popular
                </button>
            </div>
            <button wire:click="clearWishlist" wire:confirm="Are you sure you want to clear your wishlist?" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-destructive hover:opacity-80 transition-opacity">
                <x-lucide-trash-2 class="w-4 h-4" />
                Clear Collection
            </button>
        </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($wishlistProducts as $product)
                <x-card.wishlist-product-card 
                    :product="$product" 
                    action="moveToCart({{ $product->id }})"
                    buttonText="Move to Bag"
                />
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-card border border-border rounded-[3rem] p-10 md:p-14 hover:border-secondary/20 transition-all duration-500 relative">
        <div class="absolute -top-0 left-8 right-8 h-[2px] bg-gradient-to-r from-transparent via-secondary/20 to-transparent rounded-full"></div>
        <div class="text-center py-16 relative">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-24 h-[3px] bg-gradient-to-r from-transparent via-secondary/30 to-transparent rounded-full"></div>
            <x-lucide-heart class="w-16 h-16 text-muted-foreground/30 mx-auto mb-6" />
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">No favorites yet</p>
            <p class="text-[9px] text-muted-foreground/60 mt-2">Items you love will appear here</p>
            <a href="/products" wire:navigate class="mt-6 inline-block px-8 py-3 bg-primary text-primary-foreground text-[10px] font-black uppercase tracking-[0.3em] rounded-full hover:opacity-90 transition-opacity">
                Explore Collection
            </a>
        </div>
    </div>
    @endif
</div>
