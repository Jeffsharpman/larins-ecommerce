<div class="max-w-7xl mx-auto px-6 py-16 selection:bg-primary/20 selection:text-primary bg-background">
    
    {{-- Header Section: Client Identity --}}
    <div class="mb-16">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
            <div class="flex items-center gap-8">
                <div class="relative group">
                    {{-- Animated Aura follows primary --}}
                    <div class="absolute -inset-2 bg-gradient-to-tr from-primary via-primary/30 to-primary rounded-full blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-700"></div>
                    <div class="relative w-28 h-28 bg-card border border-border rounded-full flex items-center justify-center overflow-hidden shadow-card">
                        <x-lucide-user class="w-12 h-12 text-primary/40 group-hover:text-primary transition-colors duration-500" />
                    </div>
                    <div class="absolute bottom-1 right-1 w-7 h-7 bg-primary rounded-full border-4 border-background flex items-center justify-center">
                        <x-lucide-camera class="w-3 h-3 text-primary-foreground" />
                    </div>
                </div>
                <div class="space-y-1">
                    <h1 class="text-5xl font-black tracking-tighter uppercase italic text-foreground leading-none">
                        Maison <span class="text-primary not-italic">Joshua</span>
                    </h1>
                    <p class="text-[10px] text-muted-foreground font-black uppercase tracking-[0.4em]">
                        Client ID: LRNS-2026-0042
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="group px-8 py-3 bg-muted text-foreground text-[10px] font-black uppercase tracking-[0.3em] rounded-full border border-border hover:bg-destructive hover:text-destructive-foreground hover:border-destructive transition-all duration-500 flex items-center gap-2">
                    <x-lucide-log-out class="w-3 h-3 transition-transform group-hover:-translate-x-1" />
                    Sign Out
                </button>
            </div>
        </div>

        {{-- Luxury Navigation Tabs --}}
        <div class="relative">
            <nav class="flex gap-12 overflow-x-auto no-scrollbar border-b border-border" role="tablist">
                @php
                    $tabs = [
                        ['id' => 'profile', 'icon' => 'user', 'label' => 'Identity'],
                        ['id' => 'addresses', 'icon' => 'map-pin', 'label' => 'Boutique Shipping'],
                        ['id' => 'orders', 'icon' => 'shopping-bag', 'label' => 'Archives'],
                        ['id' => 'wishlist', 'icon' => 'heart', 'label' => 'Favorites']
                    ];
                @endphp

                @foreach($tabs as $tab)
                <button 
                    class="tab-button group flex items-center gap-3 pb-6 text-[11px] font-black uppercase tracking-[0.3em] transition-all relative {{ $loop->first ? 'text-primary' : 'text-muted-foreground hover:text-foreground' }}" 
                    data-tab="{{ $tab['id'] }}">
                    <x-dynamic-component :component="'lucide-' . $tab['icon']" class="w-4 h-4 transition-transform group-hover:-translate-y-0.5" />
                    {{ $tab['label'] }}
                    @if($loop->first)
                        <div class="absolute bottom-0 left-0 w-full h-[3px] bg-primary rounded-t-full"></div>
                    @endif
                </button>
                @endforeach
            </nav>
        </div>
    </div>

    <div id="profile-tab" class="tab-content animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="grid gap-12 lg:grid-cols-3">
            
            {{-- Main Profile Form --}}
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-card border border-border rounded-[3rem] p-10 md:p-14 backdrop-blur-sm">
                    <div class="flex items-center gap-4 mb-12">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center border border-primary/20">
                            <x-lucide-fingerprint class="w-6 h-6 text-primary" />
                        </div>
                        <div>
                            <h2 class="text-2xl font-black uppercase tracking-tighter italic text-foreground">Personal Credentials</h2>
                            <p class="text-[9px] font-bold text-muted-foreground uppercase tracking-widest">Update your boutique profile</p>
                        </div>
                    </div>

                    <form id="profileForm" class="grid gap-y-10 gap-x-8 md:grid-cols-2">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">First Name</label>
                            <input type="text" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none" value="Joshua">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Last Name</label>
                            <input type="text" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                        </div>
                        <div class="md:col-span-2 space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Email Address</label>
                            <input type="email" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Phone (NGN)</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-muted-foreground border-r border-border pr-3">+234</span>
                                <input type="tel" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl pl-20 pr-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Birthday</label>
                            <input type="date" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                        </div>

                        <div class="md:col-span-2 pt-6 flex flex-col sm:flex-row items-center gap-6">
                            <button type="submit" class="w-full sm:w-auto px-12 py-5 bg-foreground text-background text-[10px] font-black uppercase tracking-[0.3em] rounded-full hover:bg-primary hover:text-primary-foreground transition-all duration-500 shadow-card active:scale-95">
                                Save Credentials
                            </button>
                            <button type="button" class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground hover:text-foreground transition-colors py-2">
                                Discard Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar: Membership & Stats --}}
            <div class="space-y-8">
                {{-- Member Card --}}
                <div class="bg-foreground text-background rounded-[3rem] p-10 relative overflow-hidden group shadow-card">
                    {{-- Glow uses primary token --}}
                    <div class="absolute top-0 right-0 w-40 h-40 bg-primary/20 blur-[60px] rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-primary/40 transition-colors duration-1000"></div>
                    
                    <div class="relative z-10 space-y-12">
                        <div class="flex justify-between items-start">
                            <x-lucide-crown class="w-8 h-8 text-primary" />
                            <div class="text-right">
                                <p class="text-[9px] font-black uppercase tracking-[0.3em] opacity-40 mb-1">Status</p>
                                <p class="text-xs font-black uppercase tracking-widest text-primary">Elite Member</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[9px] font-black uppercase tracking-[0.4em] opacity-40 mb-2">Member Since</p>
                            <p class="text-2xl font-black italic tracking-tighter uppercase">January 2026</p>
                        </div>

                        <div class="pt-6 border-t border-background/10 flex justify-between items-center">
                            <div class="flex -space-x-2">
                                @for($i = 0; $i < 3; $i++)
                                    <div class="w-6 h-6 rounded-full bg-primary/20 border-2 border-foreground"></div>
                                @endfor
                            </div>
                            <p class="text-[9px] font-black uppercase tracking-widest opacity-60">Curated Account</p>
                        </div>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-card border border-border p-8 rounded-[2rem] text-center hover:border-primary/40 transition-all group">
                        <p class="text-3xl font-black italic text-primary group-hover:scale-110 transition-transform duration-500">12</p>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-muted-foreground mt-2">Archives</p>
                    </div>
                    <div class="bg-card border border-border p-8 rounded-[2rem] text-center hover:border-primary/40 transition-all group">
                        <p class="text-3xl font-black italic text-primary group-hover:scale-110 transition-transform duration-500">05</p>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-muted-foreground mt-2">Favorites</p>
                    </div>
                </div>

                {{-- Security Boutique --}}
                <div class="bg-card border border-border rounded-[2.5rem] p-8 space-y-5">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground mb-4 px-2">Account Security</h4>
                    
                    <button class="w-full flex items-center justify-between p-4 rounded-2xl hover:bg-background border border-transparent hover:border-border transition-all group">
                        <span class="text-[10px] font-black uppercase tracking-widest text-foreground">Update Secret Code</span>
                        <x-lucide-chevron-right class="w-4 h-4 text-muted-foreground group-hover:text-primary transition-all group-hover:translate-x-1" />
                    </button>
                    
                    <button class="w-full flex items-center justify-between p-4 rounded-2xl hover:bg-background border border-transparent hover:border-border transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-black uppercase tracking-widest text-foreground">Two-Factor</span>
                            <span class="text-[8px] px-2 py-0.5 bg-destructive/10 text-destructive font-black rounded uppercase">Inactive</span>
                        </div>
                        <x-lucide-shield-off class="w-4 h-4 text-muted-foreground" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>