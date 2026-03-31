<div
  class="col-span-full relative overflow-hidden flex flex-col items-center justify-center py-32 px-10 bg-white dark:bg-[#0a0a0a] border border-dashed border-slate-200 dark:border-white/10 rounded-[4rem] transition-all duration-1000">

  {{-- Ambient Background Glow --}}
  <div
    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-primary/5 blur-[140px] pointer-events-none transition-all duration-1000 group-hover:bg-primary/10">
  </div>

  {{-- Icon with Subtle Animation --}}
  <div class="relative mb-12 group">
    <div
      class="absolute inset-0 bg-primary/20 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000">
    </div>
    <div class="relative p-12 bg-[#fcfcfc] dark:bg-white/5 rounded-full border border-slate-100 dark:border-white/10 transition-all duration-700 group-hover:scale-110 shadow-xl shadow-black/[0.02]">
      <x-lucide-layout-grid
        class="w-16 h-16 text-slate-300 dark:text-slate-700 stroke-[0.5] transition-all duration-700 group-hover:rotate-45 group-hover:text-primary" />
    </div>
  </div>

  {{-- Content --}}
  <div class="relative z-10 text-center space-y-6 max-w-lg">
    <span class="text-[11px] font-black uppercase tracking-[0.6em] text-primary block">
      Maison {{ $site->site_name }} Archive
    </span>
    <h3 class="text-4xl md:text-5xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 leading-none uppercase">
      Cataloging in Progress
    </h3>
    <p class="text-[12px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em] leading-relaxed pt-4 px-6 opacity-80">
      Our curators are currently organizing the next collection. Please re-sync to view the updated gallery.
    </p>
  </div>

  {{-- Refresh Action --}}
  <div class="mt-16 flex flex-col items-center gap-8">
    <button wire:click="$refresh"
      class="group relative inline-flex items-center gap-x-6 px-14 py-6 text-[11px] font-black uppercase tracking-[0.4em] rounded-full bg-slate-950 dark:bg-white text-white dark:text-black hover:bg-primary dark:hover:bg-primary hover:text-white transition-all duration-700 shadow-[0_20px_50px_-10px_rgba(var(--primary-rgb),0.3)]">
      <span>Re-Sync Gallery</span>
      <x-lucide-refresh-cw wire:loading.class="animate-spin"
        class="w-5 h-5 transition-transform duration-700 group-hover:rotate-180" />
    </button>

    {{-- Sophisticated Loading State --}}
    <div wire:loading.flex class="items-center gap-6 animate-pulse">
      <span class="h-[1px] w-8 bg-primary/40"></span>
      <span class="text-[10px] font-black uppercase tracking-[0.5em] text-primary">Synchronizing Archive...</span>
      <span class="h-[1px] w-8 bg-primary/40"></span>
    </div>
  </div>

  {{-- Bottom Branding Detail --}}
  <div class="mt-20 opacity-20 dark:opacity-5">
      <x-lucide-sparkles class="w-8 h-8 text-slate-400" />
  </div>
</div>