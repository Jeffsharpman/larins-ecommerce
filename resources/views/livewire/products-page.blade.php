<div class="min-h-screen bg-background text-foreground transition-colors duration-500 selection:bg-gold/20">
  <div class="max-w-7xl mx-auto px-6 py-16">

    {{-- Header Section: Editorial Title --}}
    <div class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8 border-b border-border pb-12">
      <div class="text-center md:text-left relative">
        <div
          class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full 
            bg-primary/10 border border-primary/20 
            text-primary text-[9px] font-black uppercase tracking-[0.3em] mb-6 
            shadow-[0_0_20px_-5px_var(--color-primary)]">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-40"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
          </span>
          Premium Selection
        </div>
        <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter uppercase leading-[0.8]">
          All <span class="text-primary text-stroke-sm dark:text-stroke-white">Products.</span>
        </h1>
        <p class="mt-6 text-muted-foreground font-medium max-w-md italic opacity-80">
          "Curated beauty and lifestyle essentials designed to elevate your everyday elegance through a prestige lens."
        </p>
      </div>

      <div class="hidden md:block text-right">
        <div class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground mb-2">Inventory Status</div>
        <span class="text-5xl font-black italic tracking-tighter text-muted-foreground/10 uppercase">
          {{ $products->total() }} Items
        </span>
      </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-16">

      {{-- Filter Sidebar --}}
      <aside class="hidden lg:block w-80 flex-shrink-0">
    <div class="sticky top-28 space-y-10 bg-card/40 backdrop-blur-xl p-10 rounded-[3rem] border border-border shadow-2xl shadow-primary/5 transition-colors duration-500">

        {{-- Header: Refine --}}
        <div class="flex items-center justify-between pb-6 border-b border-border/60">
            <div class="flex items-center gap-3">
                <x-lucide-sliders-horizontal class="w-4 h-4 text-primary" />
                <h3 class="text-[11px] font-black uppercase tracking-[0.2em] italic">Refine</h3>
            </div>
            <button wire:click="resetFilters"
                class="text-[9px] font-black uppercase text-muted-foreground hover:text-primary transition-all border-b border-transparent hover:border-primary pb-0.5">
                Reset Archive
            </button>
        </div>

        {{-- Status Toggles --}}
        <div class="space-y-6">
            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 mb-6">Status Archive</h4>
            <div class="space-y-5">
                @foreach (['is_featured' => ['Featured', 'primary'], 'on_sale' => ['On Sale', 'primary']] as $model => $meta)
                    <label class="flex items-center justify-between group cursor-pointer">
                        <span class="text-sm font-bold text-foreground/70 group-hover:text-foreground transition-all italic tracking-tight">
                            {{ $meta[0] }}
                        </span>
                        <div class="relative flex items-center">
                            <input type="checkbox" wire:model.live="{{ $model }}" class="peer sr-only" />
                            {{-- Dynamic Toggle Background --}}
                            <div class="w-11 h-6 bg-muted rounded-full peer-checked:bg-primary transition-all duration-500 ease-expo shadow-inner"></div>
                            {{-- Floating Knob --}}
                            <div class="absolute left-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-all duration-500 ease-expo shadow-md"></div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Price Limit Slider --}}
        <div class="space-y-6">
            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 mb-2">Price Threshold</h4>
            <div class="space-y-5">
                <input type="range" wire:model.live="price_range" min="0" max="5000000" step="10000"
                    class="w-full h-1 bg-muted rounded-lg appearance-none cursor-pointer accent-primary transition-all" />
                
                <div class="flex justify-between items-center p-5 bg-background/40 rounded-2xl border border-border/60 shadow-inner group hover:border-primary/30 transition-colors">
                    <span class="text-[9px] font-black text-muted-foreground uppercase tracking-widest">Limit</span>
                    <span class="text-lg font-black italic tracking-tighter text-primary">
                        ₦{{ number_format($price_range) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Multi-Select: Brands & Categories --}}
        @foreach (['Brands' => $brands, 'Categories' => $categories] as $label => $collection)
            <div class="space-y-5">
                <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 mb-4">
                    {{ $label }}
                </h4>
                <div class="space-y-3 max-h-56 overflow-y-auto custom-scrollbar pr-4">
                    @forelse ($collection as $item)
                        <label class="flex items-center group cursor-pointer">
                            <div class="relative flex items-center">
                                <input type="checkbox" value="{{ $item->id }}"
                                    wire:model.live="selected_{{ strtolower($label) }}"
                                    class="w-5 h-5 rounded-lg border-border text-primary focus:ring-primary/20 bg-background transition-all shadow-sm cursor-pointer" />
                            </div>
                            <span class="ml-4 text-[11px] font-bold text-foreground/60 group-hover:text-primary transition-all uppercase tracking-widest">
                                {{ $item->name }}
                            </span>
                        </label>
                    @empty
                        <p class="text-[9px] italic text-muted-foreground opacity-50">Empty Archive</p>
                    @endforelse
                </div>
            </div>
        @endforeach

    </div>
</aside>

      {{-- Product Main Grid --}}
      <div class="flex-1">

        {{-- Utility Bar --}}
        <div
          class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-12 bg-card/30 backdrop-blur-md p-6 rounded-[2rem] border border-border/50">
          <p class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">
            Exhibiting <span class="text-foreground font-black">{{ $products->count() }}</span> of <span
              class="text-foreground font-black">{{ $products->total() }}</span> Masterpieces
          </p>

          <div class="flex items-center gap-4 w-full sm:w-auto">
            <button
              class="lg:hidden flex-1 flex items-center justify-center gap-3 px-8 py-4 bg-primary text-primary-foreground rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-2xl shadow-primary/20">
              <x-lucide-sliders-horizontal class="w-4 h-4" />
              Filters
            </button>

            <div class="relative flex-1 sm:w-64 group">
              <select wire:model.live="sort"
                class="w-full pl-6 pr-12 py-4 bg-background border border-border/60 rounded-[1.2rem] text-[10px] font-black uppercase tracking-[0.2em] focus:ring-4 focus:ring-gold/10 outline-none appearance-none cursor-pointer transition-all">
                <option value="latest">Arrival: Newest</option>
                <option value="price-low">Value: Low to High</option>
                <option value="price-high">Value: High to Low</option>
                <option value="rating">Esteem: Top Rated</option>
              </select>
              <x-lucide-chevron-down
                class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground group-hover:text-primary transition-colors pointer-events-none" />
            </div>
          </div>
        </div>

        {{-- The Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-x-10 gap-y-16">
          @forelse ($products as $product)
            <div wire:key="prod-{{ $product->id }}" class="group/item">
              <x-card.product-card :product="$product" />
            </div>
          @empty
            <div
              class="col-span-full py-40 text-center bg-card/10 rounded-[4rem] border-2 border-dashed border-border/40">
              <div class="w-24 h-24 bg-muted/50 rounded-full flex items-center justify-center mx-auto mb-10">
                <x-lucide-package-open class="w-10 h-10 text-muted-foreground/30" />
              </div>
              <h3 class="text-4xl font-black italic tracking-tighter uppercase mb-4">Archive Empty</h3>
              <p class="text-muted-foreground mt-2 font-medium italic opacity-70 mb-10">Your current search parameters
                yielded no results in our vault.</p>
              <button wire:click="resetFilters"
                class="px-12 py-5 bg-foreground text-background rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] hover:bg-primary hover:text-white transition-all shadow-2xl">
                Re-initialize Vault
              </button>
            </div>
          @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-24 pt-12 border-t border-border/40">
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
