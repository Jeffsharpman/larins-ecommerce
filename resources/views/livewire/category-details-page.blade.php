<div class="bg-background min-h-screen transition-colors duration-500">
    {{-- Collection Header --}}
    <header class="relative pt-40 pb-24 px-6 lg:px-12 border-b border-border/60 overflow-hidden">
        {{-- High-Fashion Gradient Glow --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/5 blur-[150px] rounded-full -z-10"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gradient-to-tr from-secondary/5 via-secondary/5 to-transparent blur-[150px] rounded-full -z-10"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-end">
                
                {{-- Left Side: Title & Volume --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-4 animate-in fade-in slide-in-from-left-4 duration-1000">
                        <span class="text-[10px] font-black uppercase tracking-[0.5em] text-primary">Collection</span>
                        <span class="w-8 h-[1px] bg-gradient-to-r from-primary to-secondary"></span>
                        <span class="text-[10px] font-black uppercase tracking-[0.5em] text-secondary/80">VOL. 01</span>
                    </div>
                    
                    <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter text-foreground leading-[0.8] uppercase">
                        {{ $category->name }}
                    </h1>
                </div>

                {{-- Right Side: The Manifesto --}}
                <div class="lg:pl-20 space-y-8">
                    <p class="text-[11px] font-bold text-muted-foreground uppercase tracking-[0.2em] leading-relaxed max-w-lg">
                        {{ $category->description ?? 'A curated selection of archival pieces, hand-selected to represent the pinnacle of modern luxury and functional art.' }}
                    </p>
                    
                    <div class="flex items-center gap-12 pt-4">
                        <div>
                            <p class="text-[9px] font-black text-muted-foreground/60 uppercase tracking-widest mb-2">Items in Gallery</p>
                            <p class="text-3xl font-black italic text-foreground tracking-tighter">{{ str_pad($products->total(), 2, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="w-[1px] h-10 bg-border"></div>
                        <div>
                            <p class="text-[9px] font-black text-muted-foreground/60 uppercase tracking-widest mb-2">Availability</p>
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <p class="text-[10px] font-black italic text-foreground uppercase tracking-widest">Live Archive</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Subtle Background Watermark --}}
        <div class="absolute -bottom-10 -left-10 text-[15rem] font-black italic text-foreground/[0.03] pointer-events-none select-none tracking-tighter uppercase">
            {{ substr($category->name, 0, 3) }}
        </div>
    </header>

    {{-- The Collection Gallery --}}
    <main class="max-w-7xl mx-auto py-24 px-6 lg:px-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-24">
            @forelse($products as $product)
                <div wire:key="collection-item-{{ $product->id }}" class="group">
                    <a href="/products/{{ $product->slug }}" class="block relative overflow-hidden rounded-[3rem] bg-card border border-border transition-all duration-700 hover:shadow-card group-hover:border-secondary/20">
                        
                        {{-- Acquisition Tag --}}
                        <div class="absolute top-8 left-8 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            <span class="px-4 py-1.5 bg-background/90 backdrop-blur-md rounded-full text-[8px] font-black uppercase tracking-[0.2em] text-foreground border border-border">
                                Acquisition Available
                            </span>
                        </div>

                        {{-- Product Image --}}
                        <div class="aspect-[3/4] p-12 flex items-center justify-center">
                            @php $images = is_array($product->images) ? $product->images : json_decode($product->images, true); @endphp
                            @if(!empty($images[0]))
                                <img src="{{ url('storage', $images[0]) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-contain filter grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/20 to-primary/5 rounded-3xl">
                                    <span class="text-8xl font-black text-primary/30">{{ substr($product->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Price Footer Overlay --}}
                        <div class="absolute bottom-0 inset-x-0 p-8 bg-gradient-to-t from-background via-background/80 to-transparent opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                            <p class="text-2xl font-black italic tracking-tighter text-foreground text-center">
                                ₦{{ number_format($product->price, 0) }}
                            </p>
                        </div>
                    </a>

                    {{-- Metadata --}}
                    <div class="mt-8 space-y-2 text-center px-4">
                        <h4 class="text-xl font-black italic tracking-tighter text-foreground group-hover:text-secondary transition-colors uppercase leading-none">
                            {{ $product->name }}
                        </h4>
                        <div class="flex items-center justify-center gap-3 pt-1">
                            <span class="text-[9px] font-black text-muted-foreground uppercase tracking-[0.4em] opacity-60">
                                {{ $product->brand->name ?? 'Maison Original' }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-40 flex flex-col items-center justify-center border border-dashed border-border rounded-[4rem] bg-card/30">
                    <x-lucide-package-search class="w-12 h-12 text-muted-foreground/20 mb-6" />
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60">Archive Currently Sealed</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-32">
            {{ $products->links() }}
        </div>
    </main>
</div>