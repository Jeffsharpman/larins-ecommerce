<div class="col-span-full relative overflow-hidden flex flex-col items-center justify-center py-40 px-8 bg-white dark:bg-[#0a0a0a] border border-slate-200/60 dark:border-white/5 rounded-[4rem] transition-all duration-1000">
    
    {{-- Ambient Background Glow --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-primary/5 blur-[150px] pointer-events-none rounded-full transition-all duration-1000 group-hover:bg-primary/10"></div>

    {{-- Icon with Refined Motion --}}
    <div class="relative mb-16 group">
        <div class="absolute inset-0 bg-primary/20 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
        <div class="relative p-12 bg-[#fcfcfc] dark:bg-white/5 rounded-full border border-slate-100 dark:border-white/10 transition-all duration-700 group-hover:scale-110 group-hover:rotate-6 shadow-xl shadow-black/[0.02]">
            <x-lucide-search-x class="w-20 h-20 text-slate-300 dark:text-slate-700 stroke-[0.5] group-hover:text-primary transition-colors duration-700" />
        </div>
    </div>

    {{-- Text Content --}}
    <div class="relative z-10 text-center space-y-6 max-w-lg">
        <span class="text-[11px] font-black uppercase tracking-[0.6em] text-primary block">
            Maison {{ $site->site_name }} Archive
        </span>
        <h3 class="text-4xl md:text-6xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 leading-none">
            La Galerie est Vide
        </h3>
        <p class="text-[12px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em] leading-relaxed pt-4 px-6 opacity-80">
            No items currently match your refined criteria. We suggest adjusting your selection or exploring our full archival collection.
        </p>
    </div>

    {{-- Action Button --}}
    <div class="mt-20">
        <button onclick="window.location.href='/products'"
            class="group relative inline-flex items-center gap-x-6 px-16 py-6 text-[11px] font-black uppercase tracking-[0.4em] rounded-full bg-slate-950 dark:bg-white text-white dark:text-black hover:bg-primary dark:hover:bg-primary hover:text-white transition-all duration-700 shadow-[0_20px_50px_-10px_rgba(var(--primary-rgb),0.3)]">
            <span>Reset Collection</span>
            <x-lucide-rotate-ccw class="w-5 h-5 transition-transform duration-700 group-hover:rotate-[-360deg] stroke-[2]" />
        </button>
    </div>

    {{-- Subtle Brand Footer --}}
    <div class="mt-24 opacity-30 dark:opacity-10 flex flex-col items-center gap-4">
        <div class="h-[60px] w-[1px] bg-gradient-to-b from-transparent via-slate-400 to-transparent"></div>
        <x-lucide-sparkles class="w-8 h-8 text-slate-400 animate-pulse" />
    </div>
</div>