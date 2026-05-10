@props(['item', 'availableStock' => 0])

@php
    $isLowStock = $availableStock > 0 && $availableStock <= 5;
    $isOutOfStock = $availableStock <= 0;
    $isMaxQuantity = $item['quantity'] >= $availableStock;
@endphp

<div wire:key="cart-item-{{ $item['product_id'] }}"
    class="group relative bg-card rounded-[3rem] p-8 border border-border transition-all duration-700 hover:border-primary/30 shadow-sm hover:shadow-[0_40px_80px_-20px_rgba(var(--primary-rgb),0.08)] overflow-hidden mb-8">
    
    <div class="flex flex-col md:flex-row gap-10 items-center md:items-start">
        
        {{-- Product Visual: High-End Showcase --}}
        <div class="relative w-44 h-44 bg-muted rounded-[2.5rem] overflow-hidden flex-shrink-0 border border-border shadow-inner">
            <img src="{{ url('storage', $item['image']) }}" 
                 alt="{{ $item['name'] }}" 
                 class="w-full h-full object-contain p-8 transition-transform duration-1000 ease-expo group-hover:scale-110 {{ $isOutOfStock ? 'opacity-50' : '' }}">
             
            {{-- Gradient Overlay on Hover --}}
            <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            {{-- Out of Stock Overlay --}}
            @if($isOutOfStock)
                <div class="absolute inset-0 bg-destructive/20 flex items-center justify-center">
                    <span class="px-3 py-1.5 bg-destructive text-destructive-foreground text-[8px] font-black uppercase tracking-widest rounded-full">
                        Out of Stock
                    </span>
                </div>
            @endif
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
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] px-5 py-2 bg-muted rounded-full border border-border text-muted-foreground">
                            {{ $item['variant'] ?? 'Original Edition' }}
                        </span>
                        @if($isOutOfStock)
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-destructive animate-pulse"></span>
                                <p class="text-[9px] text-destructive font-black uppercase tracking-[0.3em]">Out of Stock</p>
                            </div>
                        @elseif($isLowStock)
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-warning animate-pulse"></span>
                                <p class="text-[9px] text-warning font-black uppercase tracking-[0.3em]">Only {{ $availableStock }} left</p>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-success animate-pulse"></span>
                                <p class="text-[9px] text-success font-black uppercase tracking-[0.3em]">In Stock</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                {{-- Refined Remove Action --}}
                <button wire:click="removeItem({{ $item['product_id'] }})" 
                        class="group/btn text-muted-foreground hover:text-destructive transition-all p-4 hover:bg-destructive/10 rounded-2xl border border-transparent hover:border-destructive/20" 
                        title="Remove selection">
                    <x-lucide-trash-2 class="w-6 h-6 stroke-[1.5] transition-all group-hover/btn:rotate-12 group-hover/btn:scale-110" />
                </button>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center sm:items-end mt-12 md:mt-0 gap-8">
                {{-- Quantity Architecture --}}
                <div class="flex flex-col items-center gap-2">
                    <div class="flex items-center bg-muted rounded-full p-2 border border-border shadow-sm backdrop-blur-md">
                        <button wire:click="decreaseQty({{ $item['product_id'] }})" wire:loading.attr="disabled"
                                class="w-11 h-11 flex items-center justify-center text-muted-foreground hover:text-primary hover:bg-card rounded-full transition-all duration-500 shadow-none hover:shadow-xl disabled:opacity-50">
                            <x-lucide-minus class="w-5 h-5 stroke-[2.5]" />
                        </button>
                        
                        <span class="w-16 text-center font-black text-lg tracking-widest text-foreground">
                            {{ str_pad($item['quantity'], 2, '0', STR_PAD_LEFT) }}
                        </span>
                        
                        <button wire:click="increaseQty({{ $item['product_id'] }})" wire:loading.attr="disabled"
                                @if($isMaxQuantity || $isOutOfStock) disabled @endif
                                class="w-11 h-11 flex items-center justify-center rounded-full transition-all duration-500 shadow-none hover:shadow-xl {{ $isMaxQuantity || $isOutOfStock ? 'text-muted-foreground/30 cursor-not-allowed' : 'text-muted-foreground hover:text-primary hover:bg-card' }}">
                            <x-lucide-plus class="w-5 h-5 stroke-[2.5]" />
                        </button>
                    </div>
                    @if($isMaxQuantity && !$isOutOfStock)
                        <span class="text-[8px] text-warning font-black uppercase tracking-widest">Max reached</span>
                    @endif
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
