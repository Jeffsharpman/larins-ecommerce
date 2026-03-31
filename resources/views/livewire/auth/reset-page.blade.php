<div class="min-h-screen bg-background text-foreground flex flex-col justify-center transition-colors duration-700 relative overflow-hidden">
    {{-- Ambient Background Accents --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,rgba(var(--primary-rgb),0.04)_0%,transparent_70%)] pointer-events-none transition-opacity duration-1000"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto w-full px-8 py-20 relative z-10">
        <main class="w-full max-w-md mx-auto">
            
            {{-- Aesthetic Branding Line --}}
            <div class="flex justify-center mb-12">
                <div class="h-16 w-[1px] bg-gradient-to-b from-transparent via-primary/50 to-transparent"></div>
            </div>

            <div class="text-center space-y-5 mb-12">
                <h1 class="text-5xl font-black tracking-tighter uppercase italic leading-none">
                    Sécurité<span class="text-primary">.</span>
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-muted-foreground/80">
                    Define new credentials
                </p>
            </div>

            <div class="bg-card/40 border border-border/30 rounded-[3rem] p-10 md:p-14 shadow-2xl backdrop-blur-xl transition-all duration-700 hover:border-primary/20">
                
                {{-- Success Notification --}}
                @if (session('success'))
                    <div class="mb-10 p-6 bg-primary/5 border border-primary/20 rounded-3xl flex items-start gap-5 animate-in fade-in zoom-in-95 duration-500">
                        <x-lucide-check-circle class="w-6 h-6 text-primary shrink-0 mt-0.5" />
                        <div class="space-y-1.5">
                            <p class="text-[11px] font-black text-foreground uppercase tracking-[0.2em] leading-tight">
                                Credentials Updated
                            </p> 
                            <p class="text-[9px] text-muted-foreground uppercase tracking-[0.15em] leading-relaxed">
                                Your access codes have been successfully recalibrated.
                            </p>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="save" class="space-y-10">
                    {{-- New Password Field --}}
                    <div class="space-y-3">
                        <label for="password" class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60 block ml-2 group-focus-within:text-primary transition-colors">
                            New Secret Code
                        </label>
                        <div class="relative group">
                            <x-lucide-key-round class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground/30 group-focus-within:text-primary transition-all duration-500" />
                            <input type="password" id="password" wire:model="password"
                                   class="py-5 pl-16 pr-14 block w-full bg-background border border-border/40 rounded-full text-[12px] font-black tracking-widest focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all duration-500 outline-none placeholder:text-muted-foreground/10"
                                   placeholder="••••••••">
                            
                            @error('password')
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-red-500">
                                    <x-lucide-alert-circle class="w-5 h-5 animate-pulse" />
                                </div>
                            @enderror
                        </div>
                        @error('password')
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-red-500/80 mt-3 ml-6 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmation Field --}}
                    <div class="space-y-3">
                        <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60 block ml-2 group-focus-within:text-primary transition-colors">
                            Confirm Code
                        </label>
                        <div class="relative group">
                            <x-lucide-shield-check class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground/30 group-focus-within:text-primary transition-all duration-500" />
                            <input type="password" id="password_confirmation" wire:model="password_confirmation"
                                   class="py-5 pl-16 pr-14 block w-full bg-background border border-border/40 rounded-full text-[12px] font-black tracking-widest focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all duration-500 outline-none placeholder:text-muted-foreground/10"
                                   placeholder="••••••••">
                            
                            @error('password_confirmation')
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-red-500">
                                    <x-lucide-alert-circle class="w-5 h-5 animate-pulse" />
                                </div>
                            @enderror
                        </div>
                        @error('password_confirmation')
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-red-500/80 mt-3 ml-6 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Button --}}
                    <div class="pt-6">
                        <button type="submit"
                                class="w-full py-6 px-4 flex justify-center items-center gap-4 text-[11px] font-black uppercase tracking-[0.5em] rounded-full bg-foreground text-background hover:bg-primary hover:text-white transition-all duration-700 shadow-[0_20px_50px_-10px_rgba(var(--primary-rgb),0.3)] group relative overflow-hidden">
                            
                            <span wire:loading.remove>Update Credentials</span>
                            <div wire:loading class="h-1 w-12 bg-white/40 animate-pulse rounded-full"></div>
                            
                            <x-lucide-lock-keyhole wire:loading.remove class="w-4 h-4 transition-transform duration-500 group-hover:scale-110 text-primary group-hover:text-white" />
                        </button>
                    </div>
                </form>
            </div>

            {{-- Support Footer --}}
            <div class="mt-16 text-center space-y-6">
                <p class="text-[10px] font-bold text-muted-foreground/40 uppercase tracking-[0.5em]">
                    Identity Recalibration • <a href="/contact" class="text-foreground/60 hover:text-primary transition-colors border-b border-foreground/10 hover:border-primary pb-0.5">Contact Concierge</a>
                </p>
                <div class="flex justify-center items-center gap-6 opacity-30">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-foreground"></div>
                    <x-lucide-fingerprint class="w-5 h-5 text-primary" />
                    <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-foreground"></div>
                </div>
            </div>
        </main>
    </div>
</div>