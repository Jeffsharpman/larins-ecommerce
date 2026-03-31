<div class="min-h-screen bg-background text-foreground flex flex-col justify-center transition-colors duration-700 relative overflow-hidden">
    {{-- Ambient Background Accents --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[150px] -mr-64 -mt-64 transition-all duration-1000"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[150px] -ml-64 -mb-64 transition-all duration-1000"></div>

    <div class="max-w-7xl mx-auto w-full px-8 py-20 relative z-10">
        <main class="w-full max-w-md mx-auto">
            
            {{-- Aesthetic Branding Line --}}
            <div class="flex justify-center mb-12">
                <div class="h-16 w-[1px] bg-gradient-to-b from-transparent via-primary/50 to-transparent"></div>
            </div>

            <div class="text-center space-y-5 mb-12">
                <h1 class="text-5xl font-black tracking-tighter uppercase italic leading-none">
                    Recuperation<span class="text-primary">.</span>
                </h1>
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-muted-foreground/80">
                    Secure Access Recovery
                </p>
            </div>

            <div class="bg-card/40 border border-border/30 rounded-[3rem] p-10 md:p-14 shadow-2xl backdrop-blur-xl transition-all duration-700 hover:border-primary/20">
                
                {{-- Success State --}}
                @if (session('success'))
                    <div class="mb-10 p-6 bg-primary/5 border border-primary/20 rounded-3xl flex items-start gap-5 animate-in fade-in zoom-in-95 duration-500">
                        <x-lucide-check-circle class="w-6 h-6 text-primary shrink-0 mt-0.5" />
                        <div class="space-y-1.5">
                            <p class="text-[11px] font-black text-foreground uppercase tracking-[0.2em] leading-tight">
                                Courier Dispatched
                            </p> 
                            <p class="text-[9px] text-muted-foreground uppercase tracking-[0.15em] leading-relaxed">
                                A recovery link has been sent to your primary identifier. Please inspect your inbox.
                            </p>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="save" class="space-y-10">
                    <div class="space-y-8">
                        <div class="relative group">
                            <label for="email" class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground/60 mb-4 block ml-2 group-focus-within:text-primary transition-colors">
                                Email Identifier
                            </label>
                            <div class="relative">
                                <x-lucide-mail class="absolute left-7 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground/30 group-focus-within:text-primary transition-all duration-500" />
                                <input type="email" 
                                       id="email" 
                                       wire:model="email"
                                       class="py-6 pl-16 pr-8 block w-full bg-background border border-border/40 rounded-full text-[12px] font-black tracking-widest uppercase focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all duration-500 outline-none placeholder:text-muted-foreground/10"
                                       placeholder="ARCHIVE@MAISON-LARINS.COM">
                            </div>
                            
                            @error('email')
                                <div class="absolute right-6 top-[54px] text-red-500 animate-pulse">
                                    <x-lucide-alert-circle class="w-5 h-5" />
                                </div>
                                <p class="text-[9px] font-black uppercase tracking-[0.2em] text-red-500/80 mt-4 ml-6 italic">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-8 pt-4">
                        <button type="submit"
                                class="w-full py-6 px-4 flex justify-center items-center gap-4 text-[11px] font-black uppercase tracking-[0.5em] rounded-full bg-foreground text-background hover:bg-primary hover:text-white transition-all duration-700 shadow-[0_20px_50px_-10px_rgba(var(--primary-rgb),0.2)] group relative overflow-hidden">
                            
                            {{-- Sophisticated Loading --}}
                            <div wire:loading class="absolute inset-0 bg-primary flex items-center justify-center">
                                <span class="h-1 w-12 bg-white/40 animate-pulse rounded-full"></span>
                            </div>
                            
                            <span wire:loading.remove>Initialize Recovery</span>
                            <x-lucide-send wire:loading.remove class="w-4 h-4 transition-transform duration-500 group-hover:translate-x-2 group-hover:-translate-y-2 text-primary group-hover:text-white" />
                        </button>

                        <div class="text-center pt-2">
                            <a wire:navigate
                               class="text-[10px] font-black uppercase tracking-[0.4em] text-muted-foreground hover:text-primary transition-all duration-500 border-b border-transparent hover:border-primary/40 pb-2"
                               href="/login">
                                Return to Vault
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Concierge Footer --}}
            <div class="mt-16 text-center space-y-6">
                <p class="text-[10px] font-bold text-muted-foreground/40 uppercase tracking-[0.5em]">
                    Locked out? <a href="/contact" class="text-foreground/60 hover:text-primary transition-colors border-b border-foreground/10 hover:border-primary pb-0.5">Contact Concierge</a>
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