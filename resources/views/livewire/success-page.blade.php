<div class="min-h-screen bg-background text-foreground transition-colors duration-500 overflow-hidden relative">
    {{-- Ambient Luxury Backgrounds --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-primary/5 blur-[120px] rounded-full -z-10 animate-pulse-slow"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] bg-primary/5 blur-[100px] rounded-full -z-10 animate-float"></div>

    <div class="max-w-4xl mx-auto px-4 py-24 relative z-10">
        
        {{-- Success Celebration Header --}}
        <div class="text-center mb-20 relative">
            <div class="relative inline-block mb-12">
                {{-- Main Animated Icon with Glow --}}
                <div class="relative group">
                    <div class="absolute -inset-4 bg-success/20 rounded-full blur-2xl group-hover:bg-success/30 transition duration-1000"></div>
                    <div class="absolute -inset-2 bg-secondary/10 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition duration-1000 dark:bg-secondary/[0.05]"></div>
                    <div class="relative w-32 h-32 bg-card border border-success/20 rounded-full flex items-center justify-center shadow-[0_0_50px_-12px_rgba(var(--primary-rgb), 0.15)] animate-bounce-slow">
                        <x-lucide-check-circle class="w-16 h-16 text-success" />
                    </div>
                </div>
                
                {{-- Boutique Particles --}}
                <x-lucide-sparkles class="absolute -top-4 -right-6 w-8 h-8 text-primary animate-pulse" />
                <x-lucide-star class="absolute top-12 -left-10 w-6 h-6 text-primary/40 animate-spin-slow" />
                <div class="absolute -bottom-2 left-0 w-2 h-2 rounded-full bg-secondary/20 dark:bg-secondary/10"></div>
                <div class="absolute top-0 -left-4 w-1 h-1 rounded-full bg-secondary/30 dark:bg-secondary/15"></div>
            </div>

            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-black uppercase tracking-[0.4em] mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Order Received
                </div>
                <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter uppercase leading-none">
                    Order <span class="text-transparent bg-clip-text bg-gradient-to-r from-foreground to-primary">Confirmed.</span>
                </h1>
                @if($order && $order->address)
                    <p class="text-muted-foreground text-sm font-medium max-w-lg mx-auto leading-relaxed italic opacity-80 pt-4">
                        Thank you, {{ $order->address->first_name }}. Your selection is now being processed with artisanal precision.
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap justify-center items-center gap-6 mt-12">
                <div class="flex items-center gap-3 px-6 py-3 bg-card/50 backdrop-blur-md rounded-2xl border border-border shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-foreground/70">Email Receipt Sent</span>
                </div>
                <div class="flex items-center gap-3 px-6 py-3 bg-card/50 backdrop-blur-md rounded-2xl border border-border shadow-sm">
                    <x-lucide-clock class="w-4 h-4 text-primary" />
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-foreground/70">Processing Your Order</span>
                </div>
            </div>
        </div>

        {{-- Order Details Card --}}
        @if($order)
            <div class="bg-card/40 backdrop-blur-2xl rounded-[3rem] border border-border shadow-2xl overflow-hidden mb-16 transition-all duration-700 hover:shadow-primary/5 hover:border-secondary/20 group">
                <div class="bg-muted/30 px-10 py-6 border-b border-border/60 flex justify-between items-center">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-1">Transaction Ref</span>
                        <span class="text-sm font-black text-foreground">#{{ $order->order_number }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-1 block">Status</span>
                            <span class="text-[10px] font-black uppercase bg-emerald-500/10 text-emerald-600 px-3 py-1 rounded-full">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-1 block">Payment</span>
                            <span class="text-[10px] font-black uppercase bg-primary/10 text-primary px-3 py-1 rounded-full">
                                {{ ucfirst($order->payment_method) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-10">
                    {{-- Order Items --}}
                    @if($order_items->count() > 0)
                        <div class="space-y-4 mb-8 pb-8 border-b border-border/30">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-4">Items Ordered</h4>
                            @foreach($order_items as $item)
                                <div class="flex items-center justify-between py-4 border-b border-border/10 last:border-0">
                                    <div class="flex items-center gap-4">
                                        @if(isset($item->product) && isset($item->product->images[0]))
                                            <img src="{{ url('storage/' . $item->product->images[0]) }}" 
                                                alt="{{ $item->name }}" 
                                                class="w-16 h-16 rounded-2xl object-cover bg-muted">
                                        @else
                                            <div class="w-16 h-16 rounded-2xl bg-muted flex items-center justify-center">
                                                <x-lucide-package class="w-6 h-6 text-muted-foreground" />
                                            </div>
                                        @endif
                                        <div>
                                            <h5 class="font-black text-sm">{{ $item->name }}</h5>
                                            <span class="text-[10px] text-muted-foreground uppercase tracking-wider">Qty: {{ $item->quantity }} × {{ Number::currency($item->unit_amount, 'NGN') }}</span>
                                        </div>
                                    </div>
                                    <span class="text-sm font-black italic">{{ Number::currency($item->total_amount, 'NGN') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Order Summary --}}
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Subtotal</span>
                            <span class="text-sm font-black italic">{{ Number::currency($order->grand_total - $order->shipping_amount, 'NGN') }}</span>
                        </div>
                        @if($order->shipping_amount > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Shipping ({{ $order->shipping_method }})</span>
                                <span class="text-sm font-black italic">{{ Number::currency($order->shipping_amount, 'NGN') }}</span>
                            </div>
                        @else
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-500">Shipping</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-500">Complimentary</span>
                            </div>
                        @endif
                        <div class="pt-6 border-t border-dashed border-border flex justify-between items-end">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground block mb-2">Total Paid</span>
                                <span class="text-5xl font-black italic tracking-tighter text-foreground">{{ Number::currency($order->grand_total, 'NGN') }}</span>
                            </div>
                            <x-lucide-shield-check class="w-8 h-8 text-primary/30" />
                        </div>
                    </div>

                    {{-- Shipping Address --}}
                    @if($order->address)
                        <div class="mt-8 pt-8 border-t border-border/30">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-4">Shipping To</h4>
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center">
                                    <x-lucide-map-pin class="w-5 h-5 text-primary" />
                                </div>
                                <div>
                                    <p class="font-black text-sm">{{ $order->address->first_name }} {{ $order->address->last_name }}</p>
                                    <p class="text-[10px] text-muted-foreground uppercase tracking-wider mt-1">
                                        {{ $order->address->street_address }}, {{ $order->address->city }}, {{ $order->address->state }}
                                    </p>
                                    <p class="text-[10px] text-muted-foreground uppercase tracking-wider">
                                        +234 {{ $order->address->phone }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-card/40 backdrop-blur-2xl rounded-[3rem] border border-border shadow-2xl p-16 text-center mb-16">
                <x-lucide-package class="w-16 h-16 text-muted-foreground/30 mx-auto mb-6" />
                <p class="text-muted-foreground font-medium">Order details unavailable</p>
            </div>
        @endif

        {{-- Actions --}}
        <div class="space-y-12">
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a wire:navigate href="/my-orders" 
                   class="w-full sm:w-auto px-12 py-6 bg-primary text-primary-foreground rounded-3xl font-black uppercase tracking-[0.3em] text-[10px] hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-primary/20 group flex items-center justify-center gap-4">
                    <x-lucide-list class="w-4 h-4 group-hover:rotate-12 transition-transform" />
                    Track My Selection
                </a>
                
                <a wire:navigate href="/products" 
                   class="w-full sm:w-auto px-12 py-6 bg-card text-foreground border border-border rounded-3xl font-black uppercase tracking-[0.3em] text-[10px] hover:bg-muted transition-all flex items-center justify-center gap-4 group">
                    <x-lucide-shopping-bag class="w-4 h-4 group-hover:-translate-y-1 transition-transform" />
                    Return to Boutique
                </a>
            </div>

            {{-- Trust Badges --}}
            <div class="pt-12 border-t border-border/40 flex flex-wrap justify-center items-center gap-x-16 gap-y-8 opacity-40 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-1000">
                <div class="flex items-center gap-3">
                    <x-lucide-truck class="w-5 h-5 text-primary" />
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-foreground">Artisanal Logistics</span>
                </div>
                <div class="flex items-center gap-3">
                    <x-lucide-shield-check class="w-5 h-5 text-primary" />
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-foreground">Buyer Protection</span>
                </div>
                <div class="flex items-center gap-3">
                    <x-lucide-headphones class="w-5 h-5 text-primary" />
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-foreground">24/7 Concierge</span>
                </div>
            </div>
        </div>
    </div>
</div>
