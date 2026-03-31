<div>
    @if(session('error'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-6">
            <div class="bg-destructive text-destructive-foreground px-6 py-4 rounded-2xl shadow-card font-bold text-sm flex items-center justify-between">
                {{ session('error') }}
                <button onclick="this.parentElement.remove()" class="opacity-50 hover:opacity-100">&times;</button>
            </div>
        </div>
    @endif

    {{-- Hero Section --}}
    <section class="relative w-full min-h-[80vh] flex items-center pt-20 pb-32 px-6 lg:px-12 overflow-hidden bg-background">

        {{-- Background Texture & Glow (Derived from Primary) --}}
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-primary/[0.05] dark:bg-primary/[0.03] blur-[150px] rounded-full -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Column 1: Editorial Copy --}}
            <div class="relative z-10 space-y-10 order-2 lg:order-1">
                <div class="space-y-4">
                    <div class="flex items-center gap-4 animate-fade-in">
                        <span class="h-[1px] w-12 bg-primary"></span>
                        <span class="text-[11px] font-black uppercase tracking-[0.5em] text-primary">
                            Established {{ date('Y') }}
                        </span>
                    </div>

                    <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter text-foreground leading-[0.85]">
                        L’Art de <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-foreground via-primary to-foreground">
                            L’Acquisition
                        </span>
                    </h1>

                    <p class="max-w-md text-sm md:text-base font-bold text-muted-foreground uppercase tracking-widest leading-relaxed pt-4">
                        Curating a world-class collection of premium essentials. Refined by design, secured by {{ $site->site_name }}.
                    </p>
                </div>

                {{-- Action Group --}}
                <div class="flex flex-wrap items-center gap-6 pt-6">
                    <a wire:navigate href="/shop"
                        class="group relative px-10 py-6 bg-foreground text-background rounded-full text-[11px] font-black uppercase tracking-[0.3em] overflow-hidden transition-all duration-500 hover:scale-105 shadow-card">
                        <span class="relative z-10">Explore Collection</span>
                        <div class="absolute inset-0 bg-primary translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>

                    <a wire:navigate href="/about"
                        class="group flex items-center gap-4 text-[11px] font-black uppercase tracking-[0.3em] text-muted-foreground hover:text-primary transition-colors duration-300">
                        <span>The Maison</span>
                        <x-lucide-arrow-right class="w-4 h-4 transition-transform group-hover:translate-x-2 text-primary" />
                    </a>
                </div>

                {{-- Trust Indicators --}}
                <div class="pt-12 border-t border-border flex items-center gap-12 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-700">
                    <span class="text-[9px] font-black uppercase tracking-widest text-foreground">Global Logistics</span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-primary italic font-bold">{{ $site->currency_code }} SECURED</span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-foreground">Concierge Support</span>
                </div>
            </div>

            {{-- Column 2: The Visual Archive --}}
            <div class="relative order-1 lg:order-2 group">
                <div class="absolute inset-0 bg-primary/10 blur-[120px] rounded-full scale-75 group-hover:scale-100 transition-transform duration-1000"></div>

                {{-- Image Container --}}
                <div class="relative aspect-square rounded-[4rem] overflow-hidden border border-border bg-card p-8 transition-transform duration-700 group-hover:rotate-1 shadow-card">
                    <img src="https://static.vecteezy.com/system/resources/previews/011/993/278/non_2x/3d-render-online-shopping-bag-using-credit-card-or-cash-for-future-use-credit-card-money-financial-security-on-mobile-3d-application-3d-shop-purchase-basket-retail-store-on-e-commerce-free-png.png" 
                        alt="{{ $site->site_name }} Collection"
                        class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-1000 ease-out">

                    {{-- Floating Stat Badge --}}
                    <div class="absolute bottom-12 right-12 bg-card/80 backdrop-blur-xl border border-border p-6 rounded-3xl shadow-card opacity-0 translate-y-10 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-700 delay-300">
                        <p class="text-[8px] font-black uppercase tracking-widest text-primary mb-1">Live Inventory</p>
                        <p class="text-2xl font-black italic tracking-tighter text-foreground">{{ $site->currency_symbol }}24.5M+</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Brand Section --}}
    <section class="py-32 bg-background relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-3 gap-16 items-center">
                <div class="lg:sticky lg:top-32 h-fit">
                    <div class="flex items-center gap-3 text-primary mb-6">
                        <div class="w-10 h-[1px] bg-primary"></div>
                        <span class="text-[10px] font-black uppercase tracking-[0.4em]">Elite Partners</span>
                    </div>

                    <h2 class="text-5xl md:text-6xl font-black italic tracking-tighter uppercase leading-[0.9] mb-8 text-foreground">
                        The <br />
                        <span class="text-primary">Curated</span> <br />
                        <span class="text-transparent font-outline-2 dark:font-outline-white">Iconic</span> List
                    </h2>

                    <p class="text-muted-foreground font-medium mb-10 max-w-xs">
                        We only partner with brands that meet our strict standards for quality and ethical luxury.
                    </p>

                    <a wire:navigate href="/brands"
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full border border-border hover:bg-primary hover:text-primary-foreground transition-all duration-500 group">
                        <x-lucide-move-right class="w-6 h-6 group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>

                <div class="lg:col-span-2">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 lg:gap-8">
                        @forelse ($brands as $index => $brand)
                            <div class="{{ $index % 2 == 1 ? 'lg:translate-y-12' : '' }} transition-transform duration-700">
                                <x-card.brand-card :brand="$brand" :key="'brand-' . $brand['id']" />
                            </div>
                        @empty
                            <div class="col-span-full">
                                <x-card.empty-brand-card-state />
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Reviews Section --}}
    <section class="py-24 bg-background">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-3 gap-12">
                <div class="lg:sticky lg:top-24 h-fit">
                    <h2 class="text-5xl font-black italic tracking-tighter uppercase leading-none mb-6 text-foreground">
                        Real <br /><span class="text-primary">Stories</span>
                    </h2>
                    <div class="flex items-center gap-2 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <x-lucide-star class="w-5 h-5 fill-primary text-primary" />
                        @endfor
                    </div>
                    <p class="text-muted-foreground font-medium mb-8">
                        Join the thousands who have transformed their routine with {{ $site->site_name }}.
                    </p>
                    <button class="w-full py-4 rounded-xl border-2 border-border font-bold hover:bg-muted text-foreground transition-all">
                        Write a Review
                    </button>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    @forelse ($reviews as $review)
                        <div class="bg-card border border-border/40 p-8 rounded-[2rem] hover:border-primary/40 transition-all shadow-soft group">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $review['user']['avatar'] ?? 'https://i.pravatar.cc/100' }}"
                                        class="w-14 h-14 rounded-2xl object-cover ring-4 ring-muted group-hover:ring-primary/20 transition-all">
                                    <div>
                                        <h4 class="font-bold text-foreground">{{ $review['user']['name'] }}</h4>
                                        <p class="text-xs text-muted-foreground uppercase tracking-widest">
                                            {{ $review['user']['role'] ?? 'Verified Buyer' }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-black uppercase text-muted-foreground bg-muted px-3 py-1 rounded-full">
                                    {{ $review['created_at']->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-lg text-foreground/80 italic leading-relaxed">
                                "{{ $review['comment'] }}"
                            </p>
                            <div class="flex items-center gap-6 mt-8 pt-6 border-t border-border/30">
                                <button class="flex items-center gap-2 text-xs font-bold text-muted-foreground hover:text-primary transition-colors">
                                    <x-lucide-thumbs-up class="w-4 h-4" /> 
                                    Helpful ({{ $review['likes_count'] ?? 0 }})
                                </button>
                                <button class="flex items-center gap-2 text-xs font-bold text-muted-foreground hover:text-primary transition-colors">
                                    <x-lucide-message-circle class="w-4 h-4" /> 
                                    Reply
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-20 text-muted-foreground border border-dashed border-border rounded-3xl">
                            No voices here yet. Be the first!
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>