<div class="min-h-screen bg-background text-foreground transition-colors duration-500 overflow-hidden selection:bg-primary/20 selection:text-primary">
    {{-- Ambient Luxury Backgrounds --}}
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-primary/5 blur-[120px] rounded-full -z-10"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-primary/[0.02] blur-[100px] rounded-full -z-10"></div>
    <div class="absolute top-1/3 right-1/4 w-[300px] h-[300px] bg-secondary/5 blur-[100px] rounded-full -z-10 dark:bg-secondary/[0.03]"></div>

    <div class="max-w-7xl mx-auto px-6 py-20 relative z-10">

        {{-- Cart Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 border-b border-border/60 pb-10">
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-tr from-primary to-primary/20 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative w-16 h-16 bg-card border border-border rounded-2xl flex items-center justify-center shadow-card">
                        <x-lucide-shopping-bag class="w-8 h-8 text-primary" />
                    </div>
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/5 border border-primary/10 text-primary text-[9px] font-black uppercase tracking-[0.3em] mb-3">
                        <span class="w-1 h-1 rounded-full bg-primary animate-pulse"></span>
                        Current Selection
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black italic tracking-tighter uppercase leading-none">
                        Shopping <span class="text-primary">Cart</span>
                    </h1>
                </div>
            </div>

            <div class="hidden md:block">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground/50 italic">
                    {{ count($cart_items) }} Curated Pieces for Delivery
                </span>
            </div>
        </div>

        @if(!$cart_items)
            <x-card.empty-cart-item-card-state />
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                {{-- Cart Items List --}}
                <div class="lg:col-span-8 space-y-8 animate-in fade-in slide-in-from-left-4 duration-700">
                    <div class="flex flex-col gap-6">
                        @foreach ($cart_items_with_stock as $item)
                            <div class="group relative transition-all duration-500 hover:-translate-y-1">
                                <x-card.cart-item-card :item="$item" :availableStock="$item['available_stock']" :key="'cart-item-' . $item['product_id']" />
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('shop') }}" class="btn btn-ghost btn-sm">
                        <x-lucide-chevron-left class="w-3 h-3" />
                        Continue Browsing Archive
                    </a>
                </div>

                {{-- Summary Sidebar --}}
                <aside class="lg:col-span-4 lg:sticky lg:top-24">
                    <div class="card-glass p-10 shadow-card relative overflow-hidden group hover:border-secondary/20 transition-colors duration-500">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl"></div>
                        <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-secondary/5 rounded-full blur-3xl dark:bg-secondary/[0.03]"></div>
                        <div class="absolute top-1/2 left-0 w-0.5 h-12 bg-secondary/20 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em] mb-10 text-muted-foreground flex items-center justify-between">
                            Order Summary
                            <x-lucide-lock class="w-3 h-3 text-primary opacity-50" />
                        </h3>

                        <div class="space-y-5 mb-10">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Subtotal</span>
                                <span class="text-sm font-black text-foreground">{{ Number::currency($subtotal, 'NGN') }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Shipping</span>
                                @if($shipping == 0)
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500">Calculated at Checkout</span>
                                @else
                                    <span class="text-sm font-black text-foreground">{{ Number::currency($shipping, 'NGN') }}</span>
                                @endif
                            </div>

                            @if($tax > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Tax</span>
                                    <span class="text-sm font-black text-foreground">{{ Number::currency($tax, 'NGN') }}</span>
                                </div>
                            @endif

                            <div class="pt-6 border-t border-border/60 flex justify-between items-end">
                                <div>
                                    <span class="text-[8px] font-black uppercase tracking-[0.4em] text-muted-foreground block mb-2">Grand Total</span>
                                    <span class="text-4xl font-black italic tracking-tighter text-foreground">{{ Number::currency($total, 'NGN') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Checkout Button --}}
                        <button wire:click="checkout" wire:loading.attr="disabled"
                            class="btn btn-primary btn-xl w-full shadow-xl shadow-primary/20 disabled:opacity-70">
                            <span wire:loading.remove wire:target="checkout" class="flex items-center gap-4">
                                Secure Checkout
                                <x-lucide-arrow-right class="w-4 h-4 transition-transform duration-500 group-hover:translate-x-1" />
                            </span>
                            <div wire:loading.flex wire:target="checkout" class="items-center gap-3">
                                <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Securing...</span>
                            </div>
                        </button>

                        {{-- Payment Badges --}}
                        <div class="mt-8 flex items-center justify-center gap-6 opacity-20 grayscale hover:grayscale-0 hover:opacity-50 transition-all duration-700">
                            <x-lucide-shield-check class="w-5 h-5" />
                            <i class="fa-brands fa-cc-visa text-xl"></i>
                            <i class="fa-brands fa-cc-mastercard text-xl"></i>
                        </div>
                    </div>
                </aside>
            </div>
        @endif
    </div>
</div>
