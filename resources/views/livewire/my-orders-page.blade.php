<div class="min-h-screen bg-background text-foreground transition-colors duration-500 overflow-hidden relative">
    {{-- High-Fashion Watermark --}}
    <div class="absolute -top-10 -left-20 opacity-[0.03] dark:opacity-[0.01] pointer-events-none select-none">
        <h2 class="text-[25rem] font-black uppercase tracking-tighter italic">Archive</h2>
    </div>

    {{-- Ambient Background Atmosphere --}}
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-primary/5 blur-[150px] rounded-full -z-10"></div>
    <div class="absolute bottom-0 left-1/4 w-[500px] h-[500px] bg-primary/5 blur-[120px] rounded-full -z-10 animate-pulse"></div>

    <div class="max-w-6xl mx-auto px-6 py-24 relative z-10">
        
        {{-- Header Section: The Curator's Suite --}}
        <div class="mb-24 flex flex-col lg:flex-row lg:items-end justify-between gap-12 pb-16 border-b border-border/40">
            <div class="flex items-start gap-8">
                <div class="relative group">
                    {{-- Animated Glow --}}
                    <div class="absolute -inset-2 bg-gradient-to-tr from-primary to-primary/20 rounded-[2.5rem] blur-xl opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    
                    <div class="relative w-24 h-24 bg-card border border-border/60 rounded-[2.2rem] flex items-center justify-center shadow-2xl backdrop-blur-md group-hover:rotate-6 transition-transform duration-700">
                        <x-lucide-package class="w-11 h-11 text-primary stroke-[1.2]" />
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-primary/5 border border-primary/10 text-primary text-[9px] font-black uppercase tracking-[0.4em]">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Authenticated History
                    </div>
                    <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter uppercase leading-[0.8] text-foreground">
                        The <span class="text-primary" style="-webkit-text-stroke: 1px currentColor; -webkit-text-fill-color: transparent;">Archive</span>
                    </h1>
                    <p class="text-[11px] text-muted-foreground mt-6 font-black uppercase tracking-[0.3em] opacity-60 leading-relaxed max-w-md">
                        Managing your curated selection of bespoke acquisitions and digital manifests.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 lg:mb-2">
                <div class="group flex items-center gap-3 bg-card/40 backdrop-blur-xl border border-border/60 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-foreground/70 hover:border-primary/30 transition-all">
                    <x-lucide-shield-check class="w-4 h-4 text-primary group-hover:scale-110 transition-transform" />
                    Secure Vault
                </div>
                <div class="group flex items-center gap-3 bg-foreground text-background dark:bg-card dark:text-foreground border border-transparent px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl hover:bg-primary hover:text-background transition-all">
                    <x-lucide-download class="w-4 h-4 group-hover:-translate-y-1 transition-transform" />
                    Export Ledger
                </div>
            </div>
        </div>

        {{-- Orders Selection Grid --}}
        <div id="ordersContainer" class="grid gap-10">
            @forelse ($orders as $order)
                <div wire:key="order-{{ $order->id }}" class="group relative animate-in fade-in slide-in-from-bottom-8 duration-700">
                    <x-card.order-card :order="$order" />
                </div>
            @empty
                {{-- Empty State: The Aspirational Discovery --}}
                <div class="relative overflow-hidden bg-card/20 backdrop-blur-md rounded-[4rem] p-20 md:p-32 border border-dashed border-border/80 text-center shadow-inner group">
                    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    
                    <div class="relative inline-flex items-center justify-center w-40 h-40 mb-12">
                        <div class="absolute inset-0 bg-primary/5 rounded-full animate-[ping_3s_linear_infinite] opacity-30"></div>
                        <div class="relative flex items-center justify-center w-full h-full bg-background border border-border/60 rounded-full shadow-2xl group-hover:scale-110 transition-transform duration-700">
                            <x-lucide-shopping-bag class="w-16 h-16 text-muted-foreground/20 group-hover:text-primary/30 transition-colors duration-700" />
                        </div>
                    </div>

                    <h3 class="text-4xl md:text-6xl font-black italic tracking-tighter uppercase mb-6 leading-none">
                        Archive <span class="text-primary" style="-webkit-text-stroke: 1px currentColor; -webkit-text-fill-color: transparent;">Pending</span>
                    </h3>
                    <p class="text-[12px] text-muted-foreground mb-16 max-w-md mx-auto font-black uppercase tracking-[0.3em] opacity-60 leading-loose">
                        Your personal wardrobe is awaiting its first acquisition. Start your journey into the modern aesthetic today.
                    </p>
                    
                    <a href="/shop" wire:navigate
                        class="inline-flex items-center gap-5 px-16 py-7 bg-foreground text-background dark:bg-primary dark:text-background rounded-full font-black uppercase tracking-[0.4em] text-[10px] transition-all duration-700 hover:scale-105 hover:shadow-[0_20px_50px_rgba(var(--primary),0.3)] active:scale-95 group">
                        <x-lucide-sparkles class="w-4 h-4 group-hover:rotate-[30deg] transition-transform duration-500" />
                        Explore Archive
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="mt-32 pt-16 border-t border-border/40">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>