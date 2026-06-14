<div class="max-w-7xl mx-auto px-6 py-24 relative overflow-hidden">
    {{-- Background Typography Watermark --}}
    <div class="absolute top-20 right-0 -z-10 opacity-[0.03] pointer-events-none">
        <h2 class="text-[20rem] font-black uppercase tracking-tighter italic leading-none">HELP</h2>
    </div>
    <div class="absolute bottom-0 left-[-5%] w-[400px] h-[400px] bg-secondary/5 blur-[120px] rounded-full pointer-events-none"></div>

    {{-- Header & Search --}}
    <div class="text-center mb-32 relative">
        <div class="relative inline-block mb-10 animate-in fade-in zoom-in duration-1000">
            <div class="w-24 h-24 bg-primary/5 rounded-[2.5rem] flex items-center justify-center mx-auto backdrop-blur-md border border-primary/10 rotate-12 group-hover:rotate-0 transition-transform duration-700">
                <x-lucide-help-circle class="w-10 h-10 text-primary -rotate-12 group-hover:rotate-0 transition-transform duration-700" />
            </div>
        </div>
        <h1 class="text-6xl md:text-9xl font-black tracking-tighter uppercase italic text-foreground mb-12 leading-[0.8]">
            Intel <span class="text-primary" style="-webkit-text-stroke: 1px currentColor; -webkit-text-fill-color: transparent;">Archive</span>
        </h1>
        
        <div class="max-w-2xl mx-auto mt-16 relative">
            <div class="group relative">
                <input type="text" id="faqSearch" placeholder="SEARCH LOGISTICS, FORMULAS, OR ACCESS..." 
                    class="w-full bg-transparent border-0 border-b-2 border-border focus:border-primary focus:ring-0 px-12 py-6 text-[12px] font-black tracking-[0.4em] transition-all placeholder:text-muted-foreground/20 text-center uppercase">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 text-muted-foreground/40 group-focus-within:text-primary transition-colors">
                    <x-lucide-search class="w-5 h-5" />
                </div>
            </div>
            <p class="text-[9px] font-black uppercase tracking-[0.5em] text-muted-foreground/40 mt-6">Instant support for the modern aesthetic</p>
        </div>
    </div>

    {{-- FAQ Categories Grid --}}
    <div class="grid gap-20 lg:grid-cols-2 mb-40">
        @php
            $faqCategories = [
                [
                    'icon' => 'package',
                    'title' => 'Logistics & Flow',
                    'questions' => [
                        ['q' => 'How do I initiate an acquisition?', 'a' => 'Curate your selection within the Archive, add to your vanity bag, and proceed through our encrypted checkout. A member profile is required for authenticated tracking.'],
                        ['q' => 'Global delivery timelines?', 'a' => 'Domestic transit (Nigeria) spans 3-5 business cycles. International logistics are territory-dependent. Express courier options are togglable during finalization.']
                    ]
                ],
                [
                    'icon' => 'refresh-ccw',
                    'title' => 'Exchanges & Archives',
                    'questions' => [
                        ['q' => 'The return manifesto?', 'a' => 'We offer a 14-cycle window for unused assets in original, vacuum-sealed packaging. For hygiene integrity, select beauty formulas remain final sale.'],
                        ['q' => 'Requesting an exchange?', 'a' => 'Signal our concierge via the digital portal. We coordinate secure courier retrieval or provide trans-shipment documentation.']
                    ]
                ],
                [
                    'icon' => 'flask-conical',
                    'title' => 'Formulation Ethos',
                    'questions' => [
                        ['q' => 'Cruelty-free certification?', 'a' => 'Non-negotiable. We are committed to ethical beauty; zero animal testing is performed on our finished compositions or raw molecular ingredients.'],
                        ['q' => 'Vegan compatibility?', 'a' => 'The core of our collection is 100% vegan. Specific archive pages display the Vegan Insignia where applicable to the formula.']
                    ]
                ],
                [
                    'icon' => 'shield-check',
                    'title' => 'Credential Access',
                    'questions' => [
                        ['q' => 'Resetting secure access?', 'a' => 'Navigate to the Login Suite and select "Forgotten Access." A secure decryption link will be dispatched to your registered digital mail.'],
                        ['q' => 'Specialist consultation?', 'a' => 'The Concierge is reachable via email at ' . $site->contact_email . ' or through our priority WhatsApp line during operational cycles.']
                    ]
                ]
            ];
        @endphp

        @foreach($faqCategories as $category)
        <div class="space-y-12 p-8 md:p-12 bg-card/30 backdrop-blur-sm border border-border/60 rounded-[3.5rem] hover:border-primary/20 dark:hover:border-secondary/20 transition-all duration-700">
            <div class="flex items-center gap-6 border-b border-border/60 pb-8">
                <div class="w-14 h-14 bg-primary text-background dark:bg-secondary dark:text-secondary-foreground rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20 dark:shadow-secondary/20">
                    @svg('lucide-' . $category['icon'], 'w-6 h-6')
                </div>
                <div>
                    <h2 class="text-2xl font-black uppercase tracking-tighter italic leading-none">{{ $category['title'] }}</h2>
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground opacity-50 mt-1">Directives & Protocols</p>
                </div>
            </div>

            <div class="space-y-4">
                @foreach($category['questions'] as $item)
                <details class="group border-b border-border/40 last:border-0">
                    <summary class="flex items-center justify-between cursor-pointer py-8 font-black text-[11px] uppercase tracking-[0.3em] text-foreground/80 hover:text-primary transition-all list-none">
                        <span class="max-w-[85%]">{{ $item['q'] }}</span>
                        <div class="relative w-5 h-5 flex items-center justify-center">
                            <x-lucide-plus class="w-5 h-5 absolute transition-all duration-700 group-open:rotate-180 group-open:opacity-0" />
                            <x-lucide-minus class="w-5 h-5 absolute transition-all duration-700 opacity-0 group-open:opacity-100 group-open:rotate-180 text-primary" />
                        </div>
                    </summary>
                    <div class="pb-10 pr-12 text-[12px] text-muted-foreground leading-relaxed font-bold uppercase tracking-wide opacity-70 italic animate-in slide-in-from-top-2 duration-500">
                        {{ $item['a'] }}
                    </div>
                </details>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Post-FAQ CTA Card --}}
        <div class="relative overflow-hidden bg-foreground text-background dark:bg-primary dark:text-background rounded-[4rem] p-16 md:p-28 text-center border border-primary/20 shadow-2xl dark:border-secondary/20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-background/5 blur-[120px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-background/5 blur-[100px] rounded-full -translate-x-1/2 translate-y-1/2"></div>
        <div class="absolute top-1/2 left-1/3 w-48 h-48 bg-secondary/10 blur-[100px] rounded-full"></div>
        
        <div class="relative z-10 space-y-10">
            <h2 class="text-5xl md:text-7xl font-black uppercase tracking-tighter italic leading-none">Unresolved <span class="opacity-30">Inquiry?</span></h2>
            <p class="text-[12px] font-black uppercase tracking-[0.5em] opacity-60 max-w-2xl mx-auto leading-relaxed">
                If your requirements exceed the standard archive protocols, our concierge team is prepared for a personal consultation.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-8 justify-center pt-8">
                <a href="/contact" class="group relative flex items-center justify-center gap-4 px-16 py-7 bg-background text-foreground text-[11px] font-black uppercase tracking-[0.4em] rounded-full hover:scale-105 transition-all duration-700 shadow-2xl">
                    Dispatch to Concierge
                    <x-lucide-arrow-right class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-500" />
                </a>
                <a href="tel:+2340000000" class="flex items-center justify-center gap-4 px-16 py-7 border-2 border-background/20 text-background text-[11px] font-black uppercase tracking-[0.4em] rounded-full hover:bg-background/10 transition-all duration-500">
                    <x-lucide-phone class="w-4 h-4" />
                    Direct Priority Line
                </a>
            </div>
        </div>
    </div>
</div>