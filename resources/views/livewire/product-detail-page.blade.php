<div class="min-h-screen bg-white dark:bg-[#050505] text-foreground transition-colors duration-700">
    {{-- Ambient Light Leak --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>

    {{-- Minimalist Navigation --}}
    <div class="border-b border-border/40 py-6 backdrop-blur-md sticky top-0 z-50 bg-white/80 dark:bg-[#050505]/80">
        <div class="max-w-7xl mx-auto px-8 flex justify-between items-center">
            <nav class="flex items-center gap-4 text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground">
                <a href="/" wire:navigate class="hover:text-primary transition-colors">Maison</a>
                <span class="opacity-20 text-[14px] leading-none">/</span>
                <a href="/categories" wire:navigate class="hover:text-primary transition-colors">Archive</a>
                <span class="opacity-20 text-[14px] leading-none">/</span>
                <span class="text-foreground tracking-[0.2em] italic">{{ $product->name }}</span>
            </nav>
            
            <div class="hidden md:flex items-center gap-6">
                <span class="text-[10px] font-black uppercase tracking-widest text-primary italic">Status: Verified Inventory</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-20 items-start">

            {{-- Image Sculpture Gallery --}}
            <div class="lg:col-span-7 space-y-10" x-data="{ mainImage: '{{ url('storage/' . $product->images[0]) }}' }">
                <div class="relative aspect-[4/5] bg-muted/20 rounded-[3.5rem] overflow-hidden border border-border/60 shadow-[0_40px_80px_-15px_rgba(0,0,0,0.1)] group">
                    <img :src="mainImage" alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110" />

                    {{-- Dynamic Watermark --}}
                    <div class="absolute bottom-10 left-10 overflow-hidden">
                        <p class="text-[8rem] font-black uppercase tracking-tighter text-white/10 dark:text-white/5 leading-none translate-y-4">
                            {{ substr($product->name, 0, 1) }}
                        </p>
                    </div>

                    {{-- Limited Label --}}
                    <div class="absolute top-10 right-10">
                        <div class="bg-foreground/90 text-background px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-[0.3em] backdrop-blur-md shadow-2xl">
                            Edition: 001/Archive
                        </div>
                    </div>
                </div>

                {{-- Horizontal Slide Strip --}}
                <div class="flex gap-6 overflow-x-auto pb-6 no-scrollbar snap-x">
                    @foreach ($product->images as $image)
                        <button @click="mainImage = '{{ url('storage/' . $image) }}'"
                            class="flex-shrink-0 w-28 h-36 bg-muted/30 rounded-3xl overflow-hidden border-2 transition-all duration-500 snap-start"
                            :class="mainImage === '{{ url('storage/' . $image) }}' ? 'border-primary ring-8 ring-primary/5 scale-95' : 'border-transparent grayscale opacity-40 hover:opacity-100 hover:grayscale-0'">
                            <img src="{{ url('storage/' . $image) }}" class="w-full h-full object-cover" />
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Specifications Section --}}
            <div class="lg:col-span-5 space-y-12 lg:sticky lg:top-40">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <p class="text-[11px] font-black uppercase tracking-[0.5em] text-primary">
                            {{ $product->brand->name ?? 'Maison Verified' }}
                        </p>
                        <h1 class="text-6xl md:text-7xl font-black tracking-tighter text-foreground leading-[0.85] italic">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <div class="flex items-baseline gap-6">
                        <span class="text-5xl font-black tracking-tighter text-foreground italic">
                            {{ Number::currency($product->price, 'NGN') }}
                        </span>
                        @if ($product->old_price)
                            <span class="text-xl text-muted-foreground/40 line-through font-bold decoration-primary/40">
                                {{ Number::currency($product->old_price, 'NGN') }}
                            </span>
                        @endif
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="h-[1px] flex-1 bg-border/60"></div>
                            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-muted-foreground">Manifesto</span>
                            <div class="h-[1px] w-8 bg-border/60"></div>
                        </div>
                        <div class="text-[12px] text-muted-foreground leading-relaxed font-bold uppercase tracking-[0.2em] opacity-80 border-l-4 border-primary/10 pl-8 italic">
                            {!! str($product->description)->markdown() !!}
                        </div>
                    </div>
                </div>

                {{-- Acquisition Controls --}}
                <div class="space-y-10 pt-10">
                    <div class="flex items-center gap-6">
                        {{-- Boutique Qty --}}
                        <div class="flex items-center bg-muted/20 rounded-full p-2 border border-border shadow-inner">
                            <button wire:click="decreaseQty" class="w-14 h-14 flex items-center justify-center hover:text-primary transition-colors group">
                                <x-lucide-minus class="w-4 h-4 transition-transform group-active:scale-75" />
                            </button>
                            <span class="w-12 text-center font-black text-sm tracking-tighter">{{ $quantity }}</span>
                            <button wire:click="increaseQty" class="w-14 h-14 flex items-center justify-center hover:text-primary transition-colors group">
                                <x-lucide-plus class="w-4 h-4 transition-transform group-active:scale-125" />
                            </button>
                        </div>

                        {{-- Heart/Wish --}}
                        <button class="w-20 h-20 border border-border rounded-[2rem] flex items-center justify-center hover:bg-primary/5 hover:border-primary/40 transition-all duration-500 group">
                            <x-lucide-heart class="w-6 h-6 group-hover:fill-primary group-hover:text-primary transition-all duration-500 stroke-[1.2]" />
                        </button>
                    </div>

                    <button wire:click="addToCart({{ $product->id }})" wire:loading.attr="disabled"
                        class="w-full bg-foreground text-background dark:bg-primary dark:text-background py-8 rounded-[2rem] font-black uppercase tracking-[0.5em] text-[11px] hover:scale-[1.02] active:scale-[0.98] transition-all duration-700 shadow-[0_30px_60px_-15px_rgba(var(--primary),0.3)] flex items-center justify-center gap-6 group overflow-hidden relative">
                        <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-700"></div>
                        
                        <x-lucide-shopping-bag wire:loading.remove class="w-5 h-5 relative z-10 transition-transform group-hover:rotate-12" />
                        <span wire:loading class="animate-spin rounded-full h-5 w-5 border-2 border-current border-t-transparent relative z-10"></span>
                        <span class="relative z-10">Commit to Archive</span>
                    </button>
                </div>

                {{-- Authenticity Protocol --}}
                <div class="pt-12 border-t border-border/40">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="flex items-center gap-6 group">
                            <div class="w-12 h-12 bg-muted/20 rounded-2xl flex items-center justify-center border border-border group-hover:border-primary/40 transition-colors">
                                <x-lucide-shield-check class="w-5 h-5 text-primary stroke-[1.5]" />
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase tracking-widest">Protocol: Originality</p>
                                <p class="text-[9px] text-muted-foreground uppercase tracking-widest opacity-60">Verified molecular composition & craftsmanship.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 group">
                            <div class="w-12 h-12 bg-muted/20 rounded-2xl flex items-center justify-center border border-border group-hover:border-primary/40 transition-colors">
                                <x-lucide-truck class="w-5 h-5 text-primary stroke-[1.5]" />
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-black uppercase tracking-widest">Protocol: Logistics</p>
                                <p class="text-[9px] text-muted-foreground uppercase tracking-widest opacity-60">Priority global transit with signature authentication.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>