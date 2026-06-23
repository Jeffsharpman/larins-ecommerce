<div class="min-h-[80vh] flex items-center justify-center selection:bg-destructive/20 selection:text-destructive">
    {{-- Background Ambient Shadow --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,var(--tw-gradient-stops))] from-destructive/3 via-transparent to-transparent pointer-events-none"></div>
    <div class="absolute top-1/4 left-1/4 w-75 h-75 bg-secondary/5 blur-[100px] rounded-full pointer-events-none dark:bg-secondary/3"></div>

    <div class="w-full max-w-4xl px-6 mx-auto animate-in fade-in slide-in-from-bottom-8 duration-1000">
        <section class="relative overflow-hidden">
            {{-- Decorative Glassmorphism Container --}}
            <div class="relative bg-card border border-border rounded-[4rem] p-12 md:p-24 shadow-card text-center group hover:border-secondary/20 transition-colors duration-500">
                <div class="absolute top-8 right-8 w-3 h-3 rounded-full bg-secondary/10 dark:bg-secondary/5"></div>
                <div class="absolute bottom-8 left-8 w-2 h-2 rounded-full bg-secondary/15 dark:bg-secondary/8"></div>
                
                {{-- Status Icon: The Interrupted Circle --}}
                <div class="relative w-24 h-24 mx-auto mb-12">
                    <div class="absolute inset-0 bg-destructive/10 rounded-full animate-ping duration-3000"></div>
                    <div class="absolute inset-4 bg-secondary/10 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700 dark:bg-secondary/5"></div>
                    <div class="relative w-full h-full bg-muted border border-destructive/20 rounded-full flex items-center justify-center">
                        <x-lucide-shield-alert class="w-10 h-10 text-destructive" />
                    </div>
                </div>

                {{-- Editorial Typography --}}
                <div class="space-y-6 mb-16">
                    <div class="flex items-center justify-center gap-4 opacity-40">
                        <div class="h-px w-8 bg-foreground"></div>
                        <h2 class="text-[10px] font-black uppercase tracking-[0.6em]">Transaction Status</h2>
                        <div class="h-px w-8 bg-foreground"></div>
                    </div>

                    <div class="flex justify-center gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-secondary/20 dark:bg-secondary/10"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-secondary/10 dark:bg-secondary/5"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-secondary/20 dark:bg-secondary/10"></div>
                    </div>

                    <h1 class="text-4xl md:text-6xl font-black italic tracking-tighter uppercase leading-none text-foreground">
                        Payment <span class="text-destructive">Unsuccessful.</span>
                    </h1>

                    <p class="max-w-md mx-auto text-sm md:text-base font-medium text-muted-foreground leading-relaxed tracking-tight">
                        Your acquisition was not finalized. The {{ $site->site_name }} archive has preserved your selections, but the order is currently on standby.
                    </p>
                </div>

                {{-- Recovery Actions --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a wire:navigate href="/checkout" 
                       class="w-full sm:w-auto px-12 py-5 bg-foreground text-background dark:bg-primary dark:text-primary-foreground text-[10px] font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-destructive dark:hover:bg-destructive hover:text-white transition-all duration-500 active:scale-95 shadow-xl">
                        Retry Transaction
                    </a>
                    
                    <a wire:navigate href="/cart" 
                       class="w-full sm:w-auto px-12 py-5 bg-transparent border border-border text-muted-foreground text-[10px] font-black uppercase tracking-[0.3em] rounded-2xl hover:border-foreground hover:text-foreground transition-all duration-500">
                        Review My Cart
                    </a>
                </div>

                {{-- Boutique Support Note --}}
                <div class="mt-20 pt-10 border-t border-border flex flex-col md:flex-row items-center justify-center gap-8">
                    <div class="flex items-center gap-3">
                        <x-lucide-help-circle class="w-4 h-4 text-muted-foreground/50" />
                        <span class="text-[9px] font-black uppercase tracking-widest text-muted-foreground">Card Issue?</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-lucide-message-square class="w-4 h-4 text-muted-foreground/50" />
                        <span class="text-[9px] font-black uppercase tracking-widest text-muted-foreground">Contact Boutique Curator</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>