<div class="min-h-screen bg-background text-foreground flex flex-col justify-center transition-colors duration-700 relative overflow-hidden">
    {{-- Ambient Background Accents --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,rgba(var(--primary-rgb),0.04)_0%,transparent_70%)] pointer-events-none transition-opacity duration-1000"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto w-full px-8 py-20 relative z-10">
        <main class="w-full max-w-md mx-auto">
            
            {{-- Aesthetic Branding Accent --}}
            <div class="flex justify-center mb-12">
                <div class="h-16 w-[1px] bg-gradient-to-b from-transparent via-primary/40 to-transparent"></div>
            </div>

            <div class="text-center space-y-5 mb-12">
                <h1 class="text-5xl font-black tracking-tighter uppercase italic leading-none">
                    Authentification<span class="text-primary">.</span>
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-muted-foreground/80">
                    Access your curated collection
                </p>
            </div>

            <div class="bg-card/40 border border-border/30 rounded-[3rem] p-10 md:p-14 shadow-2xl backdrop-blur-xl transition-all duration-700 hover:border-primary/20">
                
                {{-- Session Alerts --}}
                @if (session('error'))
                    <div class="mb-8 p-5 bg-red-500/5 border border-red-500/20 rounded-3xl flex items-start gap-4 animate-in fade-in zoom-in-95 duration-500">
                        <x-lucide-alert-circle class="w-5 h-5 text-red-500 shrink-0 mt-0.5" />
                        <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em] leading-tight pt-0.5">
                            {{ session('error') }}
                        </p> 
                    </div>
                @endif

                <form wire:submit.prevent="save" class="space-y-10">
                    {{-- Email Field --}}
                    <div class="space-y-3">
                        <label for="email" class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60 block ml-2 group-focus-within:text-primary transition-colors">
                            Email Identifier
                        </label>
                        <div class="relative group">
                            <x-lucide-user class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground/30 group-focus-within:text-primary transition-all duration-500" />
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
                        <div class="flex justify-between items-center px-2">
                            <label for="password" class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60 block">
                                Password
                            </label>
                            <a wire:navigate href="/forgot" class="text-[9px] font-black uppercase tracking-[0.2em] text-primary hover:text-foreground transition-all duration-500 border-b border-primary/20 hover:border-foreground pb-0.5">
                                Forgotten?
                            </a>
                        </div>
                        <div class="relative group">
                            <x-lucide-lock class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground/30 group-focus-within:text-primary transition-all duration-500" />
                            <input type="password" id="password" wire:model="password"
                                   class="py-5 pl-16 pr-8 block w-full bg-background border border-border/40 rounded-full text-[12px] font-black tracking-widest focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all duration-500 outline-none placeholder:text-muted-foreground/10"
                                   placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-red-500/80 mt-3 ml-6 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Button --}}
                    <div class="space-y-8 pt-4">
                        <button type="submit"
                                class="w-full py-6 px-4 flex justify-center items-center gap-4 text-[11px] font-black uppercase tracking-[0.5em] rounded-full bg-foreground text-background hover:bg-primary hover:text-white transition-all duration-700 shadow-[0_20px_50px_-10px_rgba(var(--primary-rgb),0.3)] group relative overflow-hidden">
                            
                            <span wire:loading.remove>Enter the Maison</span>
                            <div wire:loading class="h-1 w-12 bg-white/40 animate-pulse rounded-full"></div>
                            
                            <x-lucide-arrow-right wire:loading.remove class="w-4 h-4 transition-transform duration-500 group-hover:translate-x-2 text-primary group-hover:text-white" />
                        </button>

                        {{-- Social Login Divider --}}
                        <div class="relative flex items-center gap-6 py-2">
                            <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent via-border/60 to-transparent"></div>
                            <span class="text-[9px] font-black text-muted-foreground/30 uppercase tracking-[0.4em]">OR</span>
                            <div class="h-[1px] flex-1 bg-gradient-to-l from-transparent via-border/60 to-transparent"></div>
                        </div>

                        <a href="/login/google" class="w-full py-5 px-4 flex justify-center items-center gap-4 text-[10px] font-black uppercase tracking-[0.3em] rounded-full border border-border/40 hover:bg-card hover:border-primary/30 transition-all duration-500 group">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 h-4 grayscale group-hover:grayscale-0 transition-all duration-500" alt="Google">
                            <span>Continue with Google</span>
                        </a>

                        <div class="text-center pt-4">
                            <span class="text-[10px] font-bold text-muted-foreground/60 uppercase tracking-widest">New to the Maison?</span>
                            <a wire:navigate href="/register" class="ml-2 text-[10px] font-black uppercase tracking-[0.3em] text-foreground hover:text-primary transition-all duration-500 border-b border-foreground/10 hover:border-primary pb-1">
                                Create Account
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Support Footer --}}
            <div class="mt-16 text-center space-y-6">
                <p class="text-[10px] font-bold text-muted-foreground/40 uppercase tracking-[0.5em]">
                    Secure Connection • <a href="/contact" class="text-foreground/60 hover:text-primary transition-colors border-b border-foreground/10 hover:border-primary pb-0.5">Concierge Assistance</a>
                </p>
                <div class="flex justify-center items-center gap-6 opacity-30">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-foreground"></div>
                    <x-lucide-shield-check class="w-5 h-5 text-primary" />
                    <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-foreground"></div>
                </div>
            </div>
        </main>
    </div>
</div>