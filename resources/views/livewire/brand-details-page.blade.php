<div class="bg-background min-h-screen selection:bg-primary/20 selection:text-primary">
    
    {{-- Brand Header: The Exhibition Profile --}}
    <header class="relative pt-32 pb-24 px-6 border-b border-border/50 overflow-hidden">
        {{-- Ambient Branding Glow: Follows Primary --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/5 blur-[140px] rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-primary/[0.02] blur-[100px] rounded-full translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>
        <div class="absolute top-1/2 right-[-5%] w-[450px] h-[450px] bg-secondary/5 blur-[120px] rounded-full pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center lg:items-end gap-16 relative z-10">
            {{-- Brand Portrait Archive --}}
            <div class="relative group">
                <div class="absolute -inset-4 bg-gradient-to-tr from-primary/20 to-transparent rounded-[3.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition duration-1000"></div>
                <div class="absolute -inset-4 bg-gradient-to-tr from-secondary/10 to-transparent rounded-[3.5rem] blur-2xl opacity-0 group-hover:opacity-60 transition duration-1000 delay-300"></div>
                <div class="relative w-56 h-56 md:w-72 md:h-72 bg-card rounded-[3rem] border border-border p-10 flex items-center justify-center shadow-card backdrop-blur-sm">
                    @if($brand->image)
                        <img src="{{ url('storage', $brand->image) }}" alt="{{ $brand->name }}" class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                    @else
                        <span class="text-6xl font-black italic text-muted-foreground/20 uppercase tracking-tighter">{{ substr($brand->name, 0, 1) }}</span>
                    @endif
                    
                    {{-- Authenticity Tag --}}
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-foreground rounded-full shadow-xl">
                        <p class="text-[8px] font-black uppercase tracking-[0.4em] text-background">Verified</p>
                    </div>
                </div>
            </div>

            {{-- Brand Intel --}}
            <div class="flex-1 space-y-8 text-center lg:text-left pb-4">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-4 group cursor-default">
                        <div class="h-[1px] w-10 bg-primary group-hover:w-16 transition-all duration-500"></div>
                        <div class="h-[1px] w-6 bg-secondary/40 group-hover:w-10 transition-all duration-500"></div>
                        <h2 class="text-[10px] font-black uppercase tracking-[0.6em] text-primary dark:text-secondary">The Maison Series</h2>
                    </div>
                    
                    <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter text-foreground leading-[0.85] uppercase">
                        {{ $brand->name }}
                    </h1>
                </div>

                <p class="max-w-2xl text-base md:text-lg font-medium text-muted-foreground leading-relaxed tracking-tight">
                    {{ $brand->description ?? 'A cornerstone of the ' . $site->site_name . ' collective, this Maison represents the pinnacle of international craftsmanship and modern luxury.' }}
                </p>

                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-10 pt-4">
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-muted-foreground uppercase tracking-[0.3em]">Curated Pieces</p>
                        <p class="text-2xl font-black italic text-foreground">{{ $activeProductsCount }}</p>
                    </div>
                    <div class="h-10 w-[1px] bg-border hidden md:block"></div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black text-muted-foreground uppercase tracking-[0.3em]">Exhibition Status</p>
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <p class="text-sm font-black italic text-emerald-500 uppercase tracking-tighter">Active Listing</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Collection Grid --}}
    <main class="max-w-7xl mx-auto py-24 px-6">
        <div class="flex items-center gap-8 mb-20 group">
            <h3 class="text-[11px] font-black uppercase tracking-[0.5em] text-muted-foreground group-hover:text-foreground transition-colors">Catalog 2026</h3>
            <div class="h-[1px] flex-1 bg-gradient-to-r from-border via-border/50 to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-10 gap-y-20">
            @forelse($products as $product)
                <div wire:key="product-{{ $product->id }}" class="group">
                    <div class="relative mb-8">
                        <a href="/products/{{ $product->slug }}" class="block relative aspect-[3/4] bg-muted rounded-[2.5rem] overflow-hidden border border-border group-hover:border-primary/30 group-hover:border-secondary/20 transition-all duration-700">
                            @php $images = is_array($product->images) ? $product->images : json_decode($product->images, true); @endphp
                            @if(!empty($images[0]))
                                <img src="{{ url('storage', $images[0]) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000 ease-out">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                                    <span class="text-6xl font-black text-primary/30">{{ substr($product->name, 0, 1) }}</span>
                                </div>
                            @endif
                            
                            {{-- Price Badge: Glassmorphism --}}
                            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-[85%]">
                                <div class="px-6 py-4 bg-card/70 backdrop-blur-xl rounded-2xl border border-border/50 flex justify-between items-center opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-foreground">Acquire</span>
                                    <span class="text-sm font-black italic text-primary">₦{{ number_format($product->price, 0) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="px-4 space-y-2">
                        <div class="flex justify-between items-start gap-4">
                            <h4 class="text-xl font-black italic tracking-tighter text-foreground leading-none uppercase">
                                {{ $product->name }}
                            </h4>
                            <x-lucide-arrow-up-right class="w-4 h-4 text-muted-foreground group-hover:text-primary group-hover:translate-x-1 group-hover:-translate-y-1 transition-all" />
                        </div>
                        <p class="text-[9px] font-black text-muted-foreground uppercase tracking-[0.3em]">
                            {{ $brand->name }} &bull; Boutique Exclusive
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center rounded-[4rem] border border-dashed border-border bg-muted/30">
                    <div class="max-w-xs mx-auto space-y-6">
                        <x-lucide-archive-x class="w-12 h-12 text-muted-foreground mx-auto" />
                        <div class="space-y-2">
                            <p class="text-[11px] font-black uppercase tracking-[0.4em] text-foreground">The Vault is Sealed</p>
                            <p class="text-xs font-medium text-muted-foreground leading-relaxed uppercase tracking-wider">New acquisitions for the {{ $brand->name }} collection are currently being vetted.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Luxury Pagination --}}
        <div class="mt-32 flex justify-center">
            {{ $products->links() }}
        </div>
    </main>
</div>