<div class="min-h-screen bg-background text-foreground transition-colors duration-700 overflow-hidden selection:bg-primary/20 selection:text-primary">
    
    {{-- Ambient Legal watermark --}}
    <div class="fixed top-20 right-[-10%] opacity-[0.03] dark:opacity-[0.05] pointer-events-none select-none">
        <h2 class="text-[25rem] font-black uppercase tracking-tighter rotate-12 text-foreground">PRIVACY</h2>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-24 relative z-10">
        
        {{-- Header: The Formal Preamble --}}
        <header class="relative mb-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 border-b border-border pb-16">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-4 px-4 py-1.5 rounded-full bg-muted border border-border text-[9px] font-black uppercase tracking-[0.5em] text-muted-foreground">
                        Data Sanctity
                    </div>
                    <h1 class="text-7xl md:text-9xl font-black italic tracking-tighter uppercase leading-[0.8] text-foreground">
                        Privacy <br/> <span class="text-primary font-outline-1 dark:font-outline-white">Policy.</span>
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
                            '1. Data We Gather', '2. How We Use Your Data', '3. Information Sharing', 
                            '4. Cookie Protocol', '5. Data Security', '6. Your Rights (NDPR)', 
                            '7. Third-Party Links', '8. Data Retention', '9. Children\'s Protocol', '10. Contact DPO'
                        ];
                    @endphp
                    
                    <nav class="space-y-1">
                        @foreach($nav as $index => $item)
                            <a href="#privacy-section-{{ $index + 1 }}" 
                               class="group flex items-center gap-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-primary transition-all">
                                <span class="w-6 h-[1px] bg-border group-hover:w-10 group-hover:bg-primary transition-all"></span>
                                {{ $item }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- Content: The Decree --}}
            <div class="space-y-32">
                <div class="prose prose-2xl dark:prose-invert max-w-none">
                    <p class="text-2xl md:text-3xl leading-snug italic font-medium text-muted-foreground border-l-[6px] border-primary pl-12 py-4 tracking-tight">
                        {{ $site->site_name }} respects your privacy. This policy outlines how we collect, use, and protect your data in compliance with the Nigeria Data Protection Regulation (NDPR).
                    </p>
                </div>

                {{-- Section 01: Data Collection --}}
                <section id="privacy-section-1" class="group scroll-mt-32">
                    <div class="flex items-baseline gap-6 mb-12">
                        <span class="text-6xl font-black text-muted group-hover:text-primary/20 transition-colors duration-700">01</span>
                        <h2 class="text-3xl font-black uppercase tracking-tighter italic text-foreground">Data We Gather</h2>
                    </div>
                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="p-10 bg-card border border-border rounded-[3rem] hover:shadow-2xl transition-all duration-700">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-6">Personal Intelligence</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed font-medium">
                                We collect identifiers including your name, email address, phone number (+234 format), and shipping coordinates when you create an account or complete an acquisition.
                            </p>
                        </div>
                        <div class="p-10 bg-card border border-border rounded-[3rem] hover:shadow-2xl transition-all duration-700">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-6">Transactional Records</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed font-medium">
                                Every acquisition generates data including order history, payment method (Paystack/Stripe), and delivery confirmation which we retain for warranty purposes.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Section 02: Data Usage --}}
                <section id="privacy-section-2" class="group scroll-mt-32">
                    <div class="flex items-baseline gap-6 mb-12">
                        <span class="text-6xl font-black text-muted group-hover:text-primary/20 transition-colors duration-700">02</span>
                        <h2 class="text-3xl font-black uppercase tracking-tighter italic text-foreground">How We Use Your Data</h2>
                    </div>
                    <div class="p-10 bg-card border border-border rounded-[3rem]">
                        <ul class="space-y-6">
                            @foreach(['Order Fulfillment & Delivery Tracking', 'Account Authentication & Security', 'Marketing Communications (Opt-in)', 'Customer Support & Concierge Services', 'Analytics for Service Improvement'] as $use)
                            <li class="flex items-center gap-4">
                                <x-lucide-check-circle class="w-5 h-5 text-primary flex-shrink-0" />
                                <span class="text-sm text-muted-foreground font-medium">{{ $use }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                {{-- Section 06: NDPR Rights (High Contrast) --}}
                <section id="privacy-section-6" class="relative group scroll-mt-32">
                    <div class="absolute inset-0 bg-foreground rounded-[4rem] -rotate-1 group-hover:rotate-0 transition-transform duration-700"></div>
                    <div class="relative bg-foreground text-background p-16 md:p-24 rounded-[4rem] shadow-2xl overflow-hidden">
                        <div class="absolute top-0 right-0 p-12 opacity-05">
                            <x-lucide-shield class="w-48 h-48" />
                        </div>
                        
                        <div class="flex items-center gap-6 mb-12">
                            <span class="text-5xl font-black opacity-20">06</span>
                            <h2 class="text-3xl font-black uppercase tracking-tighter italic">Your Rights (NDPR)</h2>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-16 relative z-10">
                            <div class="space-y-4">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50">Right to Access</p>
                                <p class="text-base font-bold leading-relaxed uppercase tracking-tight">
                                    You may request a copy of all personal data we hold about you at any time.
                                </p>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50">Right to Erasure</p>
                                <p class="text-base leading-relaxed opacity-70 italic font-medium">
                                    Under NDPR, you have the right to request deletion of your personal data subject to legal retention requirements.
                                </p>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50">Right to Rectification</p>
                                <p class="text-base font-bold leading-relaxed uppercase tracking-tight">
                                    You may update or correct inaccurate personal data at any time via your account settings.
                                </p>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50">Withdraw Consent</p>
                                <p class="text-base leading-relaxed opacity-70 italic font-medium">
                                    You may withdraw consent for marketing communications at any time by clicking the unsubscribe link.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section 10: Contact DPO --}}
                <section id="privacy-section-10" class="pt-24 border-t border-border scroll-mt-32">
                    <div class="flex flex-col md:flex-row gap-20">
                        <div class="flex-1 space-y-8">
                            <h2 class="text-5xl font-black uppercase tracking-tighter italic text-foreground">Data Protection <br/> Officer</h2>
                            <p class="text-sm text-muted-foreground max-w-sm leading-relaxed font-medium">
                                For data protection inquiries or to exercise your rights, contact our designated Data Protection Officer.
                            </p>
                        </div>
                        <div class="flex-1 grid gap-10">
                            <div class="group flex items-start gap-6">
                                <div class="p-5 bg-primary/5 rounded-2xl border border-primary/10 group-hover:bg-primary transition-all duration-500">
                                    <x-lucide-mail class="w-6 h-6 text-primary group-hover:text-background" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase text-muted-foreground tracking-[0.3em] mb-2">Data Protection Officer</p>
                                    <p class="text-xl font-bold hover:text-primary transition-colors cursor-pointer text-foreground">{{ $site->contact_email }}</p>
                                </div>
                            </div>
                            <div class="group flex items-start gap-6">
                                <div class="p-5 bg-primary/5 rounded-2xl border border-primary/10 group-hover:bg-primary transition-all duration-500">
                                    <x-lucide-map-pin class="w-6 h-6 text-primary group-hover:text-background" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase text-muted-foreground tracking-[0.3em] mb-2">Headquarters</p>
                                    <p class="text-xl font-bold text-foreground">Lagos, Nigeria</p>
                                    <p class="text-xs text-muted-foreground mt-1 uppercase tracking-widest font-bold">Victoria Island District</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
