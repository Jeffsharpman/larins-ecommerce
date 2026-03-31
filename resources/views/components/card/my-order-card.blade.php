@props(['order'])

<tr wire:key="order-{{ $order->id }}" 
    class="group border-b border-slate-100 dark:border-white/5 hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors duration-500">
    
    {{-- Order Identifier --}}
    <td class="px-8 py-7 whitespace-nowrap">
        <div class="flex flex-col">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-primary mb-1.5">Reference</span>
            <span class="text-sm font-black italic tracking-tighter text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors duration-500">
                #{{ $order->order_number }}
            </span>
        </div>
    </td>

    {{-- Date of Acquisition --}}
    <td class="px-8 py-7 whitespace-nowrap">
        <div class="flex flex-col">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-400 mb-1.5">Acquired</span>
            <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest tabular-nums">
                {{ $order->created_at->format('M d, Y') }}
            </span>
        </div>
    </td>

    {{-- Order Status --}}
    <td class="px-8 py-7 whitespace-nowrap">
        <div class="flex items-center gap-2.5">
            @php
                $statusColor = match($order->status) {
                    'shipped', 'delivered' => 'bg-emerald-500',
                    'cancelled', 'failed' => 'bg-red-500',
                    default => 'bg-primary',
                };
            @endphp
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $statusColor }} opacity-20"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 {{ $statusColor }}"></span>
            </span>
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-700 dark:text-slate-300">
                {{ $order->status }}
            </span>
        </div>
    </td>

    {{-- Payment Status --}}
    <td class="px-8 py-7 whitespace-nowrap">
        <span class="text-[9px] font-black uppercase tracking-[0.3em] px-4 py-1.5 rounded-full border {{ $order->payment_status === 'paid' ? 'border-emerald-500/20 text-emerald-600 bg-emerald-50/50 dark:bg-emerald-500/10' : 'border-slate-200 dark:border-white/10 text-slate-400' }}">
            {{ $order->payment_status }}
        </span>
    </td>

    {{-- Valuation (NGN) --}}
    <td class="px-8 py-7 whitespace-nowrap">
        <div class="flex flex-col">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-400 mb-1.5">Valuation</span>
            <span class="text-lg font-black italic tracking-tighter text-slate-900 dark:text-slate-100 tabular-nums">
                ₦{{ number_format($order->grand_total, 2) }}
            </span>
        </div>
    </td>

    {{-- Action --}}
    <td class="px-8 py-7 whitespace-nowrap text-end">
        <a wire:navigate href="/my-orders/{{ $order->id }}"
           class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.4em] text-slate-400 hover:text-primary transition-all duration-500 group/link">
            <span class="border-b border-transparent group-hover:border-primary pb-0.5">Details</span>
            <x-lucide-arrow-right class="w-4 h-4 transition-transform group-hover/link:translate-x-2 text-primary" />
        </a>
    </td>
</tr>