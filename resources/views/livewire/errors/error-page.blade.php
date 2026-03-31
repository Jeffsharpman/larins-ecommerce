<div class="min-h-[80vh] flex items-center justify-center px-6 py-24 text-center relative overflow-hidden bg-background">
    {{-- Dynamic Background 404 --}}
    <div class="absolute inset-0 flex items-center justify-center -z-10 select-none pointer-events-none overflow-hidden">
        <h2 class="text-[18rem] md:text-[35rem] font-black uppercase tracking-tighter text-primary/5 dark:text-primary/10 opacity-30 animate-in fade-in zoom-in duration-1000">
            404
        </h2>
    </div>

    <div class="max-w-2xl relative z-10">
        {{-- Animated Icon --}}
        <div class="mb-12 inline-flex items-center justify-center w-24 h-24 bg-muted/30 backdrop-blur-xl rounded-full border border-border/50 shadow-2xl shadow-primary/5">
            <x-lucide-compass class="w-10 h-10 text-primary animate-[spin_8s_linear_infinite]" />
        </div>

        {{-- Content --}}
        <div class="space-y-6 mb-12">
            <h1 class="text-6xl md:text-8xl font-black tracking-tighter uppercase italic leading-[0.8] text-foreground">
                Lost in <span class="text-primary">Style</span>
            </h1>
            <div class="h-[2px] w-20 bg-primary mx-auto"></div>
            <p class="text-[11px] md:text-xs font-black uppercase tracking-[0.5em] text-muted-foreground max-w-md mx-auto leading-loose opacity-80">
                The collection or page you are seeking has moved to a private suite or no longer exists.
            </p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-8 mb-20">
            <a wire:navigate href="/" class="group relative flex items-center gap-4 px-12 py-5 bg-foreground text-background text-[11px] font-black uppercase tracking-[0.4em] rounded-full hover:bg-primary hover:text-primary-foreground transition-all duration-500 overflow-hidden">
                <x-lucide-arrow-left class="w-4 h-4 group-hover:-translate-x-2 transition-transform duration-500" />
                Return Home
                {{-- Button Shine Effect --}}
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </a>
            
            <a wire:navigate href="/products" class="group flex items-center gap-2 text-[11px] font-black uppercase tracking-[0.4em] text-muted-foreground hover:text-primary transition-all">
                Browse Collection
                <x-lucide-chevron-right class="w-4 h-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" />
            </a>
        </div>

        {{-- Search Section --}}
        <div class="pt-16 border-t border-border/40">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 mb-8 italic">
                Perhaps a search will guide you back
            </p>
            <form action="/products" method="GET" class="max-w-md mx-auto relative group">
                <input type="search" name="search" placeholder="SEARCH PIECES, PRODUCTS, OR PAGES..."
                    class="w-full bg-transparent border-0 border-b-2 border-border/60 focus:border-primary focus:ring-0 px-0 py-5 text-[12px] font-bold tracking-[0.2em] transition-all placeholder:text-muted-foreground/20 text-center uppercase text-foreground" />
                
                <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 p-2 text-muted-foreground hover:text-primary hover:scale-110 transition-all">
                    <x-lucide-search class="w-5 h-5 stroke-[2.5]" />
                </button>
            </form>
        </div>
    </div>
</div>