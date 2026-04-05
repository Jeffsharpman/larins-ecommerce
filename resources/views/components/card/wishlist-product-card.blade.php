<div class="group relative bg-card border border-border/40 rounded-[2.5rem] overflow-hidden hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-2 transition-all duration-500">
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
        
        <div class="absolute top-5 right-5 flex flex-col gap-3 translate-x-12 group-hover:translate-x-0 transition-transform duration-500">
            <button 
                wire:click="removeFromWishlist({{ $product->id }})"
                class="w-10 h-10 bg-background/90 backdrop-blur-md rounded-full flex items-center justify-center text-destructive shadow-lg hover:bg-destructive hover:text-white transition-all">
                <x-lucide-x class="w-5 h-5" />
            </button>
        </div>

        <div class="absolute inset-x-0 bottom-0 p-6 translate-y-full group-hover:translate-y-0 transition-transform duration-500 bg-gradient-to-t from-black/80 to-transparent">
            <button 
                wire:click="{{ $action }}"
                class="w-full py-4 bg-primary text-primary-foreground font-black uppercase tracking-tighter italic rounded-2xl flex items-center justify-center gap-3 hover:scale-[1.02] active:scale-95 transition-all">
                <x-lucide-shopping-bag class="w-5 h-5" />
                {{ $buttonText }}
            </button>
        </div>
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
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-border/50">
            <div class="flex flex-col">
                <span class="text-lg font-black italic tracking-tighter">&#x20A6;{{ number_format($product->price, 2) }}</span>
                @if($product->compare_price && $product->compare_price > $product->price)
                <span class="text-[10px] text-muted-foreground line-through font-bold">&#x20A6;{{ number_format($product->compare_price, 2) }}</span>
                @endif
            </div>
            @if($product->compare_price && $product->compare_price > $product->price)
            <div class="px-3 py-1 bg-green-500/10 text-green-500 text-[10px] font-black rounded-lg uppercase">
                -{{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
            </div>
            @endif
        </div>
    </div>
</div>
