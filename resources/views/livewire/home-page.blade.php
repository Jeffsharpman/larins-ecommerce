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

        {{-- Ambient Glow Orbs --}}
        <div class="absolute top-1/4 -left-32 w-[500px] h-[500px] bg-primary/[0.06] dark:bg-primary/[0.04] blur-[120px] rounded-full pointer-events-none animate-pulse-slow"></div>
        <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-primary/[0.04] dark:bg-primary/[0.02] blur-[150px] rounded-full pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/4 w-[450px] h-[450px] bg-secondary/[0.06] dark:bg-secondary/[0.04] blur-[140px] rounded-full pointer-events-none animate-pulse-slow"></div>
        <div class="absolute top-1/3 right-0 w-[300px] h-[300px] bg-secondary/[0.05] dark:bg-secondary/[0.03] blur-[100px] rounded-full pointer-events-none"></div>

        {{-- Decorative Grid Pattern --}}
        <div class="absolute inset-0 pointer-events-none opacity-[0.015] dark:opacity-[0.03]"
             style="background-image: linear-gradient(var(--color-border) 1px, transparent 1px), linear-gradient(90deg, var(--color-border) 1px, transparent 1px); background-size: 80px 80px;">
        </div>

        {{-- Floating Decorative Elements --}}
        <div class="absolute top-[15%] left-[8%] w-3 h-3 rounded-full bg-primary/20 dark:bg-primary/10 animate-ping pointer-events-none" style="animation-duration: 4s;"></div>
        <div class="absolute top-[25%] right-[12%] w-2 h-2 rounded-full bg-secondary/30 dark:bg-secondary/20 animate-ping pointer-events-none" style="animation-duration: 6s; animation-delay: 1s;"></div>
        <div class="absolute bottom-[30%] left-[15%] w-1.5 h-1.5 rounded-full bg-primary/20 dark:bg-primary/10 animate-ping pointer-events-none" style="animation-duration: 5s; animation-delay: 2s;"></div>
        <div class="absolute bottom-[20%] right-[25%] w-2.5 h-2.5 rounded-full bg-secondary/20 dark:bg-secondary/10 animate-ping pointer-events-none" style="animation-duration: 7s; animation-delay: 0.5s;"></div>

        {{-- Diagonal Accent Line --}}
        <div class="absolute top-0 right-0 w-96 h-[1px] bg-gradient-to-r from-transparent via-primary/20 dark:via-primary/10 to-transparent rotate-45 translate-y-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-[1px] bg-gradient-to-r from-transparent via-primary/20 dark:via-primary/10 to-transparent -rotate-45 -translate-y-32 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Column 1: Editorial Copy --}}
            <div class="relative z-10 space-y-10 order-2 lg:order-1">
                {{-- Decorative Corner Accent --}}
                <div class="absolute -top-12 -left-12 w-24 h-24 border-l-2 border-t-2 border-primary/10 dark:border-primary/5 rounded-tl-[3rem] pointer-events-none hidden lg:block"></div>
                <div class="absolute -top-10 -left-10 w-20 h-20 border-r-2 border-b-2 border-secondary/20 dark:border-secondary/10 rounded-br-[2rem] pointer-events-none hidden lg:block"></div>

                <div class="space-y-4">
                    <div class="flex items-center gap-4 animate-fade-in">
                        <span class="h-[1px] w-16 bg-gradient-to-r from-primary to-primary/20"></span>
                        <span class="relative text-[11px] font-black uppercase tracking-[0.5em] text-primary drop-shadow-[0_0_8px_rgba(var(--primary-rgb),0.3)]">
                            <span class="absolute -inset-4 bg-secondary/[0.08] dark:bg-secondary/[0.04] blur-2xl rounded-full"></span>
                            <span class="relative z-10">Established {{ date('Y') }}</span>
                        </span>
                    </div>

                    <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter text-foreground leading-[0.85]">
                        L'Art de <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-foreground via-primary to-foreground drop-shadow-[0_0_12px_rgba(var(--primary-rgb),0.15)] dark:drop-shadow-[0_0_20px_rgba(var(--primary-rgb),0.1)]">
                            L'Acquisition
                        </span>
                    </h1>

                    <p class="max-w-md text-sm md:text-base font-bold text-muted-foreground uppercase tracking-widest leading-relaxed pt-4">
                        Curating a world-class collection of premium essentials. Refined by design, secured by {{ $site->site_name }}.
                    </p>
                </div>

                {{-- Action Group --}}
                <div class="flex flex-wrap items-center gap-6 pt-6">
                    <a wire:navigate href="/shop" class="btn btn-dark btn-xl group overflow-hidden relative shadow-[0_8px_32px_rgba(var(--primary-rgb),0.15)] dark:shadow-[0_8px_32px_rgba(var(--primary-rgb),0.08)] hover:shadow-[0_12px_48px_rgba(var(--primary-rgb),0.25)] dark:hover:shadow-[0_12px_48px_rgba(var(--primary-rgb),0.15)] transition-shadow duration-500">
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
                <div class="pt-12 border-t border-border/60 dark:border-border/30 flex items-center gap-12 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-700">
                    <span class="text-[9px] font-black uppercase tracking-widest text-foreground">Global Logistics</span>
                    <span class="w-2 h-2 rounded-full bg-secondary/30 dark:bg-secondary/20 hidden sm:block"></span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-primary italic font-bold drop-shadow-[0_0_4px_rgba(var(--primary-rgb),0.3)]">{{ $site->currency_code }} SECURED</span>
                    <span class="w-2 h-2 rounded-full bg-secondary/30 dark:bg-secondary/20 hidden sm:block"></span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-foreground">Concierge Support</span>
                </div>
            </div>

            {{-- Column 2: The Visual Archive --}}
            <div class="relative order-1 lg:order-2 group">
                {{-- Multi-layer Glow Effect --}}
                <div class="absolute inset-0 bg-gradient-to-br from-primary/[0.08] to-transparent dark:from-primary/[0.05] blur-[120px] rounded-full scale-75 group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="absolute -inset-4 bg-gradient-to-tr from-secondary/[0.05] to-transparent dark:from-secondary/[0.03] blur-[80px] rounded-full scale-50 group-hover:scale-100 transition-transform duration-1000 delay-150"></div>

                {{-- Decorative Ring Behind Image --}}
                <div class="absolute -inset-8 border border-primary/5 dark:border-primary/[0.03] rounded-[6rem] -rotate-6 group-hover:rotate-0 transition-transform duration-1000 pointer-events-none"></div>
                <div class="absolute -inset-12 border border-primary/[0.03] dark:border-primary/[0.015] rounded-[7rem] -rotate-12 group-hover:rotate-0 transition-transform duration-1000 delay-200 pointer-events-none"></div>

                {{-- Image Container --}}
                <div class="relative aspect-square rounded-[4rem] overflow-hidden border border-border/80 dark:border-border/40 bg-gradient-to-br from-card via-card to-primary/[0.02] dark:from-card dark:via-card dark:to-primary/[0.01] p-8 transition-all duration-700 group-hover:rotate-1 shadow-[0_20px_60px_-20px_rgba(var(--primary-rgb),0.15)] dark:shadow-[0_20px_60px_-20px_rgba(var(--primary-rgb),0.08)] group-hover:shadow-[0_30px_80px_-20px_rgba(var(--primary-rgb),0.25)] dark:group-hover:shadow-[0_30px_80px_-20px_rgba(var(--primary-rgb),0.15)]">
                    {{-- Gradient Overlay Top --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-transparent via-transparent to-primary/[0.03] dark:to-primary/[0.02] pointer-events-none z-10"></div>

                    <img src="https://static.vecteezy.com/system/resources/previews/011/993/278/non_2x/3d-render-online-shopping-bag-using-credit-card-or-cash-for-future-use-credit-card-money-financial-security-on-mobile-3d-application-3d-shop-purchase-basket-retail-store-on-e-commerce-free-png.png" 
                        alt="{{ $site->site_name }} Collection"
                        class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-1000 ease-out relative z-5 drop-shadow-[0_20px_40px_rgba(0,0,0,0.1)] dark:drop-shadow-[0_20px_40px_rgba(0,0,0,0.3)]">

                    {{-- Always-Visible Stats Badge --}}
                    <div class="absolute top-6 left-6 bg-background/90 dark:bg-background/80 backdrop-blur-xl border border-border/60 dark:border-border/40 px-5 py-3 rounded-2xl shadow-card z-20">
                        <p class="text-[7px] font-black uppercase tracking-[0.3em] text-primary">Curated</p>
                        <p class="text-xs font-black italic text-foreground">{{ $site->currency_symbol }}24.5M+</p>
                    </div>

                    {{-- Trust Badge --}}
                    <div class="absolute top-6 right-6 bg-primary/10 dark:bg-primary/20 backdrop-blur-xl border border-primary/20 dark:border-primary/30 px-4 py-2 rounded-2xl z-20">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[7px] font-black uppercase tracking-[0.2em] text-primary">Live</span>
                        </div>
                    </div>

                    {{-- Floating Stat Badge (hover reveal) --}}
                    <div class="absolute bottom-8 right-8 bg-card/80 dark:bg-card/90 backdrop-blur-xl border border-border/60 dark:border-border/40 p-5 rounded-2xl shadow-card opacity-0 translate-y-10 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-700 delay-300 z-20">
                        <p class="text-[8px] font-black uppercase tracking-widest text-primary mb-1">Live Inventory</p>
                        <p class="text-lg font-black italic tracking-tighter text-foreground">{{ $site->currency_symbol }}24.5M+</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Brand Section --}}
    <section class="py-32 bg-background relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -z-10"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-secondary/[0.06] dark:bg-secondary/[0.04] rounded-full blur-[120px] -z-10"></div>

        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-3 gap-16 items-center">
                <div class="lg:sticky lg:top-32 h-fit">
                    <div class="flex items-center gap-3 text-primary mb-6">
                        <div class="w-10 h-[1px] bg-gradient-to-r from-primary to-secondary"></div>
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

    {{-- Featured Products Section --}}
    @if($featuredProducts->count() > 0)
        <section class="py-32 bg-background relative overflow-hidden">
            <div class="absolute top-0 left-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -z-10"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-secondary/[0.06] dark:bg-secondary/[0.04] rounded-full blur-[120px] -z-10"></div>
            
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-end justify-between mb-16">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-[1px] bg-gradient-to-r from-primary to-secondary"></div>
                            <span class="text-[10px] font-black uppercase tracking-[0.4em] text-primary">Featured Collection</span>
                            <div class="w-4 h-[1px] bg-secondary/30"></div>
                        </div>
                        <h2 class="text-5xl md:text-6xl font-black italic tracking-tighter uppercase leading-[0.9] text-foreground">
                            Editor's <span class="text-primary">Picks</span>
                        </h2>
                    </div>
                    <a wire:navigate href="/products" 
                        class="hidden md:flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground hover:text-primary transition-colors group">
                        View All
                        <x-lucide-arrow-right class="w-4 h-4 group-hover:translate-x-2 transition-transform" />
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredProducts as $product)
                        <x-card.product-card :product="$product" :key="'featured-' . $product->id" />
                    @endforeach
                </div>

                <a wire:navigate href="/products" class="btn btn-primary btn-lg md:hidden w-full">
                    View All Products
                    <x-lucide-arrow-right class="w-4 h-4" />
                </a>
            </div>
        </section>
    @endif

    {{-- Reviews Section --}}
    <section class="py-24 bg-background relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-secondary/[0.04] dark:bg-secondary/[0.02] rounded-full blur-[120px] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-3 gap-12">
                <div class="lg:sticky lg:top-24 h-fit">
                    <h2 class="text-5xl font-black italic tracking-tighter uppercase leading-none mb-6 text-foreground">
                        Real <br /><span class="text-primary">Stories</span>
                    </h2>
                    <div class="flex items-center gap-2 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <x-lucide-star class="w-5 h-5 {{ $i % 2 == 0 ? 'fill-primary text-primary' : 'fill-secondary text-secondary' }}" />
                        @endfor
                    </div>
                    <p class="text-muted-foreground font-medium mb-8">
                        Join the thousands who have transformed their routine with {{ $site->site_name }}.
                    </p>
                    <a wire:navigate href="/reviews"
                        class="btn btn-outline btn-lg w-full">
                        View All Reviews
                    </a>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    @forelse ($reviews as $review)
                        <div class="bg-card border border-border/40 p-8 rounded-[2rem] hover:border-primary/40 transition-all shadow-soft group">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $review['user']['avatar'] }}"
                                        class="w-14 h-14 rounded-2xl object-cover ring-4 ring-muted group-hover:ring-primary/20 transition-all">
                                    <div>
                                        <h4 class="font-bold text-foreground">{{ $review['user']['name'] }}</h4>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-muted-foreground uppercase tracking-widest">
                                                {{ $review['user']['role'] }}
                                            </span>
                                            @if($review['product'])
                                                <span class="text-[8px] text-primary">|</span>
                                                <a wire:navigate href="/product/{{ $review['product']['slug'] }}" class="text-[10px] text-primary hover:underline">
                                                    {{ $review['product']['name'] }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <x-lucide-star class="w-3 h-3 {{ $i <= $review['rating'] ? 'text-amber-400 fill-amber-400' : 'text-muted-foreground/30' }}" />
                                        @endfor
                                    </div>
                                    <span class="text-[10px] font-black uppercase text-muted-foreground bg-muted px-3 py-1 rounded-full">
                                        {{ $review['created_at']->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            @if($review['title'])
                                <h5 class="font-black italic uppercase tracking-tight text-sm mb-3">{{ $review['title'] }}</h5>
                            @endif
                            <p class="text-sm text-foreground/80 leading-relaxed">
                                {{ $review['comment'] }}
                            </p>
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