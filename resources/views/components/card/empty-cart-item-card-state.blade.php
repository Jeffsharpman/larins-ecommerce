<tr>
  <td colspan="5" class="py-32">
    <div class="flex flex-col items-center justify-center relative overflow-hidden group/main">

      {{-- Ambient Background Glow --}}
      <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-primary/5 blur-[120px] pointer-events-none transition-all duration-1000 group-hover/main:bg-primary/10">
      </div>

      {{-- Iconography --}}
      <div class="relative group mb-10">
        <div
          class="absolute inset-0 bg-primary/20 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000">
        </div>
        <div
          class="relative p-12 bg-muted dark:bg-muted rounded-full border border-border dark:border-border transition-all duration-700 group-hover:scale-110 group-hover:border-primary/20 shadow-xl shadow-primary/5">
          <x-lucide-shopping-bag class="w-16 h-16 text-muted-foreground stroke-[0.5] group-hover:text-primary transition-colors duration-700" />
        </div>
      </div>

      {{-- Content --}}
      <div class="text-center space-y-4 max-w-sm px-8 relative z-10">
        <span class="text-[10px] font-black uppercase tracking-[0.5em] text-primary block">
          Your Selection
        </span>
        <h3 class="text-4xl font-black italic tracking-tighter text-foreground leading-none">
          Le Panier est Vide
        </h3>
        <p
          class="text-[11px] font-bold text-muted-foreground uppercase tracking-[0.25em] leading-relaxed pt-3 opacity-80">
          Your curated collection is currently waiting for its first acquisition.
        </p>
      </div>

      {{-- Action Button --}}
      <div class="mt-14">
        <a href="/products" wire:navigate class="btn btn-dark btn-xl group">
          <span>Enter the Gallery</span>
          <x-lucide-arrow-right class="w-5 h-5 transition-transform duration-500 group-hover:translate-x-2" />
        </a>
      </div>

      {{-- Sophisticated Bottom Detail --}}
      <div class="mt-16 flex items-center gap-4 opacity-30 dark:opacity-10">
        <span class="h-[1px] w-12 bg-gradient-to-r from-transparent to-muted-foreground"></span>
        <span class="text-[9px] font-black uppercase tracking-[0.6em] text-muted-foreground"> Maison {{ $site->site_name }}</span>
        <span class="h-[1px] w-12 bg-gradient-to-l from-transparent to-muted-foreground"></span>
      </div>
    </div>
  </td>
</tr>
