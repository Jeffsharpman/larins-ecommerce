<div class="max-w-7xl mx-auto px-6 py-20 selection:bg-primary/30 selection:text-foreground bg-background">
    
    {{-- Hero Section: The Statement --}}
    <div class="relative text-center mb-32">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            {{-- Glow follows primary color --}}
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[140px] opacity-60"></div>
        </div>
        
        <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full border border-primary/20 bg-primary/5 text-primary text-[10px] font-black uppercase tracking-[0.4em] mb-10 animate-fade-in">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
            </span>
            Est. 2025 • Lagos, NG
        </div>
        
        <h1 class="text-7xl md:text-9xl font-black tracking-tighter text-foreground mb-10 italic uppercase leading-[0.85]">
            Redefining <br>
            <span class="text-primary not-italic inline-block hover:scale-105 transition-transform duration-500 cursor-default">Elegance.</span>
        </h1>
        
        <p class="text-xl md:text-2xl text-muted-foreground max-w-3xl mx-auto leading-relaxed font-medium tracking-tight">
            {{ $site->site_name }} is an intersection of heritage and high-science. We curate the art of self-care through a lens of uncompromising luxury.
        </p>
    </div>

    {{-- Brand Story: Asymmetric Grid --}}
    <div class="grid gap-24 lg:grid-cols-12 items-center mb-40">
        <div class="lg:col-span-7 relative group">
            <div class="absolute -inset-6 bg-gradient-to-tr from-primary/20 to-transparent rounded-[3rem] blur-3xl opacity-0 group-hover:opacity-100 transition duration-1000"></div>
            <div class="relative aspect-[16/10] overflow-hidden rounded-[2.5rem] border border-border bg-muted shadow-card">
                <img src="https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=1200" alt="Maison {{ $site->site_name }}" class="w-full h-full object-cover grayscale brightness-75 hover:grayscale-0 hover:brightness-100 transition-all duration-1000 scale-105 group-hover:scale-100" />
                <div class="absolute inset-0 bg-gradient-to-t from-background/80 via-transparent to-transparent"></div>
                <div class="absolute top-10 right-10">
                    <div class="px-4 py-4 rounded-full bg-card/20 backdrop-blur-md border border-border/50">
                         <x-lucide-crown class="w-6 h-6 text-foreground" />
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 space-y-10">
            <div class="inline-flex items-center gap-4">
                <div class="h-[1px] w-12 bg-primary"></div>
                <span class="text-primary text-[10px] font-black uppercase tracking-[0.4em]">Our Genesis</span>
            </div>
            <h2 class="text-5xl font-black tracking-tighter text-foreground uppercase italic leading-none">Crafted from <br>Pure Passion</h2>
            <div class="space-y-8 text-muted-foreground text-lg leading-relaxed font-medium">
                <p>
                    Born in the vibrant heart of <span class="text-foreground border-b-2 border-primary/30">Lagos</span>, {{ $site->site_name }} was founded to dismantle the compromise between ethical sourcing and elite performance.
                </p>
                <p>
                    We believe luxury should be felt, not just seen. Every ingredient is a testament to our obsession with purity, potency, and the profound power of nature.
                </p>
                <div class="flex flex-wrap gap-6 pt-6">
                    @foreach(['Purity', 'Power', 'Prestige'] as $trait)
                        <div class="flex items-center gap-2">
                             <x-lucide-check class="w-4 h-4 text-primary" />
                             <span class="text-[10px] font-black uppercase tracking-widest text-foreground">{{ $trait }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Core Values --}}
    <div class="mb-40">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-xl">
                <h2 class="text-[10px] font-black uppercase tracking-[0.5em] text-primary mb-6">Manifesto</h2>
                <p class="text-4xl md:text-5xl font-black text-foreground uppercase italic leading-none">What We Stand For</p>
            </div>
            <p class="text-muted-foreground uppercase text-[9px] font-black tracking-widest border-b border-border pb-2">Scroll to explore</p>
        </div>
        
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            @php
                $values = [
                    ['icon' => 'shield-check', 'title' => 'The Gold Standard', 'desc' => 'Hand-picked botanical extracts that exceed international safety benchmarks.'],
                    ['icon' => 'leaf', 'title' => 'Conscious Luxury', 'desc' => 'Sustainability integrated into our DNA, from harvest to your vanity.'],
                    ['icon' => 'users', 'title' => 'Pan-African Beauty', 'desc' => 'Formulas engineered for the diverse radiance of every skin and hair profile.'],
                    ['icon' => 'eye', 'title' => 'Radical Clarity', 'desc' => 'Full ingredient transparency. No secrets, just visible transformation.']
                ];
            @endphp

            @foreach($values as $value)
            <div class="p-10 rounded-[3rem] border border-border/40 bg-card hover:bg-background hover:shadow-card transition-all duration-500 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/20 transition-colors"></div>
                <div class="w-14 h-14 bg-muted rounded-[1.5rem] flex items-center justify-center mb-8 group-hover:rotate-12 transition-transform duration-500">
                    <x-dynamic-component :component="'lucide-' . $value['icon']" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-black uppercase tracking-tight mb-4 text-foreground">{{ $value['title'] }}</h3>
                <p class="text-sm text-muted-foreground leading-relaxed font-medium">{{ $value['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="relative overflow-hidden rounded-[4rem] bg-foreground text-background py-24 px-12 mb-40">
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-primary/30 rounded-full blur-[120px] opacity-40"></div>
        
        <div class="grid gap-16 md:grid-cols-4 relative z-10">
            @foreach([
                ['stat' => '50K+', 'label' => 'Global Patrons'],
                ['stat' => '100%', 'label' => 'Organic Origin'],
                ['stat' => '4.9', 'label' => 'Client Rating'],
                ['stat' => '24h', 'label' => 'Concierge Care']
            ] as $item)
            <div class="text-center group">
                <div class="text-6xl font-black tracking-tighter mb-4 text-primary italic transition-transform group-hover:scale-110 duration-500">{{ $item['stat'] }}</div>
                <div class="text-[10px] font-black uppercase tracking-[0.4em] opacity-50 group-hover:opacity-100 transition-opacity">{{ $item['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Final Call --}}
    <div class="relative group">
        {{-- Border follows primary gradient --}}
        <div class="absolute -inset-1 bg-gradient-to-r from-primary via-primary/50 to-primary rounded-[3.5rem] blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
        <div class="relative bg-card border border-border rounded-[3rem] p-16 md:p-24 text-center space-y-10 backdrop-blur-sm">
            <h2 class="text-5xl md:text-7xl font-black uppercase tracking-tighter italic leading-none text-foreground">
                Join the <br> <span class="text-primary not-italic">Inner Circle</span>
            </h2>
            <p class="text-muted-foreground max-w-2xl mx-auto text-xl font-medium leading-relaxed">
                Step into the world of Maison {{ $site->site_name }}. Receive exclusive access to limited drops and private concierge events.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center pt-6">
                <a wire:navigate href="/shop" class="w-full sm:w-auto px-12 py-6 bg-primary text-primary-foreground rounded-full font-black uppercase tracking-[0.3em] text-[10px] hover:shadow-card transition-all active:scale-95">
                    Explore Collection
                </a>
                <a href="/contact" class="w-full sm:w-auto px-12 py-6 border border-border rounded-full font-black uppercase tracking-[0.3em] text-[10px] hover:bg-muted transition-all text-foreground">
                    Private Specialist
                </a>
            </div>
        </div>
    </div>
</div>