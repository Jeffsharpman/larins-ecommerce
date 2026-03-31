<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="text-center mb-16 relative">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="w-64 h-64 bg-primary/5 rounded-full blur-3xl mx-auto translate-y-[-50%]"></div>
        </div>
        <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/10 rounded-3xl rotate-12 mb-8 border border-primary/20">
            <x-lucide-heart class="w-10 h-10 text-primary -rotate-12 fill-primary/20" />
        </div>
        <h1 class="text-5xl font-black tracking-tighter uppercase italic mb-4">
            Your <span class="text-primary text-stroke-sm">Wishlist</span>
        </h1>
        <p class="text-muted-foreground max-w-xl mx-auto font-medium">
            A curated collection of your future essentials. Items saved here will wait for your return.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        <div class="bg-card border border-border/50 p-6 rounded-[2rem] flex items-center gap-5 group hover:border-primary/50 transition-all">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                <x-lucide-package class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Items Saved</p>
                <h4 class="text-2xl font-black" id="wishlistCount">04</h4>
            </div>
        </div>
        <div class="bg-card border border-border/50 p-6 rounded-[2rem] flex items-center gap-5 group hover:border-primary/50 transition-all">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                {{-- <x-lucide-naira-sign class="w-7 h-7"> --}}
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Total Value</p>
                <h4 class="text-2xl font-black" id="wishlistTotal">₦142,500</h4>
            </div>
        </div>
        <div class="bg-card border border-border/50 p-6 rounded-[2rem] flex items-center gap-5 group hover:border-primary/50 transition-all">
            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                <x-lucide-trending-up class="w-7 h-7" />
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">Price Drops</p>
                <h4 class="text-2xl font-black text-green-500">02</h4>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-10 border-b border-border pb-8">
        <div class="flex bg-muted/50 p-1.5 rounded-xl border border-border">
            <button class="px-5 py-2 text-xs font-black uppercase tracking-wider bg-background shadow-sm rounded-lg text-primary transition-all">Latest</button>
            <button class="px-5 py-2 text-xs font-black uppercase tracking-wider text-muted-foreground hover:text-foreground transition-all">Price</button>
            <button class="px-5 py-2 text-xs font-black uppercase tracking-wider text-muted-foreground hover:text-foreground transition-all">Popular</button>
        </div>
        <button id="clearWishlist" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-destructive hover:opacity-80 transition-opacity">
            <x-lucide-trash-2 class="w-4 h-4" />
            Clear Collection
        </button>
    </div>

    <div id="wishlistContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="group relative bg-card border border-border/40 rounded-[2.5rem] overflow-hidden hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-2 transition-all duration-500">
            <div class="relative aspect-[4/5] overflow-hidden bg-muted">
                <img src="https://images.unsplash.com/photo-1620916566398-39f1143af7be?q=80&w=1000&auto=format&fit=crop" 
                     alt="Product" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                
                <div class="absolute top-5 right-5 flex flex-col gap-3 translate-x-12 group-hover:translate-x-0 transition-transform duration-500">
                    <button class="w-10 h-10 bg-background/90 backdrop-blur-md rounded-full flex items-center justify-center text-destructive shadow-lg hover:bg-destructive hover:text-white transition-all">
                        <x-lucide-x class="w-5 h-5" />
                    </button>
                </div>

                <div class="absolute inset-x-0 bottom-0 p-6 translate-y-full group-hover:translate-y-0 transition-transform duration-500 bg-gradient-to-t from-black/80 to-transparent">
                    <button class="w-full py-4 bg-primary text-primary-foreground font-black uppercase tracking-tighter italic rounded-2xl flex items-center justify-center gap-3 hover:scale-[1.02] active:scale-95 transition-all">
                        <x-lucide-shopping-bag class="w-5 h-5" />
                        Move to Bag
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-1">Serum</p>
                        <h3 class="font-bold text-foreground leading-tight">Advanced Glow Complex</h3>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-border/50">
                    <div class="flex flex-col">
                        <span class="text-lg font-black italic tracking-tighter">₦45,000</span>
                        <span class="text-[10px] text-muted-foreground line-through font-bold">₦52,000</span>
                    </div>
                    <div class="px-3 py-1 bg-green-500/10 text-green-500 text-[10px] font-black rounded-lg uppercase">
                        -15%
                    </div>
                </div>
            </div>
        </div>
        
        </div>

    <div id="wishlistEmpty" class="hidden flex-col items-center justify-center py-32 text-center">
        <div class="w-32 h-32 bg-muted rounded-full flex items-center justify-center mb-8 border-4 border-dashed border-border/50">
            <x-lucide-heart-off class="w-12 h-12 text-muted-foreground" />
        </div>
        <h2 class="text-3xl font-black uppercase tracking-tighter italic mb-4">Nothing Saved Yet</h2>
        <p class="text-muted-foreground max-w-xs mx-auto mb-10">Your heart is currently empty. Explore the shop to find items worth saving.</p>
        <a href="/shop" class="px-10 py-4 bg-foreground text-background font-black uppercase tracking-widest rounded-full hover:bg-primary hover:text-white transition-all">
            Go Shopping
        </a>
    </div>
</div>