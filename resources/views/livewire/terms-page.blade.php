<div class="min-h-screen bg-background text-foreground transition-colors duration-700 overflow-hidden selection:bg-primary/20 selection:text-primary">
    
    {{-- Ambient Legal watermark --}}
    <div class="fixed top-20 right-[-10%] opacity-[0.03] dark:opacity-[0.05] pointer-events-none select-none">
        <h2 class="text-[25rem] font-black uppercase tracking-tighter rotate-12 text-foreground">DECREE</h2>
    </div>
    <div class="fixed bottom-[-10%] right-[-5%] w-[500px] h-[500px] bg-secondary/5 blur-[140px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 py-24 relative z-10">
        
        {{-- Header: The Formal Preamble --}}
        <header class="relative mb-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 border-b border-border pb-16">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-4 px-4 py-1.5 rounded-full bg-muted border border-border text-[9px] font-black uppercase tracking-[0.5em] text-muted-foreground">
                        Corporate Governance
                    </div>
                    <h1 class="text-7xl md:text-9xl font-black italic tracking-tighter uppercase leading-[0.8] text-foreground">
                        Terms <br/> <span class="text-primary font-outline-1 dark:font-outline-white">& Protocol.</span>
                    </h1>
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-primary italic pt-4">
                        Document Revision // March 2026
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
                    <div class="mb-10 pl-6 border-l border-primary/20 dark:border-secondary/20">
                        <p class="text-[11px] font-black uppercase tracking-[0.4em] text-muted-foreground dark:text-secondary/60">Digital Index</p>
                    </div>
                    
                    @php
                        $nav = [
                            '1. Use of Digital Essence', '2. Acquisition Rituals', '3. Logistics & Transit', 
                            '4. Returns Policy', '5. Intellectual Archive', '6. Data Sanctity', 
                            '7. Liability Thresholds', '8. Jurisdiction', '9. Protocol Updates', '10. Direct Inquiry'
                        ];
                    @endphp
                    
                    <nav class="space-y-1">
                        @foreach($nav as $index => $item)
                            <a href="#section-{{ $index + 1 }}" 
                               class="group flex items-center gap-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-primary dark:hover:text-secondary transition-all">
                                <span class="w-6 h-[1px] bg-border group-hover:w-10 group-hover:bg-primary dark:group-hover:bg-secondary transition-all"></span>
                                {{ $item }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- Content: The Decree --}}
            <div class="space-y-32">
                <div class="prose prose-2xl dark:prose-invert max-w-none">
                    <p class="text-2xl md:text-3xl leading-snug italic font-medium text-muted-foreground border-l-[6px] border-primary dark:border-secondary/50 pl-12 py-4 tracking-tight">
                        {{ $site->site_name }} is a collective of prestige. By accessing our interface, you enter into a binding ritual of commerce, governed by the following protocols.
                    </p>
                </div>

                {{-- Section 01: Usage --}}
                <section id="section-1" class="group scroll-mt-32">
                    <div class="flex items-baseline gap-6 mb-12">
                        <span class="text-6xl font-black text-muted group-hover:text-primary/20 dark:group-hover:text-secondary/20 transition-colors duration-700">01</span>
                        <span class="hidden md:block w-8 h-[2px] bg-secondary/30"></span>
                        <h2 class="text-3xl font-black uppercase tracking-tighter italic text-foreground">Usage & Eligibility</h2>
                    </div>
                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="p-10 bg-card border border-border rounded-[3rem] hover:shadow-2xl dark:hover:border-secondary/20 transition-all duration-700">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary dark:text-secondary mb-6">Maturity Clause</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed font-medium">
                                Interaction with the {{ $site->site_name }} ecosystem is reserved for individuals 18 years of age or older. We assume legal capacity for all transactions performed under your identity.
                            </p>
                        </div>
                        <div class="p-10 bg-card border border-border rounded-[3rem] hover:shadow-2xl dark:hover:border-secondary/20 transition-all duration-700">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-primary dark:text-secondary mb-6">Identity Security</h3>
                            <p class="text-sm text-muted-foreground leading-relaxed font-medium">
                                Your login credentials are the keys to your private archive. You are the sole custodian of their secrecy. {{ $site->site_name }} is not liable for breaches resulting from custodial negligence.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Section 07: Liability (High Contrast) --}}
                <section id="section-7" class="relative group scroll-mt-32">
                    <div class="absolute inset-0 bg-foreground rounded-[4rem] -rotate-1 group-hover:rotate-0 transition-transform duration-700"></div>
                    <div class="relative bg-foreground text-background p-16 md:p-24 rounded-[4rem] shadow-2xl overflow-hidden">
                        <div class="absolute top-0 right-0 p-12 opacity-5">
                            <x-lucide-shield-check class="w-48 h-48" />
                        </div>
                        
                        <div class="flex items-center gap-6 mb-12">
                            <span class="text-5xl font-black opacity-20">07</span>
                            <h2 class="text-3xl font-black uppercase tracking-tighter italic">Liability <span class="text-secondary/50">Thresholds</span></h2>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-16 relative z-10">
                            <div class="space-y-4">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50">Medical Disclaimer</p>
                                <p class="text-base font-bold leading-relaxed uppercase tracking-tight">
                                    Our products are aesthetic enhancements. They do not substitute for dermatological or medical advice. Results vary by individual biological composition.
                                </p>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50">Digital Continuity</p>
                                <p class="text-base leading-relaxed opacity-70 italic font-medium">
                                    While we strive for a seamless digital presence, {{ $site->site_name }} is provided "as is." We do not guarantee perpetual uptime during maintenance cycles.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section 10: Inquiry --}}
                <section id="section-10" class="pt-24 border-t border-border scroll-mt-32">
                    <div class="flex flex-col md:flex-row gap-20">
                        <div class="flex-1 space-y-8">
                            <h2 class="text-5xl font-black uppercase tracking-tighter italic text-foreground">Direct <br/> Correspondence</h2>
                            <p class="text-sm text-muted-foreground max-w-sm leading-relaxed font-medium">
                                For inquiries regarding the interpretation of these protocols, our legal concierge remains at your disposal.
                            </p>
                        </div>
                        <div class="flex-1 grid gap-10">
                            <div class="group flex items-start gap-6">
                                <div class="p-5 bg-primary/5 rounded-2xl border border-primary/10 group-hover:bg-primary transition-all duration-500">
                                    <x-lucide-mail class="w-6 h-6 text-primary group-hover:text-background" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase text-muted-foreground tracking-[0.3em] mb-2">Legal Concierge</p>
                                    <p class="text-xl font-bold hover:text-primary transition-colors cursor-pointer text-foreground">{{ $site->contact_email }}</p>
                                </div>
                            </div>
                            <div class="group flex items-start gap-6">
                                <div class="p-5 bg-primary/5 rounded-2xl border border-primary/10 group-hover:bg-primary transition-all duration-500">
                                    <x-lucide-map-pin class="w-6 h-6 text-primary group-hover:text-background" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase text-muted-foreground tracking-[0.3em] mb-2">Global HQ</p>
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