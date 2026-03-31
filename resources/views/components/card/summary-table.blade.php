@props(['order'])

<div {{ $attributes->merge(['class' => 'space-y-16']) }}>
    {{-- Items Manifest --}}
    <div class="space-y-8">
        <div class="flex items-center justify-between border-b-2 border-slate-100 dark:border-white/5 pb-6">
            <h4 class="text-[11px] font-black uppercase tracking-[0.5em] text-primary">
                Selected Acquisitions
            </h4>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 opacity-60">
                {{ str_pad($order->items->count(), 2, '0', STR_PAD_LEFT) }} Entries
            </span>
        </div>
        
        <div class="divide-y divide-slate-100 dark:divide-white/5">
            @foreach($order->items as $item)
                <div class="py-8 flex justify-between items-center group">
                    <div class="flex gap-8 items-center">
                        {{-- Product Preview --}}
                        <div class="relative w-20 h-20 rounded-[1.5rem] bg-[#f9f9f9] dark:bg-black overflow-hidden border border-slate-100 dark:border-white/10 p-3 flex-shrink-0 transition-all duration-700 group-hover:border-primary/30 group-hover:scale-105">
                            @if(isset($item->product->images[0]))
                                <img src="{{ asset('storage/' . $item->product->images[0]) }}" 
                                     class="w-full h-full object-contain filter grayscale-[0.4] group-hover:grayscale-0 transition-all duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50 dark:bg-white/5">
                                    <x-lucide-package class="w-6 h-6 text-slate-300" />
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        
                        <div>
                            <p class="text-xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 leading-none group-hover:text-primary transition-colors duration-500">
                                {{ $item->product->name ?? 'Edition Item' }}
                            </p>
                            <div class="flex items-center gap-3 mt-3">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                                    {{ str_pad($item->quantity, 2, '0', STR_PAD_LEFT) }} Units
                                </p>
                                <span class="h-[1px] w-4 bg-slate-200 dark:bg-white/10"></span>
                                <p class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">
                                    ₦{{ number_format($item->unit_amount, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <span class="text-2xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100">
                        ₦{{ number_format($item->total_amount, 2) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Financial Summary Card --}}
    <div class="relative overflow-hidden bg-[#fcfcfc] dark:bg-white/[0.01] rounded-[3rem] p-12 border border-slate-100 dark:border-white/5 shadow-2xl shadow-primary/5">
        {{-- Ambient Branding Glow --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-primary/5 blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-primary/5 blur-[100px] pointer-events-none"></div>
        
        <div class="relative z-10 space-y-6">
            <div class="flex justify-between items-center">
                <span class="text-[11px] font-black uppercase tracking-[0.4em] text-slate-400">Subtotal</span>
                <span class="text-lg font-bold text-slate-900 dark:text-slate-100 tabular-nums">₦{{ number_format($order->grand_total, 2) }}</span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-[11px] font-black uppercase tracking-[0.4em] text-slate-400">Logistics</span>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary border border-primary/20 px-4 py-2 rounded-full backdrop-blur-md">Complimentary</span>
            </div>

            <div class="pt-10 mt-6 border-t border-slate-200 dark:border-white/10 flex flex-col sm:flex-row justify-between items-center sm:items-end gap-6">
                <div class="text-center sm:text-left">
                    <p class="text-[11px] font-black uppercase tracking-[0.5em] text-primary">Total Valuation</p>
                    <p class="text-[10px] text-slate-400 mt-3 font-bold uppercase tracking-widest italic opacity-60">
                        Settled via {{ str($order->payment_method)->replace('_', ' ')->upper() }}
                    </p>
                </div>
                <span class="text-5xl md:text-6xl font-black italic text-slate-900 dark:text-slate-100 tracking-tighter leading-none">
                    ₦{{ number_format($order->grand_total, 2) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 pt-12 border-t-2 border-slate-100 dark:border-white/5">
        {{-- Delivery --}}
        <div class="space-y-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                    <x-lucide-map-pin class="w-5 h-5 text-primary" />
                </div>
                <p class="text-[11px] font-black uppercase tracking-[0.4em] text-slate-900 dark:text-slate-100">Acquisition Destination</p>
            </div>
            
            <div class="pl-14">
                <address class="not-italic space-y-3">
                    <span class="text-xl font-black italic tracking-tighter text-slate-900 dark:text-slate-100 block">
                        {{ $order->address->first_name ?? $order->first_name }} {{ $order->address->last_name ?? $order->last_name }}
                    </span>
                    <span class="text-[12px] font-bold text-slate-400 uppercase tracking-[0.2em] block leading-relaxed max-w-xs">
                        {{ $order->address->street_address ?? $order->street_address }}<br>
                        {{ $order->address->city ?? $order->city }}, {{ $order->address->state ?? $order->state }} {{ $order->address->zip_code ?? $order->zip_code }}
                    </span>
                </address>
            </div>
        </div>

        {{-- Metadata Archive --}}
        <div class="space-y-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/5 flex items-center justify-center">
                    <x-lucide-fingerprint class="w-5 h-5 text-slate-400" />
                </div>
                <p class="text-[11px] font-black uppercase tracking-[0.4em] text-slate-900 dark:text-slate-100">Archive Metadata</p>
            </div>
            
            <div class="pl-14 space-y-5">
                <div class="flex items-center justify-between max-w-xs">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Reference</span>
                    <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">
                        #{{ strtoupper(substr($order->id, 0, 8)) }}
                    </span>
                </div>
                <div class="flex items-center justify-between max-w-xs">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Timestamp</span>
                    <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">
                        {{ \Carbon\Carbon::parse($order->created_at)->format('d.m.y • H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>