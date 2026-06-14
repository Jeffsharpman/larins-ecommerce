<section class="relative overflow-hidden bg-background transition-colors duration-500 selection:bg-primary/20 selection:text-primary">
    {{-- High-End Ambient Background --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-gradient-to-b from-primary/5 via-primary/[0.02] to-transparent pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/10 blur-[120px] rounded-full opacity-50"></div>
    <div class="absolute -bottom-32 -left-24 w-80 h-80 bg-secondary/10 blur-[120px] rounded-full opacity-50"></div>

    <div class="max-w-7xl mx-auto px-6 pt-32 pb-20 text-center relative z-10">
        {{-- Animated Icon Badge --}}
        <div class="inline-flex items-center justify-center w-24 h-24 bg-card/50 backdrop-blur-xl border border-primary/20 dark:border-secondary/20 rounded-[2.5rem] mb-10 shadow-card animate-in fade-in zoom-in duration-1000 group hover:border-primary/50 dark:hover:border-secondary/40 transition-colors">
            <x-lucide-grid-3x3 class="w-10 h-10 text-primary group-hover:scale-110 transition-transform duration-500" />
        </div>
        
        <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter uppercase leading-[0.8] mb-8 text-foreground">
            Shop by <br/>
            <span class="text-transparent border-text opacity-40 hover:opacity-100 transition-opacity duration-700 cursor-default" style="-webkit-text-stroke: 1.5px currentColor;">Category</span>
        </h1>
        
        <p class="text-lg md:text-xl text-muted-foreground max-w-2xl mx-auto leading-relaxed font-medium italic tracking-tight">
            "Elevate your daily ritual. Discover curated collections, from professional hair care to transformative skincare."
        </p>
    </div>

    {{-- Main Category Grid --}}
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            @forelse ($categories as $index => $category)
                <div class="{{ $index % 2 == 1 ? 'md:translate-y-12' : '' }} transition-all duration-1000 ease-out">
                    <x-card.category-card :category="$category" wire:key="category-{{ $category->id }}" />
                </div>
            @empty
                <x-card.empty-category-card-state />
            @endforelse
        </div>

        {{-- Luxury Stats Bar --}}
        <div class="mt-40 grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-px bg-border border border-border rounded-[3rem] overflow-hidden shadow-card backdrop-blur-md">
            @php
                $stats = [
                    ['label' => 'Curated Categories', 'value' => '5+', 'icon' => 'grid'],
                    ['label' => 'Premium Products', 'value' => '100+', 'icon' => 'package'],
                    ['label' => 'Global Shipping', 'value' => 'Verified', 'icon' => 'globe'],
                    ['label' => 'Curator Rating', 'value' => '★5.0', 'icon' => 'star'],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="bg-card p-10 text-center hover:bg-muted/50 dark:hover:bg-secondary/[0.02] transition-colors group">
                    <div class="text-4xl font-black italic tracking-tighter text-primary dark:text-secondary mb-2 font-heading group-hover:scale-110 transition-transform duration-500">
                        {{ $stat['value'] }}
                    </div>
                    <div class="text-[9px] uppercase tracking-[0.4em] text-muted-foreground font-black">
                        {{ $stat['label'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Feature Highlights --}}
    <div class="bg-card/30 backdrop-blur-sm border-y border-border py-32">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16">

                {{-- Feature 1 --}}
                <div class="flex flex-col items-center text-center group">
                    <div class="w-24 h-24 mb-10 flex items-center justify-center rounded-[2.2rem] border border-primary/10 dark:border-secondary/20 bg-primary/5 dark:bg-secondary/[0.03] shadow-xl group-hover:border-primary/40 dark:group-hover:border-secondary/40 group-hover:-translate-y-3 transition-all duration-700 relative overflow-hidden">
                        <x-lucide-search class="w-10 h-10 text-primary dark:text-secondary" />
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 dark:from-secondary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <h3 class="text-2xl font-black italic tracking-tighter uppercase mb-4 text-foreground">
                        Intuitive Discovery
                    </h3>
                    <p class="text-[10px] text-muted-foreground font-bold leading-relaxed max-w-xs uppercase tracking-[0.2em]">
                        Find beauty essentials effortlessly with refined navigation.
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="flex flex-col items-center text-center group">
                    <div class="w-24 h-24 mb-10 flex items-center justify-center rounded-[2.2rem] border border-primary/10 dark:border-secondary/20 bg-primary/5 dark:bg-secondary/[0.03] shadow-xl group-hover:border-primary/40 dark:group-hover:border-secondary/40 group-hover:-translate-y-3 transition-all duration-700 relative overflow-hidden">
                        <x-lucide-star class="w-10 h-10 text-primary dark:text-secondary" />
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 dark:from-secondary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <h3 class="text-2xl font-black italic tracking-tighter uppercase mb-4 text-foreground">
                        Vetted Selection
                    </h3>
                    <p class="text-[10px] text-muted-foreground font-bold leading-relaxed max-w-xs uppercase tracking-[0.2em]">
                        Every product curated for professional performance.
                    </p>
                </div>
                
                {{-- Feature 3 --}}
                <div class="flex flex-col items-center text-center group">
                    <div class="w-24 h-24 mb-10 flex items-center justify-center rounded-[2.2rem] border border-primary/10 dark:border-secondary/20 bg-primary/5 dark:bg-secondary/[0.03] shadow-xl group-hover:border-primary/40 dark:group-hover:border-secondary/40 group-hover:-translate-y-3 transition-all duration-700 relative overflow-hidden">
                        <x-lucide-heart class="w-10 h-10 text-primary dark:text-secondary" />
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 dark:from-secondary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <h3 class="text-2xl font-black italic tracking-tighter uppercase mb-4 text-foreground">
                        Personalized Care
                    </h3>
                    <p class="text-[10px] text-muted-foreground font-bold leading-relaxed max-w-xs uppercase tracking-[0.2em]">
                        Tailored recommendations for your unique skin profile.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>