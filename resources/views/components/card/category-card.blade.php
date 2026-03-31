@props(['category'])

<a wire:navigate href="{{ route('categories.show', $category->slug) }}"
   class="group relative block bg-white dark:bg-[#0d0d0d] border border-slate-200 dark:border-white/5 p-8 md:p-10 rounded-[3rem] overflow-hidden transition-all duration-700 ease-expo hover:border-primary/40 hover:-translate-y-3 shadow-sm hover:shadow-[0_40px_80px_-20px_rgba(var(--primary-rgb),0.1)]"
   wire:key="category-{{ $category->id }}">

    {{-- Large Ghost Initial Background: Watermark Style --}}
    <div class="absolute -right-6 -bottom-12 opacity-[0.04] dark:opacity-[0.08] transition-all duration-1000 group-hover:scale-110 group-hover:-rotate-6 pointer-events-none">
        <h2 class="text-[15rem] font-black italic leading-none select-none uppercase tracking-tighter">
            {{ substr($category->name, 0, 1) }}
        </h2>
    </div>

    <div class="relative flex items-center z-10">
        {{-- Circular Image Frame with Ambient Glow --}}
        <div class="relative flex-shrink-0 w-28 h-28 md:w-44 md:h-44 rounded-full overflow-hidden border border-slate-100 dark:border-white/5 shadow-2xl transition-all duration-700 group-hover:shadow-primary/20">
            <img class="h-full w-full object-cover transform scale-110 group-hover:scale-125 transition-transform duration-1000 ease-expo grayscale-[0.4] group-hover:grayscale-0"
                 src="{{ url('storage', $category->image) }}" 
                 alt="{{ $category->name }}">
            
            {{-- Internal Highlight --}}
            <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
        </div>

        <div class="ms-10 flex-1 min-w-0">
            {{-- Staggered Animation for Label --}}
            <span class="text-[10px] font-black uppercase tracking-[0.6em] text-primary mb-3 block opacity-0 -translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 delay-75">
                Department
            </span>
            
            <h3 class="text-4xl md:text-5xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors duration-500 truncate">
                {{ $category->name }}
            </h3>
            
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 mt-3 uppercase tracking-[0.2em] line-clamp-1 opacity-70 group-hover:opacity-100 transition-opacity duration-500">
                Curated {{ $category->name }} Essentials
            </p>

            {{-- Elegant "Enter" Trigger with Sliding Motion --}}
            <div class="mt-8 flex items-center text-slate-900 dark:text-slate-100 text-[11px] font-black uppercase tracking-[0.4em] transition-all duration-700 delay-100 translate-x-[-20px] opacity-0 group-hover:translate-x-0 group-hover:opacity-100">
                <span class="relative group-hover:text-primary transition-colors duration-300">
                    Enter Gallery
                    <span class="absolute bottom-0 left-0 w-full h-[1.5px] bg-primary scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></span>
                </span>
                <x-lucide-arrow-right class="ms-4 w-5 h-5 text-primary transition-transform group-hover:translate-x-3 duration-500" />
            </div>
        </div>
    </div>
</a>