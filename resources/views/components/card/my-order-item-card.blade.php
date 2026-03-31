@props(['item'])

<tr wire:key="order-item-{{ $item->id }}" 
    class="group border-b border-slate-100 dark:border-white/5 transition-colors duration-700 hover:bg-slate-50/50 dark:hover:bg-white/[0.01]">
    
    {{-- Product Identity --}}
    <td class="py-8">
        <div class="flex items-center gap-8">
            {{-- Image Archive --}}
            <div class="relative h-24 w-24 bg-[#f9f9f9] dark:bg-black rounded-[1.5rem] overflow-hidden border border-slate-100 dark:border-white/10 p-3 flex-shrink-0 transition-all duration-700 group-hover:border-primary/20 group-hover:scale-105">
                <img class="h-full w-full object-contain filter grayscale-[0.4] group-hover:grayscale-0 transition-all duration-700" 
                     src="{{ url('storage', $item->product->images[0]) }}" 
                     alt="{{ $item->product->name }}">
                <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            </div>
            
            <div class="flex flex-col">
                <span class="text-[10px] font-black uppercase tracking-[0.5em] text-primary mb-2">Item Selection</span>
                <span class="text-xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors duration-500 leading-none">
                    {{ $item->product->name }}
                </span>
                <div class="flex items-center gap-3 mt-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                        Ref: {{ strtoupper(substr(md5($item->product->id), 0, 8)) }}
                    </span>
                    <span class="h-3 w-[1px] bg-slate-200 dark:bg-white/10"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                        {{ $item->product->category->name ?? 'Edition' }}
                    </span>
                </div>
            </div>
        </div>
    </td>

    {{-- Unit Valuation --}}
    <td class="py-8 px-6">
        <div class="flex flex-col">
            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Unit Valuation</span>
            <span class="text-base font-bold text-slate-700 dark:text-slate-300 tabular-nums">
                ₦{{ number_format($item->unit_amount, 2) }}
            </span>
        </div>
    </td>

    {{-- Quantity --}}
    <td class="py-8 px-6 text-center">
        <div class="inline-flex flex-col items-center">
            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Quantity</span>
            <span class="text-base font-black italic text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-white/5 px-4 py-1.5 rounded-xl border border-slate-200/50 dark:border-white/10 tabular-nums">
                {{ str_pad($item->quantity, 2, '0', STR_PAD_LEFT) }}
            </span>
        </div>
    </td>

    {{-- Total Valuation --}}
    <td class="py-8 text-right pr-4">
        <div class="flex flex-col">
            <span class="text-[10px] font-black uppercase tracking-[0.4em] text-primary/60 mb-2">Subtotal</span>
            <span class="text-2xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 tabular-nums">
                ₦{{ number_format($item->total_amount, 2) }}
            </span>
        </div>
    </td>
</tr>