@props(['product'])

<div wire:key="product-{{ $product->id }}"
    class="group relative bg-white dark:bg-[#0d0d0d] rounded-[2.5rem] overflow-hidden border border-slate-200 dark:border-white/10 shadow-sm hover:shadow-2xl hover:shadow-primary/10 hover:-translate-y-2 transition-all duration-700 flex flex-col h-full min-h-[480px]">

    {{-- Image Container --}}
    <div class="relative aspect-[4/5] bg-[#fcfcfc] dark:bg-black overflow-hidden group-hover:bg-white dark:group-hover:bg-[#050505] transition-colors duration-700">
        <img src="{{ url('storage', $product->images[0]) }}" 
             alt="{{ $product->name }}"
             class="absolute inset-0 w-full h-full object-contain p-8 transform group-hover:scale-110 transition-transform duration-1000 ease-out"
             loading="lazy">

        {{-- Badges --}}
        <div class="absolute top-5 left-5 flex flex-col gap-2 z-20">
            <span class="px-3 py-1.5 text-[8px] font-black uppercase tracking-[0.3em] bg-white/90 dark:bg-black/80 text-slate-900 dark:text-primary backdrop-blur-md rounded-full border border-slate-200/50 dark:border-white/10 shadow-sm">
                {{ $product->category->name }}
            </span>
        </div>

        {{-- Wishlist Button --}}
        <button class="absolute top-5 right-5 w-10 h-10 bg-white dark:bg-black/80 backdrop-blur-md border border-slate-200 dark:border-white/10 rounded-full flex items-center justify-center text-slate-400 opacity-0 translate-y-[-10px] group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 hover:bg-primary hover:text-white dark:hover:bg-primary shadow-sm z-20"
                aria-label="Add to wishlist">
            <x-lucide-heart class="w-4 h-4" />
        </button>

        {{-- Quick Add (Desktop) --}}
        <div class="absolute inset-x-0 bottom-0 p-6 translate-y-full group-hover:translate-y-0 transition-transform duration-500 bg-gradient-to-t from-white dark:from-[#0d0d0d] via-white/80 dark:via-[#0d0d0d]/80 to-transparent hidden lg:block z-30">
            <button wire:click.prevent="addToCart({{ $product->id }})"
                    class="w-full py-4 bg-slate-900 dark:bg-white text-white dark:text-black rounded-full text-[10px] font-black uppercase tracking-[0.3em] flex items-center justify-center gap-3 hover:bg-primary dark:hover:bg-primary hover:text-white transition-all duration-300">
                
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
    <div class="p-8 flex-1 flex flex-col relative z-10 bg-white dark:bg-[#0d0d0d]">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-primary">
                {{ $product->brand->name }}
            </span>
            <div class="flex items-center gap-1.5 px-2 py-1 bg-slate-50 dark:bg-white/5 rounded-md">
                <x-lucide-star class="w-3 h-3 fill-primary text-primary" />
                <span class="text-[10px] font-black text-slate-900 dark:text-slate-100">{{ $product->rating ?? '5.0' }}</span>
            </div>
        </div>

        <h3 class="text-2xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 mb-6 leading-[0.9] line-clamp-2">
            <a wire:navigate href="{{ route('product.details', $product->slug) }}" class="hover:text-primary transition-colors">
                {{ $product->name }}
            </a>
        </h3>

        {{-- Mobile Action --}}
        <div class="lg:hidden mb-6">
            <button wire:click.prevent="addToCart({{ $product->id }})"
                    class="w-full py-3 bg-slate-50 dark:bg-white/5 text-slate-900 dark:text-white border border-slate-200 dark:border-white/10 rounded-full text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-2 active:bg-primary active:text-white transition-all">
                <x-lucide-shopping-bag class="w-4 h-4" wire:loading.remove wire:target="addToCart({{ $product->id }})" />
                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                <x-lucide-refresh-cw wire:loading wire:target="addToCart({{ $product->id }})" class="w-4 h-4 animate-spin" />
            </button>
        </div>

        <div class="mt-auto flex items-end justify-between pt-4 border-t border-slate-100 dark:border-white/5">
            <div class="flex flex-col">
                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-[0.2em] mb-1">Valuation</span>
                <span class="text-2xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100">
                    ₦{{ number_format($product->price, 2) }}
                </span>
            </div>

            <a wire:navigate href="{{ route('product.details', $product->slug) }}"
                class="w-12 h-12 rounded-full border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:border-primary group-hover:text-white transition-all duration-500 transform group-hover:rotate-[-45deg]">
                <x-lucide-arrow-right class="w-5 h-5" />
            </a>
        </div>
    </div>
</div>