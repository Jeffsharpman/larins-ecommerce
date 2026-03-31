<div class="min-h-screen bg-background text-foreground transition-colors duration-500 overflow-hidden relative">
    {{-- Ambient Luxury Backgrounds - Using Theme Variables --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-primary/5 blur-[120px] rounded-full -z-10 animate-pulse-slow"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] bg-gold/5 blur-[100px] rounded-full -z-10 animate-float"></div>

    <div class="max-w-4xl mx-auto px-4 py-24 relative z-10">
        
        {{-- Success Celebration Header --}}
        <div class="text-center mb-20 relative">
            <div class="relative inline-block mb-12">
                {{-- Main Animated Icon with Glow --}}
                <div class="relative group">
                    <div class="absolute -inset-4 bg-emerald-500/20 rounded-full blur-2xl group-hover:bg-emerald-500/30 transition duration-1000"></div>
                    <div class="relative w-32 h-32 bg-card border border-emerald-500/20 rounded-full flex items-center justify-center shadow-[0_0_50px_-12px_rgba(16,185,129,0.3)] animate-bounce-slow">
                        <x-lucide-check-circle class="w-16 h-16 text-emerald-500" />
                    </div>
                </div>
                
                {{-- Boutique Particles --}}
                <x-lucide-sparkles class="absolute -top-4 -right-6 w-8 h-8 text-gold animate-pulse" />
                <x-lucide-star class="absolute top-12 -left-10 w-6 h-6 text-gold/40 animate-spin-slow" />
            </div>

            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold/10 border border-gold/20 text-gold text-[10px] font-black uppercase tracking-[0.4em] mb-4">
                    Order Received
                </div>
                <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter uppercase leading-none">
                    Order <span class="text-transparent text-stroke-sm dark:text-stroke-white">Confirmed.</span>
                </h1>
                <p class="text-muted-foreground text-sm font-medium max-w-lg mx-auto leading-relaxed italic opacity-80 pt-4">
                    "Every masterpiece takes time. Thank you, {{ $order->first_name ?? 'Joshua' }}. Your selection is now being processed with artisanal precision."
                </p>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-6 mt-12">
                <div class="flex items-center gap-3 px-6 py-3 bg-card/50 backdrop-blur-md rounded-2xl border border-border shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-foreground/70">Email Receipt Sent</span>
                </div>
                <div class="flex items-center gap-3 px-6 py-3 bg-card/50 backdrop-blur-md rounded-2xl border border-border shadow-sm">
                    <x-lucide-clock class="w-4 h-4 text-gold" />
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-foreground/70">Est. Arrival: 45 Mins</span>
                </div>
            </div>
        </div>

        {{-- Order Details Card --}}
        <div class="bg-card/40 backdrop-blur-2xl rounded-[3rem] border border-border shadow-2xl overflow-hidden mb-16 transition-all duration-700 hover:shadow-gold/5 group">
            <div class="bg-muted/30 px-10 py-6 border-b border-border/60 flex justify-between items-center">
                <div class="flex flex-col">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-1">Transaction Ref</span>
                    <span class="text-sm font-black text-foreground">#{{ $order->order_number ?? 'LRN-9920' }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-gold mb-1 block">Status</span>
                    <span class="text-[10px] font-black uppercase bg-gold/10 text-gold px-3 py-1 rounded-full">Preparing</span>
                </div>
            </div>
            
            <div class="p-10">
                <div id="orderDetailsContainer" class="space-y-8">
                    @if(isset($order))
                        <x-card.summary-table :order="$order" />
                    @else
                        <div class="flex justify-between items-center group/item transition-colors">
                             <span class="text-[11px] font-black uppercase tracking-widest text-muted-foreground">Payment Method</span>
                             <span class="text-xs font-black italic uppercase text-foreground">Secure Card via Paystack</span>
                        </div>
                        <div class="pt-8 border-t border-dashed border-border flex justify-between items-end">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground block mb-2">Total Amount Paid</span>
                                <span class="text-5xl font-black italic tracking-tighter text-foreground">₦14,500.00</span>
                            </div>
                            <x-lucide-shield-check class="w-8 h-8 text-gold/30" />
                        </div>
                    @endif
                </div>
            </div>
        </div>

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
                    <x-lucide-truck class="w-5 h-5 text-gold" />
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-foreground">Artisanal Logistics</span>
                </div>
                <div class="flex items-center gap-3">
                    <x-lucide-shield-check class="w-5 h-5 text-gold" />
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-foreground">Buyer Protection</span>
                </div>
                <div class="flex items-center gap-3">
                    <x-lucide-headphones class="w-5 h-5 text-gold" />
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-foreground">24/7 Concierge</span>
                </div>
            </div>
        </div>
    </div>
</div>