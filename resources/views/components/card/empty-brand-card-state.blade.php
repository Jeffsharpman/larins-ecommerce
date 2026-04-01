<div
    class="col-span-full relative overflow-hidden flex flex-col items-center justify-center py-32 px-10 text-center bg-card dark:bg-card border border-border dark:border-border rounded-[4rem] transition-all duration-1000">

    {{-- Ambient Background Glow --}}
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-primary/5 blur-[150px] pointer-events-none transition-all duration-1000 group-hover:bg-primary/10">
    </div>

    {{-- Icon with Premium Accent --}}
    <div class="relative group mb-12">
        <div
            class="absolute inset-0 bg-primary/20 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000">
        </div>
        <div
            class="relative p-12 bg-muted dark:bg-muted rounded-full border border-border dark:border-border transition-all duration-700 group-hover:scale-110 shadow-xl shadow-primary/5">
            <x-lucide-layers-2 class="w-16 h-16 text-muted-foreground stroke-[0.5] group-hover:text-primary transition-colors duration-700" />
        </div>
    </div>

    {{-- Text Content --}}
    <div class="relative z-10 max-w-lg space-y-6">
        <span class="text-[11px] font-black uppercase tracking-[0.6em] text-primary block">
            Maison {{ $site->site_name }} Partners
        </span>
        <h2 class="text-4xl md:text-6xl font-black italic tracking-tighter text-foreground leading-none uppercase">
            Curation in Progress
        </h2>
        <p class="text-[12px] font-bold text-muted-foreground uppercase tracking-[0.25em] leading-relaxed pt-4 px-6 opacity-80">
            We are currently refining our selection of elite partners. Please return shortly for the next unveiling of our
            exclusive archival collection.
        </p>
    </div>

    {{-- Action Button --}}
    <div class="mt-16">
        <a wire:navigate href="/"
            class="group relative inline-flex items-center gap-x-6 px-14 py-6 text-[11px] font-black uppercase tracking-[0.4em] rounded-full bg-foreground dark:bg-background text-card dark:text-foreground hover:bg-primary dark:hover:bg-primary hover:text-white transition-all duration-700 shadow-[0_20px_50px_-10px_rgba(var(--primary-rgb),0.3)]">
            <span>Explore Home</span>
            <x-lucide-arrow-right class="w-5 h-5 transition-transform duration-500 group-hover:translate-x-3 text-primary group-hover:text-white" />
        </a>
    </div>

    {{-- Sophisticated Brand Detail --}}
    <div class="mt-20 flex flex-col items-center gap-4 opacity-30 dark:opacity-5">
        <div class="h-[60px] w-[1px] bg-gradient-to-b from-transparent via-muted-foreground to-transparent"></div>
        <x-lucide-sparkles class="w-8 h-8 text-muted-foreground animate-pulse" />
    </div>
</div>
