<div class="min-h-screen bg-background text-foreground flex flex-col justify-center transition-colors duration-700 relative overflow-hidden">
    {{-- Ambient Background Accents --}}
    <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[150px] -ml-64 -mt-64 transition-all duration-1000"></div>
    <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[150px] -mr-64 -mb-64 transition-all duration-1000"></div>

    <div class="max-w-7xl mx-auto w-full px-8 py-20 relative z-10">
        <main class="w-full max-w-md mx-auto">
            
            {{-- Aesthetic Branding Accent --}}
            <div class="flex justify-center mb-12">
                <div class="h-16 w-[1px] bg-gradient-to-b from-transparent via-primary/50 to-transparent"></div>
            </div>

            <div class="text-center space-y-5 mb-12">
                <h1 class="text-5xl font-black tracking-tighter uppercase italic leading-none">
                    Inscription<span class="text-primary">.</span>
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-muted-foreground/80">
                    Join the Elite Circle
                </p>
            </div>

            <div class="bg-card/40 border border-border/30 rounded-[3rem] p-10 md:p-14 shadow-2xl backdrop-blur-xl transition-all duration-700 hover:border-primary/20">
                
                <form wire:submit.prevent="save" class="space-y-8">
                    {{-- Legal Name Field --}}
                    <div class="space-y-3">
                        <label for="name" class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60 block ml-2 group-focus-within:text-primary transition-colors">
                            Legal Name
                        </label>
                        <div class="relative group">
                            <x-lucide-user class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground/30 group-focus-within:text-primary transition-all duration-500" />
                            <input type="text" id="name" wire:model="name"
                                   class="py-5 pl-16 pr-8 block w-full bg-background border border-border/40 rounded-full text-[12px] font-black tracking-widest uppercase focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all duration-500 outline-none placeholder:text-muted-foreground/10"
                                   placeholder="FULL NAME">
                        </div>
                        @error('name')
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-red-500/80 mt-3 ml-6 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email Field --}}
                    <div class="space-y-3">
                        <label for="email" class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60 block ml-2 group-focus-within:text-primary transition-colors">
                            Email Identifier
                        </label>
                        <div class="relative group">
                            <x-lucide-mail class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground/30 group-focus-within:text-primary transition-all duration-500" />
                            <input type="email" id="email" wire:model="email"
                                   class="py-5 pl-16 pr-8 block w-full bg-background border border-border/40 rounded-full text-[12px] font-black tracking-widest uppercase focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all duration-500 outline-none placeholder:text-muted-foreground/10"
                                   placeholder="IDENTITY@MAISON-LARINS.COM">
                        </div>
                        @error('email')
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-red-500/80 mt-3 ml-6 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="space-y-3">
                        <label for="password" class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60 block ml-2 group-focus-within:text-primary transition-colors">
                            Secret Code
                        </label>
                        <div class="relative group">
                            <x-lucide-key-round class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground/30 group-focus-within:text-primary transition-all duration-500" />
                            <input type="password" id="password" wire:model="password"
                                   class="py-5 pl-16 pr-8 block w-full bg-background border border-border/40 rounded-full text-[12px] font-black tracking-widest focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all duration-500 outline-none placeholder:text-muted-foreground/10"
                                   placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-red-500/80 mt-3 ml-6 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Button --}}
                    <div class="space-y-8 pt-6">
                        <button type="submit"
                                class="w-full py-6 px-4 flex justify-center items-center gap-4 text-[11px] font-black uppercase tracking-[0.5em] rounded-full bg-foreground text-background hover:bg-primary hover:text-white transition-all duration-700 shadow-[0_20px_50px_-10px_rgba(var(--primary-rgb),0.3)] group relative overflow-hidden">
                            
                            <span wire:loading.remove>Create Account</span>
                            <div wire:loading class="h-1 w-12 bg-white/40 animate-pulse rounded-full"></div>
                            
                            <x-lucide-sparkles wire:loading.remove class="w-4 h-4 transition-transform duration-500 group-hover:scale-125 text-primary group-hover:text-white" />
                        </button>

                        <div class="text-center pt-2">
                            <span class="text-[10px] font-bold text-muted-foreground/60 uppercase tracking-widest">Already a member?</span>
                            <a wire:navigate href="/login" class="ml-2 text-[10px] font-black uppercase tracking-[0.3em] text-foreground hover:text-primary transition-all duration-500 border-b border-foreground/10 hover:border-primary pb-1">
                                Sign In
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Trust Signals (Concierge Style) --}}
            <div class="mt-16 flex flex-col items-center gap-8">
                <p class="text-[10px] font-bold text-muted-foreground/40 uppercase tracking-[0.6em]">
                    Private & Encrypted • Maison Standards
                </p>
                <div class="flex items-center gap-10 opacity-30 grayscale hover:grayscale-0 transition-all duration-700 group">
                    <x-lucide-shield-check class="w-5 h-5 text-primary" />
                    <div class="h-[1px] w-8 bg-gradient-to-r from-transparent via-foreground to-transparent"></div>
                    <x-lucide-globe class="w-5 h-5" />
                    <div class="h-[1px] w-8 bg-gradient-to-r from-transparent via-foreground to-transparent"></div>
                    <x-lucide-crown class="w-5 h-5" />
                </div>
            </div>
        </main>
    </div>
</div>