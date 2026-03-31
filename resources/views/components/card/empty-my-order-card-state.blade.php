<tr>
  <td colspan="6" class="px-8 py-32 text-center">
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
          class="relative p-12 bg-[#fcfcfc] dark:bg-white/5 rounded-full border border-slate-100 dark:border-white/10 transition-all duration-700 group-hover:scale-110 group-hover:border-primary/20 shadow-xl shadow-black/[0.02]">
          <x-lucide-scroll class="w-16 h-16 text-slate-300 dark:text-slate-700 stroke-[0.5] group-hover:text-primary transition-colors duration-700" />
        </div>
      </div>

      {{-- Content --}}
      <div class="relative z-10 space-y-4 max-w-sm">
        <span class="text-[10px] font-black uppercase tracking-[0.5em] text-primary block">
          Personal Archive Ledger
        </span>
        <h3 class="text-4xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 leading-none">
          Historique Vide
        </h3>
        <p
          class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em] leading-relaxed pt-3 px-4">
          Your personal acquisition history is currently empty. Begin your collection today.
        </p>
      </div>

      {{-- Action Button --}}
      <div class="mt-14">
        <a href="/products" wire:navigate
          class="group relative inline-flex items-center gap-x-6 px-14 py-6 text-[10px] font-black uppercase tracking-[0.4em] rounded-full bg-slate-950 dark:bg-white text-white dark:text-black hover:bg-primary dark:hover:bg-primary hover:text-white transition-all duration-700 shadow-[0_20px_50px_-10px_rgba(var(--primary-rgb),0.3)]">
          <span>Explore Collection</span>
          <x-lucide-arrow-right class="w-5 h-5 transition-all duration-500 group-hover:translate-x-3 text-primary group-hover:text-white" />
        </a>
      </div>

      {{-- Bottom Decorative Sparkle --}}
      <div class="mt-16 opacity-20 dark:opacity-5">
          <x-lucide-sparkles class="w-6 h-6 text-slate-400 animate-pulse" />
      </div>

    </div>
  </td>
</tr>