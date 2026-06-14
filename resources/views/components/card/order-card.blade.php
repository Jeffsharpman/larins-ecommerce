@props(['order'])

@php
    $statusMap = match ($order->status) {
        'delivered' => ['color' => 'text-emerald-500', 'bg' => 'bg-emerald-500/10', 'icon' => 'check-circle'],
        'shipped' => ['color' => 'text-blue-500', 'bg' => 'bg-blue-500/10', 'icon' => 'truck'],
        'processing', 'paid' => ['color' => 'text-primary', 'bg' => 'bg-primary/10', 'icon' => 'clock'],
        'cancelled', 'failed' => ['color' => 'text-red-500', 'bg' => 'bg-red-500/10', 'icon' => 'x-circle'],
        default => ['color' => 'text-muted-foreground', 'bg' => 'bg-muted dark:bg-muted', 'icon' => 'package'],
    };

    $orderDate = \Carbon\Carbon::parse($order->created_at);
@endphp

<div wire:key="order-card-{{ $order->id }}"
    class="group relative bg-card dark:bg-card border border-border dark:border-border rounded-[3rem] shadow-sm hover:shadow-[0_40px_80px_-20px_rgba(var(--primary-rgb),0.1)] hover:shadow-secondary/5 hover:border-secondary/30 transition-all duration-700 overflow-hidden mb-10">

    {{-- Secondary Ambient Glow --}}
    <div class="absolute -top-10 -right-10 w-48 h-48 bg-secondary/5 blur-[100px] rounded-full pointer-events-none z-0"></div>

    {{-- Main Header Section --}}
    <div class="p-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
        <div class="flex items-start gap-6">
            {{-- Visual Status Indicator --}}
            <div class="relative flex-shrink-0 w-20 h-20 {{ $statusMap['bg'] }} rounded-[2rem] flex items-center justify-center transition-all duration-700 group-hover:scale-110 group-hover:rotate-3">
                <x-dynamic-component :component="'lucide-' . $statusMap['icon']" class="w-9 h-9 {{ $statusMap['color'] }} stroke-[1.5]" />
                <div class="absolute -top-1 -right-1 w-5 h-5 rounded-full border-4 border-card dark:border-card {{ str_replace('text-', 'bg-', $statusMap['color']) }} animate-pulse"></div>
            </div>

            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black uppercase tracking-[0.5em] text-primary">
                        Acquisition
                    </span>
                    <span class="h-[1px] w-6 bg-border"></span>
                    <span class="h-[1px] w-3 bg-secondary/40"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">
                        #{{ $order->order_number ?? $order->id }}
                    </span>
                </div>
                
                <h3 class="text-3xl font-black italic tracking-tighter text-foreground uppercase leading-none">
                    {{ $order->status }}
                </h3>

                <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-[0.2em] flex items-center gap-2.5">
                    <x-lucide-calendar class="w-4 h-4 text-muted-foreground" />
                    Archive Date: {{ $orderDate->format('d M, Y') }}
                </p>
            </div>
        </div>

        {{-- Valuation --}}
        <div class="text-left lg:text-right border-t lg:border-t-0 border-border pt-8 lg:pt-0">
            <span class="text-[10px] text-muted-foreground uppercase font-black tracking-[0.4em] block mb-2">Total Valuation</span>
            <div class="text-4xl font-black italic tracking-tighter text-foreground leading-none">
                ₦{{ number_format($order->grand_total ?? $order->total, 2) }}
            </div>
            <div class="flex items-center lg:justify-end gap-2 mt-3">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span class="text-[9px] font-black text-emerald-600 dark:text-emerald-500 uppercase tracking-[0.3em]">
                    {{ $order->items->count() }} Premium Item{{ $order->items->count() !== 1 ? 's' : '' }} Securely Logged
                </span>
            </div>
        </div>
    </div>

    {{-- Items Preview Manifest --}}
    <div class="px-10 pb-6">
        <div class="bg-muted dark:bg-muted rounded-[2.5rem] border border-border dark:border-border overflow-hidden transition-all duration-500 hover:border-primary/20 hover:border-secondary/20">
            <details class="group/details">
                <summary class="list-none cursor-pointer px-10 py-6 text-[10px] font-black uppercase tracking-[0.5em] text-muted-foreground hover:text-primary transition-colors flex items-center justify-between">
                    <span class="flex items-center gap-3">
                        <x-lucide-clipboard-list class="w-4 h-4 opacity-50" />
                        Review Manifest Content
                    </span>
                    <x-lucide-chevron-down class="w-5 h-5 group-open/details:rotate-180 transition-transform duration-500 ease-expo text-primary" />
                </summary>

                <div class="px-10 pb-10 space-y-6">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between py-5 border-t border-border dark:border-border first:border-0 group/item">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 bg-card dark:bg-black rounded-2xl flex items-center justify-center overflow-hidden border border-border dark:border-border p-2.5 transition-transform duration-500 group-hover/item:scale-110">
                                    @if ($item->product && !empty($item->product->images))
                                        <img src="{{ url('storage', $item->product->images[0]) }}" class="w-full h-full object-contain filter grayscale-[0.3] group-hover/item:grayscale-0 transition-all duration-700">
                                    @else
                                        <x-lucide-package class="w-6 h-6 text-muted-foreground" />
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black italic tracking-tight text-foreground line-clamp-1 group-hover/item:text-primary transition-colors">
                                        {{ $item->product->name ?? 'Edition Item' }}
                                    </p>
                                    <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-[0.3em] mt-2">
                                        {{ str_pad($item->quantity, 2, '0', STR_PAD_LEFT) }} Units <span class="mx-2 text-border">/</span> ₦{{ number_format($item->unit_amount, 2) }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-lg font-black italic tracking-tighter text-foreground tabular-nums">
                                ₦{{ number_format($item->grand_total ?? $item->unit_amount * $item->quantity, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </details>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="px-10 py-8 flex items-center justify-between bg-muted/50 dark:bg-muted border-t border-border">
        <a href="{{ route('my-orders.show', $order->id) }}" wire:navigate
            class="group/btn relative inline-flex items-center gap-4 text-[11px] font-black uppercase tracking-[0.4em] text-foreground transition-all">
            <span class="relative group-hover:text-primary transition-colors duration-300">
                Review Full Dossier
                <span class="absolute bottom-0 left-0 w-full h-[1.5px] bg-primary scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></span>
            </span>
            <x-lucide-arrow-right class="w-5 h-5 transition-transform group-hover/btn:translate-x-3 text-primary" />
        </a>

        @if (in_array($order->status, ['pending', 'processing', 'paid']))
            <button wire:click="cancelOrder({{ $order->id }})"
                wire:confirm="Permanent cancellation of this acquisition record?"
                class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground hover:text-red-500 transition-all px-6 py-3 border border-transparent hover:border-red-100 dark:hover:border-red-500/20 rounded-full hover:bg-red-50/50 dark:hover:bg-red-500/5">
                Cancel Acquisition
            </button>
        @endif
    </div>
</div>
