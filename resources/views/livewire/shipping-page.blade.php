<div class="min-h-screen bg-background text-foreground transition-colors duration-700 overflow-hidden selection:bg-primary/20 selection:text-primary">
    
    {{-- Ambient watermark --}}
    <div class="fixed top-20 right-[-10%] opacity-[0.03] dark:opacity-[0.05] pointer-events-none select-none">
        <h2 class="text-[25rem] font-black uppercase tracking-tighter rotate-12 text-foreground">DELIVERY</h2>
    </div>
    <div class="fixed bottom-0 left-0 w-[400px] h-[400px] bg-secondary/5 blur-[120px] rounded-full -z-10 dark:bg-secondary/[0.03] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 py-24 relative z-10">
        
        {{-- Header --}}
        <header class="relative mb-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 border-b border-border pb-16">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-4 px-4 py-1.5 rounded-full bg-muted border border-border text-[9px] font-black uppercase tracking-[0.5em] text-muted-foreground">
                        Logistics & Transit
                    </div>
                    <h1 class="text-7xl md:text-9xl font-black italic tracking-tighter uppercase leading-[0.8] text-foreground">
                        Shipping <br/> <span class="text-primary font-outline-1 dark:font-outline-white">Policy.</span>
                    </h1>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-primary italic pt-4">
                        Document Revision // April 2026
                    </p>
                </div>

                {{-- Action Console --}}
                <div class="flex gap-4">
                    <button class="group flex items-center gap-4 px-8 py-4 rounded-2xl border border-border hover:bg-foreground hover:text-background transition-all duration-500 shadow-xl shadow-transparent hover:shadow-primary/10">
                        <x-lucide-printer class="w-4 h-4" />
                        <span class="text-[10px] font-black uppercase tracking-widest">Hard Copy</span>
                    </button>
                    <button class="p-4 rounded-2xl border border-border hover:border-primary transition-colors text-muted-foreground hover:text-primary">
                        <x-lucide-download class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </header>

        <div class="grid lg:grid-cols-[320px_1fr] gap-24">
            
            {{-- Navigation: The Index --}}
            <aside class="hidden lg:block">
                <div class="sticky top-32 space-y-2">
                    <div class="mb-10 pl-6 border-l border-primary/20">
                        <p class="text-[11px] font-black uppercase tracking-[0.4em] text-muted-foreground">Digital Index</p>
                    </div>
                    
                    @php
                        $nav = [
                            '1. Delivery Zones', '2. Processing Timeline', '3. Shipping Rates', 
                            '4. Order Tracking', '5. Failed Delivery', '6. International Shipping',
                            '7. Shipping Partners', '8. Customs & Duties', '9. Express Options', '10. Contact Logistics'
                        ];
                    @endphp
                    
                    <nav class="space-y-1">
                        @foreach($nav as $index => $item)
                            <a href="#shipping-section-{{ $index + 1 }}" 
                               class="group flex items-center gap-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-primary transition-all">
                                <span class="w-6 h-[1px] bg-border group-hover:w-10 group-hover:bg-primary transition-all"></span>
                                {{ $item }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- Content --}}
            <div class="space-y-32">
                <div class="prose prose-2xl dark:prose-invert max-w-none">
                    <p class="text-2xl md:text-3xl leading-snug italic font-medium text-muted-foreground border-l-[6px] border-primary pl-12 py-4 tracking-tight">
                        {{ $site->site_name }} offers reliable nationwide and international delivery. This policy outlines our shipping processes, timelines, and partner networks.
                    </p>
                </div>

                {{-- Section 01: Delivery Zones --}}
                <section id="shipping-section-1" class="group scroll-mt-32">
                    <div class="flex items-baseline gap-6 mb-12">
                        <span class="text-6xl font-black text-muted group-hover:text-primary/20 transition-colors duration-700">01</span>
                        <h2 class="text-3xl font-black uppercase tracking-tighter italic text-foreground">Delivery Zones</h2>
                    </div>
                    <div class="grid gap-8 md:grid-cols-3">
                        <div class="p-10 bg-card border border-border rounded-[3rem] hover:shadow-2xl hover:border-secondary/20 transition-all duration-700">
                            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                                <x-lucide-map-pin class="w-6 h-6 text-primary" />
                            </div>
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-4">Lagos Metro</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed font-medium">
                                Same-day delivery available for orders placed before 12:00 PM within Lagos Island and Victoria Island.
                            </p>
                        </div>
                        <div class="p-10 bg-card border border-border rounded-[3rem] hover:shadow-2xl hover:border-secondary/20 transition-all duration-700">
                            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                                <x-lucide-truck class="w-6 h-6 text-primary" />
                            </div>
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-4">Nationwide (NG)</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed font-medium">
                                3-5 business days delivery to all 36 states in Nigeria via our trusted logistics partners.
                            </p>
                        </div>
                        <div class="p-10 bg-card border border-border rounded-[3rem] hover:shadow-2xl hover:border-secondary/20 transition-all duration-700">
                            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                                <x-lucide-globe class="w-6 h-6 text-primary" />
                            </div>
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-4">International</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed font-medium">
                                7-14 business days for West Africa, 10-21 days for Europe and Americas. Customs clearance included.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Section 03: Shipping Rates --}}
                <section id="shipping-section-3" class="group scroll-mt-32">
                    <div class="flex items-baseline gap-6 mb-12">
                        <span class="text-6xl font-black text-muted group-hover:text-primary/20 transition-colors duration-700">03</span>
                        <h2 class="text-3xl font-black uppercase tracking-tighter italic text-foreground">Shipping Rates</h2>
                    </div>
                    <div class="p-10 bg-card border border-border rounded-[3rem] relative overflow-hidden group">
                            <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-secondary/20 rounded-tr-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-secondary/20 rounded-bl-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-border">
                                        <th class="text-left py-4 text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">Zone</th>
                                        <th class="text-left py-4 text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">Standard</th>
                                        <th class="text-left py-4 text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">Express</th>
                                        <th class="text-left py-4 text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">Free Threshold</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    <tr>
                                        <td class="py-4 text-sm font-medium text-foreground">Lagos Metro</td>
                                        <td class="py-4 text-sm text-muted-foreground">₦2,500</td>
                                        <td class="py-4 text-sm text-muted-foreground">₦5,000</td>
                                        <td class="py-4 text-sm text-primary font-black">₦50,000+</td>
                                    </tr>
                                    <tr>
                                        <td class="py-4 text-sm font-medium text-foreground">SW Nigeria</td>
                                        <td class="py-4 text-sm text-muted-foreground">₦3,500</td>
                                        <td class="py-4 text-sm text-muted-foreground">₦7,000</td>
                                        <td class="py-4 text-sm text-primary font-black">₦75,000+</td>
                                    </tr>
                                    <tr>
                                        <td class="py-4 text-sm font-medium text-foreground">Other States</td>
                                        <td class="py-4 text-sm text-muted-foreground">₦4,500</td>
                                        <td class="py-4 text-sm text-muted-foreground">₦9,000</td>
                                        <td class="py-4 text-sm text-primary font-black">₦100,000+</td>
                                    </tr>
                                    <tr>
                                        <td class="py-4 text-sm font-medium text-foreground">International</td>
                                        <td class="py-4 text-sm text-muted-foreground">$25 USD</td>
                                        <td class="py-4 text-sm text-muted-foreground">$50 USD</td>
                                        <td class="py-4 text-sm text-muted-foreground">N/A</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- Section 07: Shipping Partners (High Contrast) --}}
                <section id="shipping-section-7" class="relative group scroll-mt-32">
                    <div class="absolute inset-0 bg-foreground rounded-[4rem] -rotate-1 group-hover:rotate-0 transition-transform duration-700"></div>
                    <div class="relative bg-foreground text-background p-16 md:p-24 rounded-[4rem] shadow-2xl overflow-hidden">
                        <div class="absolute top-0 right-0 p-12 opacity-05">
                            <x-lucide-truck class="w-48 h-48" />
                        </div>
                        
                        <div class="flex items-center gap-6 mb-12">
                            <span class="text-5xl font-black opacity-20">07</span>
                            <h2 class="text-3xl font-black uppercase tracking-tighter italic">Logistics Partners</h2>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-16 relative z-10">
                            <div class="space-y-4">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50">Trusted Partners</p>
                                <p class="text-base font-bold leading-relaxed uppercase tracking-tight">
                                    We partner with industry-leading logistics providers including DHL, FedEx, and local champions like Gokada and Mr. Speedy for reliable last-mile delivery.
                                </p>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50">Order Tracking</p>
                                <p class="text-base leading-relaxed opacity-70 italic font-medium">
                                    Once your order ships, you'll receive a tracking number via SMS and email. Track your package in real-time through our portal.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section 10: Contact Logistics --}}
                <section id="shipping-section-10" class="pt-24 border-t border-border scroll-mt-32">
                    <div class="flex flex-col md:flex-row gap-20">
                        <div class="flex-1 space-y-8">
                            <h2 class="text-5xl font-black uppercase tracking-tighter italic text-foreground">Logistics <br/> Support</h2>
                            <p class="text-sm text-muted-foreground max-w-sm leading-relaxed font-medium">
                                For shipping inquiries, delivery issues, or to schedule a specific delivery time, contact our logistics concierge.
                            </p>
                        </div>
                        <div class="flex-1 grid gap-10">
                            <div class="group flex items-start gap-6">
                                <div class="p-5 bg-primary/5 rounded-2xl border border-primary/10 group-hover:bg-primary transition-all duration-500">
                                    <x-lucide-mail class="w-6 h-6 text-primary group-hover:text-background" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase text-muted-foreground tracking-[0.3em] mb-2">Logistics Concierge</p>
                                    <p class="text-xl font-bold hover:text-primary transition-colors cursor-pointer text-foreground">{{ $site->contact_email }}</p>
                                </div>
                            </div>
                            <div class="group flex items-start gap-6">
                                <div class="p-5 bg-primary/5 rounded-2xl border border-primary/10 group-hover:bg-primary transition-all duration-500">
                                    <x-lucide-phone class="w-6 h-6 text-primary group-hover:text-background" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase text-muted-foreground tracking-[0.3em] mb-2">Priority Line</p>
                                    <p class="text-xl font-bold text-foreground">+234 800 {{ strtoupper($site->site_name) }}</p>
                                    <p class="text-xs text-muted-foreground mt-1 uppercase tracking-widest font-bold">Mon-Fri: 09:00 - 18:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
