@props(['item'])

<li class="py-6 border-b border-border dark:border-border last:border-0 group"
  wire:key="summary-{{ $item['product_id'] }}">
  <div class="flex items-center gap-6">

    {{-- Circular Miniature Frame --}}
    <div
      class="relative flex-shrink-0 w-16 h-16 bg-muted dark:bg-black rounded-full overflow-hidden border border-border dark:border-border p-2.5 transition-all duration-700 group-hover:scale-110 group-hover:border-primary/30">
      <img src="{{ url('storage', $item['image']) }}" alt="{{ $item['name'] }}"
        class="w-full h-full object-contain filter grayscale-[0.5] group-hover:grayscale-0 transition-all duration-700">
      <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
    </div>

    {{-- Product Identity --}}
    <div class="flex-1 min-w-0">
      <h4
        class="text-sm font-black italic tracking-tighter text-foreground truncate group-hover:text-primary transition-colors duration-500 uppercase leading-none">
        {{ $item['name'] }}
      </h4>

      <div class="flex items-center gap-3 mt-2.5">
        <span class="text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground">
          Units: {{ str_pad($item['quantity'], 2, '0', STR_PAD_LEFT) }}
        </span>
        <span class="h-1 w-1 rounded-full bg-border"></span>
        <span class="text-[9px] font-black uppercase tracking-[0.4em] text-primary/80">
          {{ $item['variant'] ?? 'Original Edition' }}
        </span>
      </div>
    </div>

    {{-- Valuation --}}
    <div class="text-right">
      <span class="block text-base font-black italic tracking-tighter text-foreground tabular-nums">
        ₦{{ number_format($item['total_amount'], 2) }}
      </span>
      <span
        class="text-[8px] font-black uppercase tracking-[0.5em] text-primary opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-700 block mt-1">
        Verified
      </span>
    </div>
  </div>
</li>
