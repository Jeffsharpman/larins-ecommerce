<div class="min-h-screen bg-background text-foreground transition-colors duration-500 selection:bg-primary/30">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-24">
            {{-- Hero Section --}}
            <div class="relative">
                <div class="absolute -top-12 -left-12 -z-10 opacity-5">
                    <h2 class="text-[15rem] font-black uppercase tracking-tighter text-foreground">Vox</h2>
                </div>
                <h1 class="text-6xl font-black tracking-tighter uppercase italic text-foreground mb-6">
                    The <span class="text-primary">{{ $site->site_name }}</span> Experience
                </h1>
                <p class="text-[11px] font-bold uppercase tracking-[0.4em] text-muted-foreground leading-relaxed max-w-md">
                    A testament to efficacy and elegance. Discover the stories of those who have transformed their ritual with our curated formulas.
                </p>
                
                <div class="mt-12 flex items-center gap-8">
                    <div class="text-center">
                        <span class="text-7xl font-black tracking-tighter text-foreground">4.9</span>
                        <div class="flex gap-0.5 mt-2 justify-center">
                            @for($i = 0; $i < 5; $i++)
                                <x-lucide-star class="w-3 h-3 fill-primary text-primary" />
                            @endfor
                        </div>
                    </div>
                    <div class="h-16 w-px bg-border"></div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-muted-foreground mb-1">Total Testimonials</p>
                        <p class="text-2xl font-bold tracking-tight text-foreground">2,847 <span class="text-xs font-medium text-muted-foreground tracking-normal italic">Verified Clients</span></p>
                    </div>
                </div>
            </div>

            {{-- Sentiment Card --}}
            <div class="bg-card/50 backdrop-blur-md p-10 rounded-[2.5rem] border border-border/50 relative overflow-hidden shadow-2xl shadow-primary/5">
                 <div class="absolute top-0 right-0 p-8 opacity-10">
                    <x-lucide-quote class="w-12 h-12 text-foreground" />
                </div>
                <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-8">Sentiment Analysis</h2>
                
                <div class="space-y-4 mb-10">
                    @foreach([['label' => '5 Stars', 'w' => '78%'], ['label' => '4 Stars', 'w' => '18%'], ['label' => '3 Stars', 'w' => '3%'], ['label' => '2 Stars', 'w' => '1%']] as $row)
                    <div class="flex items-center gap-4 group">
                        <span class="text-[10px] font-bold w-14 uppercase tracking-tighter group-hover:text-primary transition-colors text-foreground">{{ $row['label'] }}</span>
                        <div class="flex-1 bg-muted rounded-full h-[3px] overflow-hidden">
                            <div class="bg-foreground h-full rounded-full transition-all group-hover:bg-primary" style="width: {{ $row['w'] }}"></div>
                        </div>
                        <span class="text-[10px] font-black w-10 text-right opacity-40 italic text-foreground">{{ $row['w'] }}</span>
                    </div>
                    @endforeach
                </div>

                <button onclick="openReviewModal()" class="w-full flex items-center justify-center gap-3 px-8 py-5 bg-foreground text-background text-[11px] font-black uppercase tracking-[0.3em] rounded-full hover:bg-primary hover:text-primary-foreground transition-all duration-500 shadow-lg shadow-foreground/10 hover:shadow-primary/20">
                    <x-lucide-edit-3 class="w-4 h-4" />
                    Submit Your Journal
                </button>
            </div>
        </div>

        {{-- Review Grid --}}
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3">
            @php
                $reviews = [
                    ['name' => 'Sarah Johnson', 'initials' => 'SJ', 'title' => 'The Transformation', 'text' => 'A ritual turned into a revelation. The foundation is weightless, providing a luminous finish that mirrors natural skin under sunlight.', 'time' => '2W AGO'],
                    ['name' => 'Maria Chen', 'initials' => 'MC', 'title' => 'Concierge Excellence', 'text' => 'A minor logistic delay was handled with such grace by the team. They treated me like a priority, not a transaction.', 'time' => '1M AGO'],
                    ['name' => 'Alex Rodriguez', 'initials' => 'AR', 'title' => 'Purity & Power', 'text' => 'The ingredient list is a love letter to botanical science. Finally, a routine that respects both my ethics and my efficacy needs.', 'time' => '3W AGO']
                ];
            @endphp

            @foreach($reviews as $rev)
            <div class="group p-8 bg-card border border-border/40 rounded-[2rem] hover:border-primary/40 transition-all duration-700 hover:shadow-2xl hover:shadow-primary/5">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex gap-0.5">
                        @for($i = 0; $i < 5; $i++)
                            <x-lucide-star class="w-2.5 h-2.5 fill-primary/20 text-primary/20 group-hover:fill-primary group-hover:text-primary transition-colors" />
                        @endfor
                    </div>
                    <span class="text-[9px] font-black tracking-widest text-muted-foreground uppercase">{{ $rev['time'] }}</span>
                </div>
                
                <h3 class="text-lg font-black uppercase tracking-tight italic mb-4 text-foreground">"{{ $rev['title'] }}"</h3>
                <p class="text-sm text-muted-foreground leading-relaxed italic mb-8 min-h-[80px]">
                    {{ $rev['text'] }}
                </p>

                <div class="flex items-center gap-4 pt-6 border-t border-border/40">
                    <div class="w-10 h-10 bg-muted rounded-full flex items-center justify-center text-[11px] font-black text-primary border border-primary/10">
                        {{ $rev['initials'] }}
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-foreground">{{ $rev['name'] }}</p>
                        <p class="text-[9px] font-bold text-primary uppercase tracking-tighter">Verified Client</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Modal --}}
    <div id="reviewModal" class="fixed inset-0 bg-background/95 backdrop-blur-md hidden z-50 flex items-center justify-center p-4">
        <div class="bg-card rounded-[3rem] border border-border shadow-2xl max-w-lg w-full overflow-hidden">
            <div class="p-10 border-b border-border/50 flex justify-between items-center bg-muted/30">
                <div>
                    <h3 class="text-2xl font-black uppercase tracking-tighter italic text-foreground">Client Journal</h3>
                    <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Share your {{ $site->site_name }} ritual</p>
                </div>
                <button onclick="closeReviewModal()" class="p-2 hover:bg-background rounded-full transition-colors text-foreground">
                    <x-lucide-x class="w-6 h-6" />
                </button>
            </div>
            
            <form id="reviewForm" class="p-10 space-y-8">
                <div class="space-y-4 text-center">
                    <label class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">Select Impression</label>
                    <div class="flex justify-center gap-3" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn p-1 group" data-rating="{{ $i }}">
                            <x-lucide-star class="w-8 h-8 text-muted fill-none group-hover:scale-125 transition-all" />
                        </button>
                        @endfor
                    </div>
                </div>

                <div class="space-y-6">
                    <input type="text" id="reviewTitle" required
                        class="w-full bg-transparent border-0 border-b border-border py-4 text-sm font-bold text-foreground placeholder:text-muted-foreground/30 focus:border-primary focus:ring-0 transition-all uppercase tracking-widest" 
                        placeholder="JOURNAL TITLE (E.G. RADIANT FINISH)">
                    
                    <textarea id="reviewText" rows="4" required
                        class="w-full bg-transparent border-0 border-b border-border py-4 text-sm font-medium text-foreground placeholder:text-muted-foreground/30 focus:border-primary focus:ring-0 transition-all resize-none" 
                        placeholder="DESCRIBE YOUR SENSORY EXPERIENCE..."></textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeReviewModal()" class="flex-1 px-8 py-5 text-[10px] font-black uppercase tracking-widest text-muted-foreground hover:text-foreground transition-all">
                        Discard
                    </button>
                    <button type="submit" class="flex-1 px-8 py-5 bg-foreground text-background text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-primary hover:text-primary-foreground transition-all shadow-lg">
                        Publish Review
                    </button>
                </div>
            </form>
        </div>
    </div> 
</div>  