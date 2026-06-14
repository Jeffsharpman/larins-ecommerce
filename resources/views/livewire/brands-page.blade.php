<div class="min-h-screen bg-background text-foreground transition-colors duration-500 overflow-hidden selection:bg-primary/30 selection:text-primary">
    
    {{-- High-Fashion Ambient Backgrounds --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[700px] bg-primary/5 blur-[150px] rounded-full -z-10 animate-pulse-slow"></div>
    <div class="absolute bottom-0 right-[-10%] w-[600px] h-[600px] bg-primary/5 blur-[120px] rounded-full -z-10"></div>
    <div class="absolute top-1/3 right-[-5%] w-[500px] h-[500px] bg-secondary/5 blur-[120px] rounded-full -z-10"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-32">
        
        {{-- Header Section: The Manifesto --}}
        <div class="text-center mb-40 relative">
            <div class="inline-flex items-center gap-4 px-6 py-2 rounded-full bg-primary/5 dark:bg-secondary/[0.03] border border-primary/10 dark:border-secondary/10 text-primary text-[9px] font-black uppercase tracking-[0.5em] mb-12 animate-in fade-in slide-in-from-top-4 duration-1000">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-ping delay-500"></span>
                The 2026 Collection
            </div>
            
            <h1 class="text-7xl md:text-9xl font-black italic tracking-[-0.05em] uppercase leading-[0.8] mb-12 text-foreground">
                The Elite <br/>
                <span class="text-transparent border-text opacity-40 hover:opacity-100 transition-opacity duration-700 cursor-default" style="-webkit-text-stroke: 2px currentColor;">Houses.</span>
            </h1>
            
            <div class="flex justify-center items-center gap-6 mb-12">
                <div class="h-[1px] w-12 bg-primary/50"></div>
                <x-lucide-crown class="w-5 h-5 text-primary" />
                <div class="h-[1px] w-12 bg-secondary/40"></div>
                <div class="h-[1px] w-12 bg-primary/50"></div>
            </div>
            
            <p class="text-xl md:text-2xl text-muted-foreground max-w-3xl mx-auto leading-relaxed font-medium italic tracking-tight">
                "We don't just stock brands; we curate legacies. Discover the architects of modern beauty within the {{ $site->site_name }} collective."
            </p>
        </div>

        {{-- Staggered Brands Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-12 pb-32" id="brandsGrid">
            @forelse($brands as $index => $brand)
                {{-- Staggered layout for gallery feel --}}
                <div class="group {{ $index % 2 == 1 ? 'md:translate-y-20' : '' }} transition-all duration-1000 ease-out">
                    <a href="/brands/{{ $brand->slug }}" class="block relative group">
                        <div class="absolute -inset-2 bg-gradient-to-b from-primary/20 to-transparent rounded-[3rem] blur-2xl opacity-0 group-hover:opacity-100 transition duration-700"></div>
                        <div class="absolute -inset-2 bg-gradient-to-b from-secondary/10 to-transparent rounded-[3rem] blur-2xl opacity-0 group-hover:opacity-60 transition duration-700 delay-150"></div>
                        
                        <div class="relative aspect-[4/5] bg-card rounded-[2.5rem] border border-border overflow-hidden flex flex-col items-center justify-center p-10 group-hover:border-primary/30 group-hover:border-secondary/20 transition-all duration-500 shadow-sm group-hover:shadow-2xl">
                            
                            {{-- Brand Logo / Identity --}}
                            <div class="w-full h-full flex items-center justify-center group-hover:scale-110 transition-transform duration-700 grayscale group-hover:grayscale-0">
                                @if($brand->image)
                                    <img src="{{ url('storage', $brand->image) }}" alt="{{ $brand->name }}" class="max-w-full max-h-full object-contain">
                                @else
                                    <span class="text-6xl font-black italic text-muted-foreground/20 uppercase tracking-tighter">{{ substr($brand->name, 0, 1) }}</span>
                                @endif
                            </div>

                            {{-- Subtle Brand Info Overlay --}}
                            <div class="absolute bottom-8 left-0 right-0 text-center opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-primary">View Collection</p>
                            </div>
                        </div>

                        <div class="mt-6 text-center px-2">
                            <h3 class="text-lg font-black uppercase italic tracking-tighter text-foreground group-hover:text-primary transition-colors">{{ $brand->name }}</h3>
                            <p class="text-[8px] font-black text-muted-foreground uppercase tracking-widest mt-1">
                                {{ $brand->products_count }} Curated Pieces
                            </p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full py-40 text-center rounded-[4rem] border border-dashed border-border bg-muted/30">
                    <x-lucide-sparkle class="w-12 h-12 text-primary/20 mx-auto mb-6" />
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground">The Portfolio is being refreshed</p>
                </div>
            @endforelse
        </div>

        {{-- Interactive CTA: The Request Portal --}}
        <div class="mt-32 relative">
            <div class="relative bg-card/50 backdrop-blur-3xl rounded-[4rem] p-16 md:p-32 border border-border text-center overflow-hidden shadow-card group">
                
                {{-- Decorative Background Glows --}}
                <div class="absolute -right-20 -top-20 w-96 h-96 bg-primary/10 rounded-full blur-[100px] group-hover:scale-125 transition-transform duration-1000"></div>
                <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-primary/5 rounded-full blur-[100px] group-hover:scale-125 transition-transform duration-1000"></div>
                <div class="absolute right-40 -bottom-10 w-72 h-72 bg-secondary/10 rounded-full blur-[100px] group-hover:scale-125 transition-transform duration-1000 delay-300"></div>

                <div class="relative z-10 max-w-2xl mx-auto space-y-10">
                    <x-lucide-help-circle class="w-12 h-12 text-primary mx-auto opacity-50" />
                    
                    <h3 class="text-5xl md:text-6xl font-black italic tracking-tighter uppercase leading-[0.9] text-foreground">
                        Missing Your <br/> <span class="text-primary">Signature Maison?</span>
                    </h3>
                    
                    <p class="text-lg text-muted-foreground font-medium leading-relaxed tracking-tight">
                        Our collection is curated by global specialists. If you believe a prestigious house belongs in our portfolio, submit a recommendation to our curators.
                    </p>
                    
                    <div class="pt-8">
                        <a wire:navigate href="/contact" 
                           class="inline-flex items-center gap-6 bg-foreground text-background dark:bg-primary dark:text-primary-foreground px-16 py-7 rounded-3xl font-black uppercase tracking-[0.3em] text-[10px] transition-all duration-700 hover:shadow-card hover:shadow-secondary/10 active:scale-95 group">
                            <span class="relative">
                                <x-lucide-send class="w-5 h-5 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform duration-500" />
                            </span>
                            Contact Curator
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>