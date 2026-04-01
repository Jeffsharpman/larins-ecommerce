@props(['item'])

<div wire:key="cart-item-{{ $item['product_id'] }}"
    class="group relative bg-card dark:bg-card rounded-[3rem] p-8 border border-border dark:border-border transition-all duration-700 hover:border-primary/30 shadow-sm hover:shadow-[0_40px_80px_-20px_rgba(var(--primary-rgb),0.08)] overflow-hidden mb-8">
    
    <div class="flex flex-col md:flex-row gap-10 items-center md:items-start">
        
        {{-- Product Visual: High-End Showcase --}}
        <div class="relative w-44 h-44 bg-muted dark:bg-black rounded-[2.5rem] overflow-hidden flex-shrink-0 border border-border dark:border-border shadow-inner">
            <img src="{{ url('storage', $item['image']) }}" 
                 alt="{{ $item['name'] }}" 
                 class="w-full h-full object-contain p-8 transition-transform duration-1000 ease-expo group-hover:scale-110">
            
            {{-- Gradient Overlay on Hover --}}
            <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
        </div>

        {{-- Product Details --}}
        <div class="flex-1 w-full min-w-0 flex flex-col justify-between self-stretch py-2">
            <div class="flex justify-between items-start gap-8">
                <div class="min-w-0">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-[9px] font-black uppercase tracking-[0.5em] text-primary">
                            Selection
                        </span>
                        <span class="h-[1px] w-8 bg-border"></span>
                        <span class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground">
                            Ref. {{ strtoupper(substr(md5($item['product_id']), 0, 8)) }}
                        </span>
                    </div>

                    <h3 class="text-3xl md:text-4xl font-black italic tracking-tighter text-foreground truncate group-hover:text-primary transition-colors duration-500">
                        {{ $item['name'] }}
                    </h3>

                    <div class="flex items-center gap-5 mt-4">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] px-5 py-2 bg-muted dark:bg-muted rounded-full border border-border dark:border-border text-muted-foreground">
                            {{ $item['variant'] ?? 'Original Edition' }}
                        </span>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <p class="text-[9px] text-emerald-600 dark:text-emerald-500 font-black uppercase tracking-[0.3em]">In Stock</p>
                        </div>
                    </div>
                </div>
                
                {{-- Refined Remove Action --}}
                <button wire:click="removeItem({{ $item['product_id'] }})" 
                        class="group/btn text-muted-foreground hover:text-red-500 transition-all p-4 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-2xl border border-transparent hover:border-red-100 dark:hover:border-red-500/20" 
                        title="Remove selection">
                    <x-lucide-trash-2 class="w-6 h-6 stroke-[1.5] transition-all group-hover/btn:rotate-12 group-hover/btn:scale-110" />
                </button>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center sm:items-end mt-12 md:mt-0 gap-8">
                {{-- Quantity Architecture --}}
                <div class="flex items-center bg-muted dark:bg-muted rounded-full p-2 border border-border dark:border-border shadow-sm backdrop-blur-md">
                    <button wire:click="decreaseQty({{ $item['product_id'] }})" 
                            class="w-11 h-11 flex items-center justify-center text-muted-foreground hover:text-primary hover:bg-card dark:hover:bg-card rounded-full transition-all duration-500 shadow-none hover:shadow-xl">
                        <x-lucide-minus class="w-5 h-5 stroke-[2.5]" />
                    </button>
                    
                    <span class="w-16 text-center font-black text-lg tracking-widest text-foreground">
                        {{ str_pad($item['quantity'], 2, '0', STR_PAD_LEFT) }}
                    </span>
                    
                    <button wire:click="increaseQty({{ $item['product_id'] }})" 
                            class="w-11 h-11 flex items-center justify-center text-muted-foreground hover:text-primary hover:bg-card dark:hover:bg-card rounded-full transition-all duration-500 shadow-none hover:shadow-xl">
                        <x-lucide-plus class="w-5 h-5 stroke-[2.5]" />
                    </button>
                </div>

                {{-- Valuation / Pricing --}}
                <div class="text-center sm:text-right">
                    <p class="text-[10px] text-muted-foreground uppercase font-black tracking-[0.4em] mb-2">Total Valuation</p>
                    <div class="flex flex-col">
                        <span class="text-4xl font-black italic tracking-tighter text-foreground">
                            ₦{{ number_format($item['unit_amount'] * $item['quantity'], 2) }}
                        </span>
                        <div class="flex items-center justify-center sm:justify-end gap-2 mt-1">
                            <span class="h-[1px] w-3 bg-primary/30"></span>
                            <span class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest">
                                ₦{{ number_format($item['unit_amount'], 2) }} unit
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
