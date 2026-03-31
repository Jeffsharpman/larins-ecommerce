@props(['brand'])

<a wire:navigate href="{{ route('brands.show', $brand->slug) }}" 
   class="group relative block bg-white dark:bg-[#0d0d0d] border border-slate-200 dark:border-white/5 rounded-[2.5rem] overflow-hidden transition-all duration-700 hover:border-primary/50 hover:-translate-y-4 shadow-sm hover:shadow-[0_30px_60px_-15px_rgba(var(--primary-rgb),0.15)]"
   wire:key="brand-{{ $brand->id }}">
    
    {{-- Top Section: Brand Showcase --}}
    <div class="aspect-[4/3] w-full relative flex items-center justify-center p-14 bg-[#f9f9f9] dark:bg-black transition-colors duration-500 overflow-hidden">
        
        {{-- Subtle background watermark --}}
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] dark:opacity-[0.06] pointer-events-none group-hover:scale-125 transition-transform duration-[3s] ease-expo">
             <h2 class="text-[12rem] font-black italic tracking-tighter">{{ substr($brand->name, 0, 1) }}</h2>
        </div>

        {{-- Brand Logo --}}
        <div class="relative z-10 w-full h-full flex items-center justify-center transition-all duration-700 ease-expo group-hover:scale-110">
            <img src="{{ url('storage', $brand->image) }}" 
                 alt="{{ $brand->name }}" 
                 class="max-w-[140px] max-h-full object-contain filter grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700 drop-shadow-xl">
        </div>
        
        {{-- Exclusive Badge --}}
        <div class="absolute top-8 right-8">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-primary border border-primary/20 px-4 py-2 rounded-full backdrop-blur-md bg-white/10">
                Maison
            </span>
        </div>
    </div>

    {{-- Bottom Section: Details --}}
    <div class="p-10 bg-white dark:bg-[#0d0d0d] relative">
        <div class="flex justify-between items-center">
            <div class="space-y-2">
                <h3 class="text-3xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors duration-500">
                    {{ $brand->name }}
                </h3>
                
                <div class="flex items-center gap-4">
                    <span class="h-[1.5px] w-6 bg-primary transform origin-left group-hover:scale-x-150 transition-transform duration-500"></span>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-[0.3em]">
                        {{ $brand->products_count ?? '0' }} Editions
                    </p>
                </div>
            </div>
            
            {{-- Circular Link Button --}}
            <div class="w-14 h-14 rounded-full border border-slate-200 dark:border-white/10 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:border-primary group-hover:text-primary-foreground transition-all duration-700 transform group-hover:rotate-[-45deg] shadow-lg group-hover:shadow-primary/20">
                <x-lucide-arrow-right class="w-6 h-6 stroke-[2.5]" />
            </div>
        </div>
    </div>

    {{-- Corner Glow (Luxury Detail) --}}
    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-primary/10 blur-[50px] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
</a>