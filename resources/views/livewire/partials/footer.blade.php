<footer class="bg-background text-foreground font-body border-t border-border/40 transition-colors duration-500 relative overflow-hidden">
    {{-- Decorative subtle glow: Uses your dynamic primary color --}}
    <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-primary/5 to-transparent pointer-events-none"></div>

    {{-- VIP Newsletter Section --}}
    <div class="bg-muted/10 border-b border-border/40 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row lg:justify-between items-center gap-12 py-20">
                <div class="text-center lg:text-left space-y-4 max-w-xl">
                    {{-- Using your restyled badge logic --}}
                    <div class="badge-premium mb-2">
                        <div class="badge-premium-dot">
                            <span class="dot-pulse"></span>
                            <span class="dot-ping"></span>
                            <span class="dot-core"></span>
                        </div>
                        <span class="leading-none pt-0.5">The Inner Circle</span>
                    </div>
                    
                    <h3 class="text-4xl md:text-6xl font-black tracking-tighter uppercase italic leading-[0.9]">
                        Join the <span class="text-primary">{{ $site->site_name }}</span> <span class="text-stroke-sm dark:text-stroke-white text-transparent">Family.</span>
                    </h3>
                    <p class="text-[10px] text-muted-foreground font-black uppercase tracking-[0.3em] opacity-70">
                        {{ $site->tagline ?? 'Experience the Essence of Elegance with Us' }}
                    </p>
                </div>

                {{-- Newsletter Form with improved focus states --}}
                <form class="flex w-full md:w-auto gap-0 max-w-md group relative shadow-2xl shadow-primary/5">
                    <input 
                        type="email" 
                        placeholder="SIGNATURE@EMAIL.COM"
                        class="flex-1 py-5 px-8 bg-card border border-border rounded-l-[2rem] text-foreground text-[10px] font-black tracking-widest uppercase placeholder:text-muted-foreground/30 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all"
                        required
                    />
                    <button 
                        type="submit"
                        class="px-10 bg-primary text-primary-foreground font-black uppercase tracking-[0.2em] text-[10px] rounded-r-[2rem] hover:bg-gold-dark transition-all duration-500 active:scale-95 shadow-xl shadow-primary/20">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Main Footer Links --}}
    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="grid grid-cols-2 md:grid-cols-12 gap-16 py-24">

            {{-- Brand & Social --}}
            <div class="col-span-2 md:col-span-4 space-y-10">
                <a wire:navigate href="/" class="inline-block group">
                    <h2 class="text-5xl font-black tracking-tighter uppercase italic group-hover:text-primary transition-all duration-700">
                        {{ $site->site_name }}<span class="text-primary text-lg ml-0.5">.</span>
                    </h2>
                    <div class="h-1 w-8 bg-primary rounded-full mt-2 group-hover:w-full transition-all duration-700 ease-expo"></div>
                </a>
                <p class="text-[11px] leading-loose text-muted-foreground font-bold uppercase tracking-widest max-w-xs opacity-70 italic">
                    {{ $site->footer_about ?? 'Curating the Finest in Beauty & Grooming for the Discerning Nigerian Gentleman.' }}
                </p>
                
                {{-- Social Icons using the Social Links from $site --}}
                <div class="flex gap-4">
                    @foreach($site->social_links as $social)
                    <a href="{{ $social['url'] }}" 
                       target="_blank"
                       class="w-12 h-12 rounded-2xl border border-border flex items-center justify-center text-muted-foreground hover:bg-card hover:text-primary hover:border-primary/50 transition-all duration-500 group shadow-sm">
                        <x-dynamic-component :component="'lucide-' . ($social['platform'] ?? 'link')" class="w-4 h-4 transition-transform group-hover:scale-110" />
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Column: Curation --}}
            <div class="col-span-1 md:col-span-2 space-y-8">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-primary">Curation</h4>
                <ul class="space-y-5">
                    @foreach(['Hair Artistry' => '/hair', 'Fragrance' => '/fragrance', 'Skincare' => '/skincare'] as $label => $url)
                    <li>
                        <a wire:navigate href="{{ $url }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-primary hover:translate-x-2 inline-flex items-center gap-2 transition-all group">
                            <span class="w-0 h-[1px] bg-primary group-hover:w-3 transition-all"></span>
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Column: Concierge (Dynamic Links) --}}
            <div class="col-span-1 md:col-span-3 space-y-8">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-primary">Concierge</h4>
                <ul class="space-y-5">
                    @forelse ( $site->footer_links as $link )
                        <li><a wire:navigate href="{{ $link['url'] }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-primary hover:translate-x-2 inline-flex items-center gap-2 transition-all group">
                            <span class="w-0 h-[1px] bg-primary group-hover:w-3 transition-all"></span>
                            {{ $link['label'] }}
                        </a></li>
                    @empty
                        <li><a wire:navigate href="/orders" class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-primary hover:translate-x-2 inline-block transition-all">Track Order</a></li>
                        <li><a wire:navigate href="/shipping" class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground hover:text-primary hover:translate-x-2 inline-block transition-all">Nationwide Waybill</a></li>
                    @endforelse
                </ul>
            </div>

            {{-- Column: Atelier (The Local Heart) --}}
            <div class="col-span-2 md:col-span-3 space-y-8">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-primary">The Atelier</h4>
                <div class="space-y-6">
                    <a href="https://wa.me/{{ $site->whatsapp_number ?? '234' }}" target="_blank" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-primary hover:opacity-80 transition-all p-4 bg-primary/5 rounded-2xl border border-primary/10">
                        <x-lucide-message-circle class="w-4 h-4" /> 
                        <span>Direct WhatsApp</span>
                    </a>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-muted-foreground leading-loose italic opacity-60">
                        {{ $site->address }}
                    </p>
                </div>
            </div>

        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-border/40 bg-muted/5 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:justify-between items-center gap-8 py-12">

                <div class="flex flex-col items-center md:items-start gap-2">
                    <p class="text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground/60">
                        {{ $site->footer_copyright ?? '© 2026 ' . $site->site_name }}
                    </p>
                    <div class="flex items-center gap-2">
                        <span class="h-1 w-1 bg-primary rounded-full animate-pulse"></span>
                        <p class="text-[8px] font-black uppercase tracking-[0.5em] text-muted-foreground/30">
                            Crafted for the Discerning
                        </p>
                    </div>
                </div>

                {{-- Payment & Security --}}
                <div class="flex flex-wrap justify-center gap-8 items-center">
                    <div class="flex gap-6 opacity-30 hover:opacity-100 transition-opacity duration-700 grayscale hover:grayscale-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/Verve_Logo.svg" class="h-3 dark:invert" alt="Verve">
                        <img src="https://raw.githubusercontent.com/datatrans/payment-logos/main/assets/cards/mastercard.svg" class="h-4 dark:invert" alt="Mastercard">
                        <img src="https://raw.githubusercontent.com/datatrans/payment-logos/main/assets/cards/visa.svg" class="h-3 dark:invert" alt="Visa">
                    </div>
                    
                    <div class="h-6 w-[1px] bg-border/60 hidden md:block"></div>
                    
                    <div class="flex items-center gap-3 px-4 py-2 bg-background/50 rounded-full border border-border shadow-sm group cursor-help">
                        <x-lucide-shield-check class="w-3 h-3 text-primary group-hover:animate-bounce" />
                        <span class="text-[8px] font-black tracking-[0.3em] text-muted-foreground uppercase">Protected by Paystack</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</footer>