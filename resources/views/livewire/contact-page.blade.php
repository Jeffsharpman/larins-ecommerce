<div class="max-w-7xl mx-auto px-6 py-24 relative overflow-hidden">
    {{-- Ambient Watermark --}}
    <div class="absolute top-40 left-1/2 -translate-x-1/2 -z-10 opacity-[0.03] dark:opacity-[0.02]">
        <h2 class="text-[15rem] font-black uppercase tracking-tighter select-none italic">Concierge</h2>
    </div>
    <div class="absolute bottom-0 right-[-5%] w-[500px] h-[500px] bg-secondary/5 blur-[120px] rounded-full pointer-events-none"></div>

    {{-- Header Section --}}
    <div class="text-center mb-32 relative">
        <div class="relative inline-block mb-8 animate-in fade-in zoom-in duration-1000">
            <div class="w-24 h-24 bg-primary/5 rounded-full flex items-center justify-center mx-auto backdrop-blur-md border border-primary/10">
                <x-lucide-message-circle class="w-10 h-10 text-primary" />
            </div>
            <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-background border border-border rounded-full flex items-center justify-center shadow-sm">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            </div>
        </div>
        <h1 class="text-6xl md:text-8xl font-black tracking-tighter uppercase italic text-foreground mb-8 leading-[0.8]">
            Get In <span class="text-primary" style="-webkit-text-stroke: 1px currentColor; -webkit-text-fill-color: transparent;">Touch</span>
        </h1>
        <p class="text-[11px] text-muted-foreground max-w-xl mx-auto uppercase tracking-[0.4em] font-black leading-relaxed opacity-70 italic">
            Bespoke assistance for the modern aesthetic. Reach out for archive inquiries, collaborations, or global support.
        </p>
    </div>

    {{-- Contact Methods --}}
    <div class="grid gap-8 md:grid-cols-3 mb-32">
        @php
            $methods = [
                ['icon' => 'phone', 'title' => 'Direct Line', 'info' => '+234 800 ' . strtoupper($site->site_name), 'sub' => 'Mon-Fri: 09:00 - 18:00'],
                ['icon' => 'mail', 'title' => 'Digital Mail', 'info' => $site->contact_email, 'sub' => 'Priority 24h Response'],
                ['icon' => 'map-pin', 'title' => 'Flagship Archive', 'info' => 'Victoria Island, Lagos', 'sub' => 'Private Viewing Only']
            ];
        @endphp

        @foreach($methods as $method)
        <div class="group bg-card/40 backdrop-blur-sm border border-border/60 p-12 rounded-[3rem] text-center hover:border-primary/40 dark:hover:border-secondary/40 transition-all duration-700 hover:shadow-card dark:hover:shadow-secondary/5">
            <div class="w-14 h-14 bg-muted rounded-[1.25rem] flex items-center justify-center mx-auto mb-8 group-hover:bg-primary group-hover:text-background transition-all duration-500">
                @svg('lucide-' . $method['icon'], 'w-6 h-6')
            </div>
            <h3 class="text-[9px] font-black uppercase tracking-[0.5em] text-muted-foreground/60 mb-4">{{ $method['title'] }}</h3>
            <p class="text-xl font-black tracking-tighter mb-3 italic text-foreground">{{ $method['info'] }}</p>
            <p class="text-[9px] font-bold uppercase tracking-[0.2em] opacity-40">{{ $method['sub'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid gap-16 lg:grid-cols-5 items-start">
        {{-- Message Form --}}
        <div class="lg:col-span-3">
            <div class="bg-card border border-border rounded-[3.5rem] p-10 md:p-16 shadow-card relative overflow-hidden group dark:border-secondary/10">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/5 rounded-full blur-[100px] transition-all duration-1000 group-hover:bg-primary/10"></div>
                <div class="absolute -left-20 -bottom-20 w-56 h-56 bg-secondary/5 rounded-full blur-[100px] transition-all duration-1000 group-hover:bg-secondary/10"></div>
                
                <div class="flex items-center gap-5 mb-16 relative z-10">
                    <div class="w-12 h-12 bg-primary text-background rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20">
                        <x-lucide-send class="w-5 h-5" />
                    </div>
                    <div>
                        <h2 class="text-3xl font-black uppercase tracking-tighter italic">Dispatch <span class="text-primary">Message</span></h2>
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground opacity-60">Archive Communication</p>
                    </div>
                </div>

                <form id="contactForm" class="space-y-12 relative z-10">
                    <div class="grid gap-12 md:grid-cols-2">
                        <div class="space-y-3">
                            <label class="text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground ml-1">Identity</label>
                            <input type="text" placeholder="Full Name" class="w-full bg-transparent border-0 border-b border-border focus:border-primary focus:ring-0 px-0 py-4 text-sm font-bold transition-all placeholder:text-muted-foreground/20 placeholder:uppercase placeholder:tracking-widest">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground ml-1">Digital Address</label>
                            <input type="email" placeholder="email@example.com" class="w-full bg-transparent border-0 border-b border-border focus:border-primary focus:ring-0 px-0 py-4 text-sm font-bold transition-all placeholder:text-muted-foreground/20">
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <label class="text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground ml-1">Inquiry Nature</label>
                        <select class="w-full bg-transparent border-0 border-b border-border focus:border-primary focus:ring-0 px-0 py-4 text-sm font-bold transition-all appearance-none cursor-pointer uppercase tracking-widest">
                            <option>Order Acquisition</option>
                            <option>Bespoke Request</option>
                            <option>Press & Collaboration</option>
                            <option>Technical Support</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground ml-1">Manifesto</label>
                        <textarea rows="4" placeholder="HOW CAN WE ASSIST YOUR VISION?" class="w-full bg-transparent border-0 border-b border-border focus:border-primary focus:ring-0 px-0 py-4 text-sm font-bold transition-all resize-none placeholder:text-muted-foreground/20"></textarea>
                    </div>

                    <button type="submit" class="group relative flex items-center gap-4 px-14 py-6 bg-foreground text-background text-[11px] font-black uppercase tracking-[0.4em] rounded-full hover:bg-primary hover:text-background transition-all duration-700 shadow-2xl hover:shadow-primary/30">
                        Transmit Inquiry
                        <x-lucide-arrow-right class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-500" />
                    </button>
                </form>
            </div>
        </div>

        {{-- Sidebar FAQ & Social --}}
        <div class="lg:col-span-2 space-y-10">
            <div class="bg-foreground text-background dark:bg-card dark:text-foreground rounded-[3rem] p-12 relative overflow-hidden border border-border shadow-2xl">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary/10 rounded-full blur-[60px]"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-secondary/10 rounded-full blur-[60px]"></div>
                
                <h3 class="text-[10px] font-black uppercase tracking-[0.5em] opacity-40 mb-12">Concierge Intel</h3>
                
                <div class="space-y-10 relative z-10">
                    <div class="group">
                        <h4 class="text-xs font-black uppercase mb-3 text-primary tracking-widest group-hover:italic transition-all">Acquisition Logistics</h4>
                        <p class="text-[11px] opacity-60 leading-relaxed font-bold uppercase tracking-tight">Standard fulfillment within Nigeria: 3-5 Business Cycles. Global logistics vary by territory.</p>
                    </div>
                    <div class="group">
                        <h4 class="text-xs font-black uppercase mb-3 text-primary tracking-widest group-hover:italic transition-all">Archive Exchanges</h4>
                        <p class="text-[11px] opacity-60 leading-relaxed font-bold uppercase tracking-tight">Acquisitions must be returned in mint condition within 14 cycles for curated exchange or credit.</p>
                    </div>
                </div>

                <div class="mt-16 pt-8 border-t border-background/10 dark:border-border">
                    <a href="#" class="text-[10px] font-black uppercase tracking-[0.3em] border-b-2 border-primary/30 pb-2 text-primary hover:border-primary transition-all duration-500 italic">Explore Full Directory</a>
                </div>
            </div>

            <div class="flex justify-between items-center p-8 bg-card border border-border rounded-full px-12 group transition-all hover:border-primary/20 dark:hover:border-secondary/20">
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60">Follow {{ $site->site_name }}</span>
                <div class="flex gap-8">
                    <a href="#" class="text-muted-foreground hover:text-primary transition-all hover:scale-125"><x-lucide-instagram class="w-4.5 h-4.5" /></a>
                    <a href="#" class="text-muted-foreground hover:text-primary transition-all hover:scale-125"><x-lucide-twitter class="w-4.5 h-4.5" /></a>
                    <a href="#" class="text-muted-foreground hover:text-primary transition-all hover:scale-125"><x-lucide-youtube class="w-4.5 h-4.5" /></a>
                </div>
            </div>
        </div>
    </div>
</div>