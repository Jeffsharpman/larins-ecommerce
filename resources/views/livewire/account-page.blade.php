<div class="max-w-7xl mx-auto px-6 py-16 selection:bg-primary/20 selection:text-primary bg-background" x-data="{ activeTab: 'profile', init() { this.$el.querySelectorAll('[data-hs-tab]').forEach(tab => { tab.addEventListener('click', () => { this.activeTab = tab.dataset.hsTab.replace('#', '').replace('-tab', '') }); }); } }">
    <style>[x-cloak] { display: none !important; }</style>
    
    {{-- Error Display --}}
    @if($error)
    <div class="mb-16">
        <div class="bg-card border border-destructive/30 rounded-[3rem] p-10 text-center">
            <x-lucide-alert-circle class="w-16 h-16 text-destructive mx-auto mb-6" />
            <h2 class="text-2xl font-black uppercase tracking-tighter italic text-foreground mb-4">Error Loading Account</h2>
            <p class="text-[10px] text-muted-foreground uppercase tracking-widest mb-8">{{ $error }}</p>
            <button wire:click="loadUserData" class="group flex items-center gap-3 px-8 py-4 bg-primary text-primary-foreground rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:shadow-card transition-all duration-500">
                <x-lucide-refresh-cw class="w-4 h-4 group-hover:rotate-180 transition-transform duration-700" />
                Try Again
            </button>
        </div>
    </div>
    @else
    {{-- Loading State --}}
    @if($isLoading)
    <div class="mb-16">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
            <div class="flex items-center gap-8">
                <div class="w-28 h-28 bg-muted rounded-full animate-pulse"></div>
                <div class="space-y-3">
                    <div class="h-10 w-48 bg-muted rounded animate-pulse"></div>
                    <div class="h-3 w-32 bg-muted rounded animate-pulse"></div>
                </div>
            </div>
        </div>
        <div class="h-12 bg-muted rounded animate-pulse mb-4"></div>
    </div>
    @else
    {{-- Header Section: Client Identity --}}
    <div class="mb-16">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
            <div class="flex items-center gap-8">
                <div class="relative group">
                    {{-- Animated Aura follows primary --}}
                    <div class="absolute -inset-2 bg-gradient-to-tr from-primary via-primary/30 to-primary rounded-full blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-700"></div>
                    <div class="relative w-28 h-28 bg-card border border-border rounded-full flex items-center justify-center overflow-hidden shadow-card">
                        @if($user && $user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <x-lucide-user class="w-12 h-12 text-primary/40 group-hover:text-primary transition-colors duration-500" />
                        @endif
                    </div>
                </div>
                <div class="space-y-1">
                    <h1 class="text-5xl font-black tracking-tighter uppercase italic text-foreground leading-none">
                        Maison <span class="text-primary not-italic">{{ $user->name }}</span>
                    </h1>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="/logout" class="group px-8 py-3 bg-muted text-foreground text-[10px] font-black uppercase tracking-[0.3em] rounded-full border border-border hover:bg-destructive hover:text-destructive-foreground hover:border-destructive transition-all duration-500 flex items-center gap-2">
                    <x-lucide-log-out class="w-3 h-3 transition-transform group-hover:-translate-x-1" />
                    Sign Out
                </a>
            </div>
        </div>

        {{-- Luxury Navigation Tabs (Preline) --}}
        <div id="account-tabs" class="relative" data-hs-tabs="#account-tabs">
            <nav class="flex gap-12 overflow-x-auto no-scrollbar border-b border-border" role="tablist">
                @php
                    $tabs = [
                        ['id' => 'profile', 'icon' => 'user', 'label' => 'Identity'],
                        ['id' => 'addresses', 'icon' => 'map-pin', 'label' => 'Boutique Shipping'],
                        ['id' => 'orders', 'icon' => 'shopping-bag', 'label' => 'Archives'],
                        ['id' => 'wishlist', 'icon' => 'heart', 'label' => 'Favorites']
                    ];
                @endphp

                @foreach($tabs as $index => $tab)
                <button 
                    class="flex items-center gap-3 pb-6 text-[11px] font-black uppercase tracking-[0.3em] transition-all relative -mb-px"
                    :class="activeTab === '{{ $tab['id'] }}' ? 'text-primary border-b-2 border-primary' : 'text-muted-foreground hover:text-foreground'"
                    data-hs-tab="#{{ $tab['id'] }}-tab"
                    role="tab"
                    wire:click="setActiveTab('{{ $tab['id'] }}')">
                    <x-dynamic-component :component="'lucide-' . $tab['icon']" class="w-4 h-4" />
                    {{ $tab['label'] }}
                </button>
                @endforeach
            </nav>
            <div class="mt-10">
                {{-- Profile Tab --}}
                <div id="profile-tab" role="tabpanel" x-show="activeTab === 'profile'" x-cloak class="animate-in fade-in slide-in-from-bottom-4 duration-700">
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

                    <form wire:submit="updateProfile" class="grid gap-y-10 gap-x-8 md:grid-cols-2">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">First Name</label>
                            <input type="text" wire:model="first_name" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Last Name</label>
                            <input type="text" wire:model="last_name" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                        </div>
                        <div class="md:col-span-2 space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Email Address</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full bg-muted border border-border rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-muted-foreground transition-all outline-none cursor-not-allowed">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Phone (NGN)</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-muted-foreground border-r border-border pr-3">+234</span>
                                <input type="tel" wire:model="phone" placeholder="8012345678" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl pl-20 pr-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Birthday</label>
                            <input type="date" wire:model="birthday" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                        </div>

                        <div class="md:col-span-2 pt-6 flex flex-col sm:flex-row items-center gap-6">
                            <button type="submit" class="w-full sm:w-auto px-12 py-5 bg-foreground text-background text-[10px] font-black uppercase tracking-[0.3em] rounded-full hover:bg-primary hover:text-primary-foreground transition-all duration-500 shadow-card active:scale-95">
                                Save Credentials
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar: Membership & Stats --}}
            <div class="space-y-8">
                {{-- Member Card --}}
                <div class="bg-foreground text-background rounded-[3rem] p-10 relative overflow-hidden group shadow-card">
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
                            <p class="text-2xl font-black italic tracking-tighter uppercase">{{ $user->created_at->format('F Y') }}</p>
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
                        <p class="text-3xl font-black italic text-primary group-hover:scale-110 transition-transform duration-500">{{ $totalOrders }}</p>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-muted-foreground mt-2">Archives</p>
                    </div>
                    <div class="bg-card border border-border p-8 rounded-[2rem] text-center hover:border-primary/40 transition-all group">
                        <p class="text-3xl font-black italic text-primary group-hover:scale-110 transition-transform duration-500">{{ $totalWishlist }}</p>
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

    {{-- Addresses Tab --}}
    <div id="addresses-tab" role="tabpanel" x-show="activeTab === 'addresses'" x-cloak class="animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="bg-card border border-border rounded-[3rem] p-10 md:p-14">
            <div class="flex items-center justify-between mb-12">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center border border-primary/20">
                        <x-lucide-map-pin class="w-6 h-6 text-primary" />
                    </div>
                    <div>
                        <h2 class="text-2xl font-black uppercase tracking-tighter italic text-foreground">Boutique Shipping</h2>
                        <p class="text-[9px] font-bold text-muted-foreground uppercase tracking-widest">Your delivery destinations</p>
                    </div>
                </div>
                <button wire:click="openAddressModal()" class="flex items-center gap-2 px-6 py-3 bg-primary text-primary-foreground rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:bg-primary/90 transition-all">
                    <x-lucide-plus class="w-4 h-4" />
                    Add Address
                </button>
            </div>

            @if(!empty($addresses))
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach($addresses as $address)
                    <div class="bg-background border {{ $address['is_active'] ? 'border-primary' : 'border-border' }} rounded-2xl p-6 hover:border-primary/40 transition-all group relative">
                        @if($address['is_active'])
                        <span class="absolute -top-2 -right-2 text-[8px] font-black uppercase tracking-[0.2em] px-3 py-1 bg-primary text-primary-foreground rounded-full">Default</span>
                        @endif
                        <div class="flex items-center gap-3 mb-4">
                            @if($address['title'] === 'home')
                                <x-lucide-home class="w-5 h-5 text-primary" />
                            @elseif($address['title'] === 'work_place')
                                <x-lucide-briefcase class="w-5 h-5 text-primary" />
                            @else
                                <x-lucide-map-pin class="w-5 h-5 text-primary" />
                            @endif
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">
                                {{ $address['title'] === 'home' ? 'Home' : ($address['title'] === 'work_place' ? 'Work Place' : 'Other') }}
                            </span>
                        </div>
                        <p class="text-lg font-black italic text-foreground mb-2">{{ $user->name }}</p>
                        <p class="text-[10px] text-muted-foreground uppercase tracking-wider leading-relaxed mb-4">
                            {{ $address['street_address'] ?? '' }}<br>
                            {{ $address['city'] ?? '' }}, {{ $address['state'] ?? '' }} {{ $address['zip_code'] ?? '' }}
                        </p>
                        <div class="flex gap-3 pt-4 border-t border-border">
                            @if(!$address['is_active'])
                            <button wire:click="setActiveAddress({{ $address['id'] }})" class="text-[9px] font-black uppercase tracking-widest text-primary hover:underline">Set as Default</button>
                            @endif
                            <button wire:click="openAddressModal({{ $address['id'] }})" class="text-[9px] font-black uppercase tracking-widest text-muted-foreground hover:text-foreground">Edit</button>
                            <button wire:click="confirmDeleteAddress({{ $address['id'] }})" class="text-[9px] font-black uppercase tracking-widest text-muted-foreground hover:text-destructive">Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <x-lucide-map-pin class="w-16 h-16 text-muted-foreground/30 mx-auto mb-6" />
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">No shipping addresses yet</p>
                    <p class="text-[9px] text-muted-foreground/60 mt-2">Add your first delivery destination</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Address Modal --}}
    @if($showAddressModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data="{ modalOpen: true }" x-show="modalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-background/80 backdrop-blur-sm" wire:click="closeAddressModal"></div>
        <div class="relative bg-card border border-border rounded-[3rem] p-10 w-full max-w-lg shadow-xl" x-show="modalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black uppercase tracking-tighter italic text-foreground">
                    {{ $editingAddress ? 'Edit Address' : 'Add New Address' }}
                </h3>
                <button wire:click="closeAddressModal" class="p-2 hover:bg-muted rounded-full transition-colors">
                    <x-lucide-x class="w-5 h-5 text-muted-foreground" />
                </button>
            </div>
            
            <form wire:submit="saveAddress" class="space-y-6">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Address Title</label>
                    <select wire:model="addressTitle" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                        <option value="">Select Type</option>
                        <option value="home">Home</option>
                        <option value="work_place">Work Place</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Street Address</label>
                    <input type="text" wire:model="addressStreet" placeholder="123 Example Street" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">City</label>
                        <input type="text" wire:model="addressCity" placeholder="Lagos" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">State</label>
                        <input type="text" wire:model="addressState" placeholder="Lagos" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Zip Code</label>
                        <input type="text" wire:model="addressZip" placeholder="100001" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground ml-1">Phone (NGN)</label>
                        <input type="tel" wire:model="addressPhone" placeholder="8012345678" class="w-full bg-background border border-border focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl px-6 py-4 text-xs font-bold tracking-widest text-foreground transition-all outline-none">
                    </div>
                </div>
                
                <div class="flex gap-4 pt-4">
                    <button type="button" wire:click="closeAddressModal" class="flex-1 px-6 py-4 bg-muted text-foreground rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:bg-muted/80 transition-all">Cancel</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-primary text-primary-foreground rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:bg-primary/90 transition-all">Save Address</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:click.self="closeDeleteModal">
        <div class="absolute inset-0 bg-background/80 backdrop-blur-sm"></div>
        <div class="relative bg-card border border-border rounded-[3rem] p-10 w-full max-w-md shadow-xl animate-in zoom-in-95 duration-200">
            <div class="text-center">
                <div class="w-16 h-16 bg-destructive/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <x-lucide-trash-2 class="w-8 h-8 text-destructive" />
                </div>
                <h3 class="text-xl font-black uppercase tracking-tighter italic text-foreground mb-2">Delete Address</h3>
                <p class="text-muted-foreground text-sm mb-8">Are you sure you want to delete this address? This action cannot be undone.</p>
                
                <div class="flex gap-4">
                    <button wire:click="closeDeleteModal" class="flex-1 px-6 py-4 bg-muted text-foreground rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:bg-muted/80 transition-all">Cancel</button>
                    <button wire:click="deleteAddress" class="flex-1 px-6 py-4 bg-destructive text-destructive-foreground rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:bg-destructive/90 transition-all">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Orders Tab --}}
    <div id="orders-tab" role="tabpanel" x-show="activeTab === 'orders'" x-cloak class="animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="bg-card border border-border rounded-[3rem] p-10 md:p-14">
            <div class="flex items-center gap-4 mb-12">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center border border-primary/20">
                    <x-lucide-shopping-bag class="w-6 h-6 text-primary" />
                </div>
                <div>
                    <h2 class="text-2xl font-black uppercase tracking-tighter italic text-foreground">Archive Ledger</h2>
                    <p class="text-[9px] font-bold text-muted-foreground uppercase tracking-widest">Your acquisition history</p>
                </div>
            </div>

            @if($orders && $orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                    <div class="bg-background border border-border rounded-2xl p-6 hover:border-primary/30 transition-all">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center">
                                    <x-lucide-package class="w-6 h-6 text-primary" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-primary mb-1">Order #{{ substr($order->id, 0, 8) }}</p>
                                    <p class="text-lg font-black italic text-foreground">{{ $order->items->count() }} Items</p>
                                    <p class="text-[9px] text-muted-foreground uppercase tracking-wider mt-1">{{ $order->created_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black italic text-foreground">₦{{ number_format($order->grand_total ?? $order->total, 2) }}</p>
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full mt-2 inline-block
                                    @if($order->status === 'delivered') bg-emerald-500/10 text-emerald-500
                                    @elseif($order->status === 'shipped') bg-blue-500/10 text-blue-500
                                    @else bg-primary/10 text-primary @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <x-lucide-shopping-bag class="w-16 h-16 text-muted-foreground/30 mx-auto mb-6" />
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">No orders yet</p>
                    <p class="text-[9px] text-muted-foreground/60 mt-2">Your acquisition history will appear here</p>
                    <a href="/products" wire:navigate class="mt-6 inline-block px-8 py-3 bg-primary text-primary-foreground text-[10px] font-black uppercase tracking-[0.3em] rounded-full">
                        Explore Collection
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Wishlist Tab --}}
    <div id="wishlist-tab" role="tabpanel" x-show="activeTab === 'wishlist'" x-cloak class="animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="bg-card border border-border rounded-[3rem] p-10 md:p-14">
            <div class="flex items-center gap-4 mb-12">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center border border-primary/20">
                    <x-lucide-heart class="w-6 h-6 text-primary" />
                </div>
                <div>
                    <h2 class="text-2xl font-black uppercase tracking-tighter italic text-foreground">Favorites</h2>
                    <p class="text-[9px] font-bold text-muted-foreground uppercase tracking-widest">Your wishlist curation</p>
                </div>
            </div>

            @if(count($wishlistItems) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($wishlistItems as $item)
                    <div class="bg-background border border-border rounded-[2rem] overflow-hidden hover:border-primary/30 transition-all group">
                        <div class="aspect-[4/5] bg-muted relative">
                            <img src="{{ url('storage', $item['image'] ?? 'images/placeholder.jpg') }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            <button class="absolute top-4 right-4 w-10 h-10 bg-card/80 backdrop-blur rounded-full flex items-center justify-center text-red-500">
                                <x-lucide-heart class="w-4 h-4 fill-current" />
                            </button>
                        </div>
                        <div class="p-6">
                            <p class="text-sm font-black italic text-foreground truncate">{{ $item['name'] }}</p>
                            <p class="text-lg font-black italic text-primary mt-2">₦{{ number_format($item['price'] ?? 0, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <x-lucide-heart class="w-16 h-16 text-muted-foreground/30 mx-auto mb-6" />
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-muted-foreground">No favorites yet</p>
                    <p class="text-[9px] text-muted-foreground/60 mt-2">Items you love will appear here</p>
                    <a href="/products" wire:navigate class="mt-6 inline-block px-8 py-3 bg-primary text-primary-foreground text-[10px] font-black uppercase tracking-[0.3em] rounded-full">
                        Explore Collection
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif
    @endif
</div>
