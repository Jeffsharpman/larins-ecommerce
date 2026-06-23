@props(['brand'])

<a wire:navigate href="{{ route('brands.show', $brand->slug) }}" 
   class="group relative block bg-card dark:bg-card border border-border dark:border-border rounded-[2.5rem] overflow-hidden transition-all duration-700 hover:border-primary/50 hover:border-secondary/30 hover:-translate-y-4 shadow-sm hover:shadow-[0_30px_60px_-15px_rgba(var(--primary-rgb),0.15)] hover:shadow-secondary/5"
   wire:key="brand-{{ $brand->id }}">
    
    {{-- Top Section: Brand Showcase --}}
    <div class="aspect-[4/3] w-full relative flex items-center justify-center p-14 bg-muted dark:bg-black transition-colors duration-500 overflow-hidden">
        
        {{-- Subtle background watermark --}}
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] dark:opacity-[0.06] pointer-events-none group-hover:scale-125 transition-transform duration-[3s] ease-expo">
             <h2 class="text-[12rem] font-black italic tracking-tighter">{{ substr($brand->name, 0, 1) }}</h2>
        </div>

        {{-- Brand Logo --}}
        <div class="relative z-10 w-full h-full flex items-center justify-center transition-all duration-700 ease-expo group-hover:scale-110">
            <img src="{{ $brand->image }}" 
                 alt="{{ $brand->name }}" 
                 class="max-w-[140px] max-h-full object-contain filter grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700 drop-shadow-xl">
        </div>
        
        {{-- Exclusive Badge --}}
        <div class="absolute top-8 right-8">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-foreground/80 dark:text-white/90 border border-foreground/10 dark:border-white/20 px-4 py-2 rounded-full backdrop-blur-xl bg-background/70 dark:bg-white/10 shadow-sm shadow-foreground/5 dark:shadow-black/20 group-hover:border-primary/40 group-hover:bg-primary/10 group-hover:text-primary dark:group-hover:text-primary transition-all duration-500">
                <x-lucide-sparkles class="w-3 h-3 inline -mt-0.5 mr-1.5" />
                Maison
            </span>
        </div>
    </div>

    {{-- Bottom Section: Details --}}
    <div class="p-10 bg-card dark:bg-card relative">
        <div class="flex justify-between items-center">
            <div class="space-y-2">
                <h3 class="text-3xl font-black italic tracking-tighter text-foreground group-hover:text-primary transition-colors duration-500">
                    {{ $brand->name }}
                </h3>
                
                <div class="flex items-center gap-4">
                    <span class="h-[1.5px] w-6 bg-primary transform origin-left group-hover:scale-x-150 transition-transform duration-500"></span>
                    <span class="h-[1.5px] w-4 bg-secondary/40 transform origin-left group-hover:scale-x-125 transition-transform duration-500"></span>
                    <p class="text-[10px] text-muted-foreground font-black uppercase tracking-[0.3em]">
                        {{ $brand->products_count ?? '0' }} Editions
                    </p>
                </div>
            </div>
            
            {{-- Circular Link Button --}}
            <div class="w-14 h-14 rounded-full border-2 border-foreground/15 dark:border-white/20 flex items-center justify-center text-foreground/70 dark:text-white/80 bg-background/50 dark:bg-white/5 group-hover:bg-primary group-hover:border-primary group-hover:text-white transition-all duration-700 transform group-hover:rotate-[-45deg] group-hover:scale-110 shadow-lg shadow-foreground/5 dark:shadow-black/20 group-hover:shadow-primary/25 group-hover:shadow-xl overflow-hidden relative">
                <span class="absolute inset-0 bg-primary scale-0 group-hover:scale-100 transition-transform duration-700 ease-expo rounded-full"></span>
                <x-lucide-arrow-right class="relative z-10 w-6 h-6 stroke-[2.5] transition-transform duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
            </div>
        </div>
    </div>

    {{-- Corner Glow (Luxury Detail) --}}
    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-primary/10 blur-[50px] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
    <div class="absolute -top-10 -left-10 w-40 h-40 bg-secondary/5 blur-[60px] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
</a>
