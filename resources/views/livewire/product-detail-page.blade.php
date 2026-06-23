@php
    $stock = $product->total_stock;
    $isLowStock = $stock > 0 && $stock <= 5;
    $isOutOfStock = $stock <= 0;
@endphp

<div class="min-h-screen bg-background text-foreground transition-colors duration-700 relative overflow-hidden" x-data="{ headerHeight: 0 }" x-init="setTimeout(() => { const header = document.querySelector('header.fixed'); if (header) { headerHeight = header.offsetHeight; } else { headerHeight = 80; } }, 50)">
    {{-- Ambient Light Leak --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-gradient-to-br from-secondary/5 via-secondary/5 to-transparent blur-[120px] rounded-full pointer-events-none"></div>

    {{-- Minimalist Navigation (directly below header) --}}
    <div class="border-b border-border/40 py-3 backdrop-blur-md sticky z-20 bg-background/80 dark:bg-background/80" :style="`top: ${headerHeight}px`">
        <div class="max-w-7xl mx-auto px-8 flex justify-between items-center">
            <nav class="flex items-center gap-4 text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground overflow-x-auto no-scrollbar">
                <a href="/" wire:navigate class="hover:text-primary transition-colors shrink-0">Maison</a>
                <span class="opacity-20 text-[14px] leading-none shrink-0">/</span>
                <a href="/categories" wire:navigate class="hover:text-primary transition-colors shrink-0">Archive</a>
                <span class="opacity-20 text-[14px] leading-none shrink-0">/</span>
                <span class="text-foreground tracking-[0.2em] italic truncate max-w-[200px] shrink-0">{{ $product->name }}</span>
            </nav>

            <div class="hidden md:flex items-center gap-6 shrink-0">
                            @if($isOutOfStock)
                                <span class="badge badge-out-of-stock border-secondary/20">Out of Stock</span>
                            @elseif($isLowStock)
                                <span class="badge badge-low-stock animate-pulse border-secondary/20">Only {{ $stock }} left</span>
                            @else
                                <span class="badge badge-sale border-secondary/20">In Stock &bull; {{ $stock }} available</span>
                            @endif
                        </div>
                    </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-20 items-start">

            {{-- Image Sculpture Gallery --}}
            <div class="lg:col-span-7 space-y-10" x-data="{ mainImage: '{{ $product->images[0] }}' }">
                <div class="relative aspect-[4/5] bg-muted/20 rounded-[3.5rem] overflow-hidden border border-border/60 shadow-[0_40px_80px_-15px_rgba(0,0,0,0.1)] group hover:border-secondary/20 transition-colors {{ $isOutOfStock ? 'opacity-60' : '' }}">
                    <img :src="mainImage" alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-110" />

                    {{-- Dynamic Watermark --}}
                    <div class="absolute bottom-10 left-10 overflow-hidden">
                        <p class="text-[8rem] font-black uppercase tracking-tighter text-white/10 dark:text-white/5 leading-none translate-y-4">
                            {{ substr($product->name, 0, 1) }}
                        </p>
                    </div>

                    {{-- Badges --}}
                    <div class="absolute top-10 right-10 flex flex-col gap-2">
                        @if($isOutOfStock)
                            <span class="badge badge-out-of-stock">Out of Stock</span>
                        @elseif($isLowStock)
                            <span class="badge badge-low-stock animate-pulse">Only {{ $stock }} Left</span>
                        @else
                            <span class="badge badge-sale">In Stock</span>
                        @endif
                        @if($product->on_sale && !$isOutOfStock)
                            <span class="badge badge-primary animate-pulse border-secondary/20">Sale</span>
                        @endif
                    </div>
                </div>

                {{-- Horizontal Slide Strip --}}
                <div class="flex gap-6 overflow-x-auto pb-6 no-scrollbar snap-x">
                    @foreach ($product->images as $image)
                        <button @click="mainImage = '{{ $image }}'"
                            class="flex-shrink-0 w-28 h-36 bg-muted/30 rounded-3xl overflow-hidden border-2 transition-all duration-500 snap-start"
                            :class="mainImage === '{{ $image }}' ? 'border-primary ring-8 ring-primary/5 scale-95' : 'border-transparent grayscale opacity-40 hover:opacity-100 hover:grayscale-0'">
                            <img src="{{ $image }}" class="w-full h-full object-cover" />
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

                    {{-- Stock Progress Bar --}}
                    <div class="bg-muted/20 rounded-2xl p-4 border border-border">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[9px] font-black uppercase tracking-widest text-muted-foreground">Availability</span>
                            @if($isOutOfStock)
                                <span class="text-[9px] font-black uppercase tracking-widest text-destructive">Out of Stock</span>
                            @elseif($isLowStock)
                                <span class="text-[9px] font-black uppercase tracking-widest text-amber-500">Low Stock</span>
                            @else
                                <span class="text-[9px] font-black uppercase tracking-widest text-emerald-500">In Stock</span>
                            @endif
                        </div>
                        <div class="w-full bg-muted/50 dark:bg-white/5 rounded-full h-3 overflow-hidden border border-border/60 dark:border-white/10 shadow-inner">
                            <div class="h-full rounded-full transition-all duration-700 relative
                                {{ $isOutOfStock ? 'bg-destructive' : ($isLowStock ? 'bg-amber-500' : 'bg-primary') }}"
                                style="width: {{ $isOutOfStock ? '0' : min(100, max(5, ($stock / 20) * 100)) }}%">
                                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                            </div>
                        </div>
                        <p class="text-[8px] text-muted-foreground uppercase tracking-widest mt-2">
                            {{ $stock }} {{ $stock == 1 ? 'unit' : 'units' }} available
                        </p>
                    </div>

                    <div class="flex items-baseline gap-6">
                        @if($product->on_sale && $product->sale_price && $product->sale_price < $product->price && !$isOutOfStock)
                            <span class="text-5xl font-black tracking-tighter text-emerald-500 italic">
                                {{ Number::currency($product->sale_price, 'NGN') }}
                            </span>
                            <span class="text-xl text-muted-foreground/40 line-through font-bold decoration-primary/40">
                                {{ Number::currency($product->old_price ?? $product->price, 'NGN') }}
                            </span>
                        @else
                            <span class="text-5xl font-black tracking-tighter text-foreground italic {{ $isOutOfStock ? 'opacity-40' : '' }}">
                                {{ Number::currency($product->price, 'NGN') }}
                            </span>
                        @endif
                    </div>

                    {{-- Rating Display --}}
                    @if($totalReviews > 0)
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <x-lucide-star class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-amber-400 fill-amber-400' : 'text-muted-foreground/30' }}" />
                                @endfor
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">
                                {{ $averageRating }} / 5 ({{ $totalReviews }} {{ $totalReviews == 1 ? 'Review' : 'Reviews' }})
                            </span>
                        </div>
                    @endif

                    <div class="space-y-6">
                        <div class="divider-label">
                            <span>Manifesto</span>
                        </div>
                        <div class="text-[12px] text-muted-foreground leading-relaxed font-bold uppercase tracking-[0.2em] opacity-80 border-l-4 border-primary/10 pl-8 italic">
                            {!! str($product->description)->markdown() !!}
                        </div>
                    </div>
                </div>

                {{-- Acquisition Controls --}}
                <div class="space-y-10 pt-10">
                    @if(!$isOutOfStock)
                        <div class="flex items-center gap-6">
                            {{-- Boutique Qty --}}
                            <div class="qty-selector">
                                <button wire:click="decreaseQty" wire:loading.attr="disabled" class="qty-selector-btn">
                                    <x-lucide-minus class="w-4 h-4" />
                                </button>
                                <span class="qty-selector-value">{{ $quantity }}</span>
                                <button wire:click="increaseQty" wire:loading.attr="disabled" class="qty-selector-btn {{ $quantity >= $stock ? 'opacity-30 cursor-not-allowed' : '' }}">
                                    <x-lucide-plus class="w-4 h-4" />
                                </button>
                            </div>

                            {{-- Heart/Wish --}}
                            <livewire:wishlist-button :product-id="$product->id" />
                        </div>

                        <button wire:click="addToCart({{ $product->id }})" wire:loading.attr="disabled"
                            class="btn btn-dark btn-xl w-full group/cta relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed">
                            <div class="absolute inset-0 bg-white/10 translate-y-full group-hover/cta:translate-y-0 transition-transform duration-700"></div>
                            <x-lucide-shopping-bag wire:loading.remove class="w-5 h-5 relative z-10 transition-transform group-hover/cta:rotate-12" />
                            <span wire:loading class="animate-spin rounded-full h-5 w-5 border-2 border-current border-t-transparent relative z-10"></span>
                            <span class="relative z-10">Commit to Archive</span>
                        </button>
                    @else
                        {{-- Out of Stock State --}}
                        <div class="bg-destructive/10 border-2 border-destructive/30 rounded-[2rem] p-8 text-center">
                            <div class="w-16 h-16 bg-destructive/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-lucide-package-x class="w-8 h-8 text-destructive" />
                            </div>
                            <h3 class="text-xl font-black italic text-destructive mb-2">Currently Unavailable</h3>
                            <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground">This piece is temporarily out of stock. Please check back soon.</p>
                        </div>

                        <livewire:wishlist-button :product-id="$product->id" />

                        <button disabled
                            class="btn btn-secondary btn-xl w-full opacity-50 cursor-not-allowed">
                            <x-lucide-shopping-bag class="w-5 h-5" />
                            <span>Notify When Available</span>
                        </button>
                    @endif
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

        {{-- Reviews Section --}}
        <div class="mt-32 pt-20 border-t border-border">
            <div class="flex items-center justify-between mb-16">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-3xl flex items-center justify-center border border-primary/20">
                        <x-lucide-message-square class="w-8 h-8 text-primary" />
                    </div>
                    <div>
                        <h2 class="text-4xl font-black italic tracking-tighter uppercase">Client Dispatches</h2>
                        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground mt-2">
                            @if($totalReviews > 0)
                                {{ $totalReviews }} {{ $totalReviews == 1 ? 'testimonial' : 'testimonials' }} received
                            @else
                                Be the first to share your experience
                            @endif
                        </p>
                    </div>
                </div>

                @auth
                    <button wire:click="$toggle('showReviewForm')"
                        class="btn btn-primary btn-lg">
                        <x-lucide-plus class="w-4 h-4" />
                        Add Review
                    </button>
                @else
                    <a href="/login" wire:navigate
                        class="btn btn-primary btn-lg">
                        <x-lucide-user class="w-4 h-4" />
                        Login to Review
                    </a>
                @endauth
            </div>

            {{-- Review Form --}}
            @if($showReviewForm)
                <div class="card-glass p-8 md:p-12 mb-12 border-l-4 border-secondary/20">
                    <h3 class="text-xl font-black italic uppercase tracking-tighter mb-8">Submit Your Dispatch</h3>

                    <form wire:submit="submitReview" class="space-y-8">
                        {{-- Rating Selection --}}
                        <div class="space-y-3">
                            <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2">Rating</label>
                            <div class="flex items-center gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" wire:click="$set('review_rating', {{ $i }})"
                                        class="transition-transform hover:scale-110">
                                        <x-lucide-star class="w-10 h-10 {{ $i <= $review_rating ? 'text-amber-400 fill-amber-400' : 'text-muted-foreground/30 hover:text-amber-200' }} transition-colors" />
                                    </button>
                                @endfor
                            </div>
                        </div>

                        {{-- Title --}}
                        <div class="space-y-3">
                            <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2">Title</label>
                            <input wire:model="review_title" type="text" placeholder="Summarize your experience" class="form-input">
                            @error('review_title') <span class="text-red-500 text-[9px]">{{ $message }}</span> @enderror
                        </div>

                        {{-- Comment --}}
                        <div class="space-y-3">
                            <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2">Your Review</label>
                            <textarea wire:model="review_comment" rows="5" placeholder="Share your experience with this piece..." class="form-textarea"></textarea>
                            @error('review_comment') <span class="text-red-500 text-[9px]">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary btn-lg">
                                <span wire:loading.remove>Submit Dispatch</span>
                                <span wire:loading class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showReviewForm', false)" class="btn btn-outline btn-lg">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Reviews List --}}
            @if($reviews && $reviews->count() > 0)
                <div class="space-y-8">
                    {{-- Rating Summary --}}
                    <div class="card-glass p-8 mb-12">
                        <div class="flex items-center gap-12">
                            <div class="text-center">
                                <span class="text-7xl font-black italic tracking-tighter text-foreground">{{ $averageRating }}</span>
                                <div class="flex items-center justify-center gap-1 mt-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <x-lucide-star class="w-4 h-4 {{ $i <= round($averageRating) ? 'text-amber-400 fill-amber-400' : 'text-muted-foreground/30' }}" />
                                    @endfor
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mt-2 block">{{ $totalReviews }} Reviews</span>
                            </div>

                            <div class="h-24 w-px bg-border"></div>

                            <div class="flex-1 space-y-2">
                                @for($i = 5; $i >= 1; $i--)
                                    <div class="flex items-center gap-4">
                                        <span class="text-[10px] font-black uppercase tracking-widest w-8">{{ $i }} <x-lucide-star class="w-3 h-3 inline text-amber-400 fill-amber-400" /></span>
                                        <div class="flex-1 h-3 bg-muted/20 rounded-full overflow-hidden">
                                            @php $percentage = $totalReviews > 0 ? ($ratingCounts[$i] ?? 0) / $totalReviews * 100 : 0; @endphp
                                            <div class="h-full bg-amber-400 rounded-full transition-all duration-700" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-black text-muted-foreground w-12 text-right">{{ round($percentage) }}%</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    {{-- Individual Reviews --}}
                    @foreach($reviews as $review)
                        <div class="card-glass p-8 md:p-12 hover:border-secondary/20 transition-colors">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary font-black text-lg uppercase">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black uppercase tracking-wider text-sm">{{ $review->user->name }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex items-center gap-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <x-lucide-star class="w-3 h-3 {{ $i <= $review->rating ? 'text-amber-400 fill-amber-400' : 'text-muted-foreground/30' }}" />
                                                @endfor
                                            </div>
                                            <span class="text-[9px] text-muted-foreground font-medium uppercase tracking-wider">
                                                {{ $review->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($review->title)
                                <h5 class="font-black italic uppercase tracking-tight text-lg mb-4">{{ $review->title }}</h5>
                            @endif

                            <p class="text-[12px] text-muted-foreground leading-relaxed font-medium uppercase tracking-wider">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 border-2 border-dashed border-border rounded-[2.5rem]">
                    <x-lucide-inbox class="w-16 h-16 text-muted-foreground/30 mx-auto mb-6" />
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground">No dispatches received yet</p>
                    <p class="text-[9px] text-muted-foreground/60 uppercase tracking-wider mt-2">Be the first to share your experience</p>
                </div>
            @endif
        </div>
    </div>
</div>
