<div class="min-h-screen bg-background text-foreground transition-colors duration-500 selection:bg-primary/30">
    <div class="max-w-7xl mx-auto px-6 py-16">
        {{-- Header --}}
        <div class="mb-16 border-b border-border/40 pb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-[1px] bg-primary"></div>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-primary">Client Dispatches</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-black italic tracking-tighter uppercase leading-none">
                The <span class="text-primary">{{ $site->site_name }}</span> Experience
            </h1>
        </div>

        <div class="grid lg:grid-cols-12 gap-12 mb-16">
            {{-- Stats & Filters Sidebar --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- Stats Card --}}
                <div class="bg-card/50 backdrop-blur-md p-8 rounded-[2.5rem] border border-border/50 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <x-lucide-quote class="w-12 h-12 text-foreground" />
                    </div>
                    
                    <div class="flex items-center gap-6 mb-8">
                        <span class="text-6xl font-black tracking-tighter text-foreground">{{ number_format($stats['average'], 1) }}</span>
                        <div>
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <x-lucide-star class="w-4 h-4 {{ $i <= round($stats['average']) ? 'fill-amber-400 text-amber-400' : 'text-muted-foreground/30' }}" />
                                @endfor
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mt-2">{{ $stats['total'] }} Reviews</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @for($i = 5; $i >= 1; $i--)
                            @php 
                                $percentage = $stats['total'] > 0 ? round(($stats['distribution'][$i] ?? 0) / $stats['total'] * 100) : 0;
                            @endphp
                            <button wire:click="filterByRating({{ $i }})" 
                                class="w-full flex items-center gap-4 group {{ $selected_rating == $i ? 'text-amber-400' : '' }}">
                                <span class="text-[10px] font-bold w-10 text-left group-hover:text-primary transition-colors">{{ $i }} <x-lucide-star class="w-2.5 h-2.5 inline" /></span>
                                <div class="flex-1 bg-muted rounded-full h-2 overflow-hidden">
                                    <div class="h-full {{ $selected_rating == $i ? 'bg-amber-400' : 'bg-foreground' }} rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-[10px] font-black w-10 text-right opacity-40 italic">{{ $percentage }}%</span>
                            </button>
                        @endfor
                    </div>
                </div>

                {{-- Product Filter --}}
                @if($products->count() > 0)
                    <div class="bg-card/50 backdrop-blur-md p-8 rounded-[2.5rem] border border-border/50">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-6">Filter by Product</h3>
                        <div class="space-y-2">
                            <button wire:click="filterByProduct(null)"
                                class="w-full text-left px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all {{ !$selected_product_id ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-muted' }}">
                                All Products
                            </button>
                            @foreach($products as $product)
                                <button wire:click="filterByProduct({{ $product->id }})"
                                    class="w-full text-left px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all {{ $selected_product_id == $product->id ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-muted' }}">
                                    {{ $product->name }}
                                    <span class="opacity-50 ml-2">({{ $product->approved_reviews_count }})</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($selected_product_id || $selected_rating)
                    <button wire:click="clearFilters"
                        class="w-full py-4 rounded-xl border border-border text-[10px] font-black uppercase tracking-widest text-muted-foreground hover:text-foreground hover:border-primary transition-all">
                        Clear Filters
                    </button>
                @endif
            </div>

            {{-- Reviews Grid --}}
            <div class="lg:col-span-8">
                @if($reviews->count() > 0)
                    <div class="grid gap-8">
                        @foreach($reviews as $review)
                            <div class="group p-8 bg-card border border-border/40 rounded-[2rem] hover:border-primary/40 transition-all duration-700 hover:shadow-xl hover:shadow-primary/5">
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $review->user?->avatar ? asset('storage/' . $review->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name ?? 'A') . '&background=random' }}"
                                            class="w-14 h-14 rounded-2xl object-cover ring-4 ring-muted group-hover:ring-primary/20 transition-all">
                                        <div>
                                            <h4 class="font-bold text-foreground">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                            <p class="text-[10px] text-muted-foreground uppercase tracking-widest">
                                                Verified Buyer
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="flex gap-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <x-lucide-star class="w-3 h-3 {{ $i <= $review->rating ? 'text-amber-400 fill-amber-400' : 'text-muted-foreground/30' }}" />
                                            @endfor
                                        </div>
                                        <span class="text-[10px] font-black uppercase text-muted-foreground">
                                            {{ $review->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                @if($review->title)
                                    <h3 class="text-lg font-black uppercase tracking-tight italic mb-3 text-foreground">
                                        "{{ $review->title }}"
                                    </h3>
                                @endif

                                <p class="text-sm text-muted-foreground leading-relaxed mb-6">
                                    {{ $review->comment }}
                                </p>

                                @if($review->product)
                                    <a wire:navigate href="/product/{{ $review->product->slug }}" 
                                        class="inline-flex items-center gap-3 px-4 py-2 bg-muted/50 rounded-full text-[10px] font-black uppercase tracking-wider hover:bg-primary/10 hover:text-primary transition-all">
                                        <x-lucide-package class="w-4 h-4" />
                                        {{ $review->product->name }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($reviews->hasPages())
                        <div class="mt-12 flex justify-center">
                            <div class="flex items-center gap-2">
                                @if($reviews->onFirstPage())
                                    <span class="px-4 py-3 rounded-xl border border-border text-muted-foreground opacity-50">
                                        <x-lucide-chevron-left class="w-4 h-4" />
                                    </span>
                                @else
                                    <a wire:click="previousPage" class="px-4 py-3 rounded-xl border border-border hover:border-primary hover:text-primary transition-all cursor-pointer">
                                        <x-lucide-chevron-left class="w-4 h-4" />
                                    </a>
                                @endif

                                <span class="px-4 py-3 text-[10px] font-black uppercase tracking-widest">
                                    Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}
                                </span>

                                @if($reviews->hasMorePages())
                                    <a wire:click="nextPage" class="px-4 py-3 rounded-xl border border-border hover:border-primary hover:text-primary transition-all cursor-pointer">
                                        <x-lucide-chevron-right class="w-4 h-4" />
                                    </a>
                                @else
                                    <span class="px-4 py-3 rounded-xl border border-border text-muted-foreground opacity-50">
                                        <x-lucide-chevron-right class="w-4 h-4" />
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-20 border border-dashed border-border rounded-[2.5rem]">
                        <x-lucide-inbox class="w-16 h-16 text-muted-foreground/30 mx-auto mb-6" />
                        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground">No Reviews Found</p>
                        <p class="text-[9px] text-muted-foreground/60 uppercase tracking-wider mt-2">Be the first to share your experience</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
