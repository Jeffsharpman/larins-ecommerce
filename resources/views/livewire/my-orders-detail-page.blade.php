<div class="max-w-7xl mx-auto px-6 py-20 relative">
    {{-- Decorative Background Element --}}
    <div class="absolute top-0 right-0 -z-10 opacity-[0.03] select-none pointer-events-none">
        <h2 class="text-[18rem] font-black uppercase tracking-tighter italic leading-none">Manifest</h2>
    </div>

    {{-- Navigation & Breadcrumb --}}
    <nav class="mb-16">
        <a href="{{ route('my-orders') }}" wire:navigate 
           class="inline-flex items-center gap-4 text-muted-foreground hover:text-primary transition-all group">
            <div class="w-12 h-12 rounded-full border border-border flex items-center justify-center group-hover:border-primary/40 group-hover:bg-primary/5 transition-all duration-500">
                <x-lucide-arrow-left class="w-5 h-5 group-hover:-translate-x-1 transition-transform" />
            </div>
            <div class="flex flex-col">
                <span class="font-black uppercase text-[10px] tracking-[0.4em]">Return to Archive</span>
                <span class="text-[9px] font-bold uppercase tracking-widest opacity-40">Previous Acquisitions</span>
            </div>
        </a>
    </nav>

    @if ($order)
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
        
        {{-- Main Content: Selection & Shipping --}}
        <div class="lg:col-span-8 space-y-12">
            
            {{-- Order Header Archive Card --}}
            <div class="bg-card/40 backdrop-blur-sm rounded-[3rem] border border-border/60 p-12 shadow-card relative overflow-hidden group hover:border-secondary/20 transition-all duration-500">
                <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-secondary/10 blur-[80px] rounded-full opacity-30 group-hover:opacity-50 transition-opacity duration-1000"></div>
                <div class="absolute top-0 right-0 p-10">
                    <div class="flex flex-col items-end gap-2">
                        <span class="text-[9px] font-black uppercase tracking-[0.3em] opacity-40 mb-1">Status Protocol</span>
                        <span class="badge {{ $order->payment_status === 'paid' ? 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20' : 'bg-primary/10 text-primary border-primary/20' }} shadow-sm">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-12 items-start md:items-center relative z-10">
                    <div class="space-y-3">
                        <p class="text-[10px] font-black uppercase tracking-[0.5em] text-muted-foreground/60 italic">Reference Identifier</p>
                        <h1 class="text-4xl font-black tracking-tighter text-foreground italic leading-none">
                            #{{ $order->order_number }}
                        </h1>
                    </div>

                    <div class="h-20 w-[1px] bg-border/60 hidden md:block rotate-12"></div>

                    <div class="flex gap-16">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60">Authenticated</p>
                            <p class="font-black text-sm tracking-tight uppercase">{{ $order->created_at->format('d M, Y') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60">Logistics Flow</p>
                            <p class="font-black text-sm text-primary uppercase tracking-widest italic animate-pulse">{{ $order->status }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- The Selection (Items List) --}}
            <div class="bg-card rounded-[3.5rem] border border-border/60 shadow-card overflow-hidden">
                <div class="px-12 py-10 border-b border-border/60 flex justify-between items-end bg-muted/5 relative">
                    <div class="absolute bottom-0 left-0 w-12 h-[2px] bg-gradient-to-r from-secondary/30 to-transparent rounded-full"></div>
                    <div>
                        <h3 class="font-black uppercase text-[11px] tracking-[0.5em] text-foreground">Archive Selection</h3>
                        <p class="text-[9px] font-bold text-muted-foreground uppercase tracking-widest mt-1 opacity-50 italic">Verified Inventory Units</p>
                    </div>
                    <span class="text-[10px] font-black text-primary uppercase tracking-[0.3em] bg-primary/5 px-4 py-1.5 rounded-lg border border-primary/10">
                        {{ count($order_items) }} Items
                    </span>
                </div>
                <div class="divide-y divide-border/40">
                    @foreach ($order_items as $item)
                        <div class="p-10 hover:bg-muted/10 hover:bg-secondary/[0.02] dark:hover:bg-secondary/[0.01] transition-all duration-500 group relative">
                            <div class="absolute left-0 top-2 bottom-2 w-[2px] bg-secondary/20 rounded-full scale-y-0 group-hover:scale-y-100 transition-transform duration-500 origin-top"></div>
                            <x-card.my-order-item-card :item="$item" />
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Shipping Intel --}}
            @if ($address)
            <div class="bg-card rounded-[3.5rem] border border-border/60 p-12 shadow-card relative group hover:border-secondary/20 transition-all duration-500">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary/5 rounded-full blur-[60px] group-hover:bg-primary/10 transition-colors duration-1000"></div>
                <div class="absolute top-0 right-0 w-24 h-24 bg-secondary/[0.03] dark:bg-secondary/[0.02] rounded-full blur-[50px]"></div>
                
                <div class="flex items-center gap-6 mb-12">
                    <div class="w-16 h-16 rounded-3xl bg-primary text-background flex items-center justify-center shadow-lg shadow-primary/20 transition-transform group-hover:rotate-12">
                        <x-lucide-map-pin class="w-7 h-7 stroke-[1.5]" />
                    </div>
                    <div>
                        <h3 class="font-black uppercase text-[11px] tracking-[0.5em] text-foreground">Transit Destination</h3>
                        <p class="text-[9px] text-muted-foreground uppercase tracking-widest mt-1 italic">Authorized Delivery Point</p>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-16 relative z-10">
                    <div class="space-y-4">
                        <div class="inline-block px-3 py-1 bg-muted rounded-md text-[8px] font-black uppercase tracking-widest text-muted-foreground">Recipient Identity</div>
                        <p class="font-black text-foreground uppercase tracking-tighter text-2xl italic">{{ $order->user->name }}</p>
                        <p class="text-muted-foreground leading-loose font-bold uppercase text-[11px] tracking-[0.2em] opacity-80 border-l-2 border-primary/20 pl-6">
                            {{ $address->street_address }}<br>
                            {{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}
                        </p>
                    </div>
                    <div class="bg-muted/30 backdrop-blur-md p-8 rounded-[2.5rem] border border-border/60 flex flex-col justify-center space-y-4">
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground mb-1">Direct Priority Line</p>
                            <p class="font-black text-foreground text-xl tracking-tighter">{{ $address->phone }}</p>
                        </div>
                        <div class="h-[2px] w-12 bg-gradient-to-r from-primary/30 via-secondary/20 to-transparent"></div>
                        <p class="text-[9px] text-muted-foreground uppercase font-black tracking-widest leading-relaxed opacity-60">
                            Protocol: Official signature required upon arrival of logistics carrier.
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar: Financial Manifest & Actions --}}
        <aside class="lg:col-span-4 lg:sticky lg:top-32 space-y-10">
            <div class="bg-foreground text-background dark:bg-card dark:text-foreground rounded-[3.5rem] p-12 shadow-2xl relative overflow-hidden border border-primary/10 group">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/10 rounded-full blur-[100px]"></div>
                <div class="absolute -left-20 bottom-0 w-48 h-48 bg-secondary/[0.05] dark:bg-secondary/[0.03] rounded-full blur-[80px]"></div>
                
                <h3 class="font-black uppercase text-[10px] tracking-[0.5em] mb-12 pb-6 border-b border-background/10 dark:border-border/60 text-primary italic relative z-10">Financial Manifest</h3>
                
                <div class="space-y-8 mb-12 relative z-10">
                    <div class="flex justify-between text-[11px] font-black uppercase tracking-[0.3em]">
                        <span class="opacity-40">Selection Subtotal</span>
                        <span class="tracking-tighter">{{ Number::currency($order->grand_total, 'NGN') }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] font-black uppercase tracking-[0.3em]">
                        <span class="opacity-40">Logistics (Global)</span>
                        <span class="text-primary italic tracking-widest">Complimentary</span>
                    </div>
                    <div class="flex justify-between text-[11px] font-black uppercase tracking-[0.3em]">
                        <span class="opacity-40">Maison Surcharge</span>
                        <span>₦0.00</span>
                    </div>
                </div>

                <div class="pt-10 border-t-2 border-dashed border-background/20 dark:border-border/60 mb-12">
                    <div class="flex flex-col gap-2">
                        <p class="text-[9px] font-black uppercase tracking-[0.6em] text-primary/80">Total Acquisition Value</p>
                        <p class="text-5xl font-black tracking-tighter italic">
                            {{ Number::currency($order->grand_total, 'NGN') }}
                        </p>
                    </div>
                </div>

                <button class="w-full py-6 bg-primary text-background font-black uppercase tracking-[0.4em] text-[11px] rounded-full hover:scale-105 transition-all duration-700 shadow-xl shadow-primary/20 group flex items-center justify-center gap-4">
                    <x-lucide-arrow-down-to-line class="w-5 h-5 transition-all group-hover:translate-y-1" />
                    Archive Invoice
                </button>
            </div>

            {{-- Concierge Assistance --}}
            <div class="bg-card/40 backdrop-blur-sm rounded-[2.5rem] p-10 border border-border group hover:border-primary/20 hover:border-secondary/20 transition-all duration-700">
                <div class="flex items-center gap-5 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-background border border-border group-hover:bg-primary group-hover:text-background transition-all duration-700 flex items-center justify-center">
                        <x-lucide-help-circle class="w-6 h-6 stroke-[1.5]" />
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-foreground uppercase tracking-[0.4em]">Concierge Assistance</p>
                        <p class="text-[8px] font-bold text-muted-foreground uppercase tracking-widest">24/7 Digital Support</p>
                    </div>
                </div>
                <p class="text-[10px] text-muted-foreground uppercase font-black tracking-[0.2em] leading-loose mb-8 opacity-60">
                    Our curators are standing by to assist with archive details or transit inquiries.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <a href="#" class="py-4 bg-background border border-border rounded-2xl text-[9px] font-black uppercase tracking-widest text-center hover:bg-primary hover:text-background hover:border-primary transition-all duration-500">Live Chat</a>
                    <a href="#" class="py-4 bg-background border border-border rounded-2xl text-[9px] font-black uppercase tracking-widest text-center hover:bg-primary hover:text-background hover:border-primary transition-all duration-500">Signal Call</a>
                </div>
            </div>
        </aside>
    </div>
    @endif
</div>