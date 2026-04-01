<div class="flex flex-col items-center justify-center py-20 px-8 text-center">
    <div class="relative mb-10">
        <div class="absolute inset-0 bg-primary/10 rounded-full blur-3xl opacity-50"></div>
        <div class="relative w-24 h-24 bg-card border border-border rounded-full flex items-center justify-center">
            <x-dynamic-component :component="'lucide-' . $icon" class="w-10 h-10 text-primary" />
        </div>
    </div>
    
    <h3 class="text-2xl font-black uppercase tracking-tighter italic text-foreground mb-4">
        {{ $title }}
    </h3>
    
    <p class="text-[10px] text-muted-foreground uppercase tracking-widest max-w-md leading-relaxed mb-8">
        {{ $message }}
    </p>
    
    <button wire:click="$parent.$refresh" 
            class="group flex items-center gap-3 px-8 py-4 bg-primary text-primary-foreground rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:shadow-card transition-all duration-500">
        <x-lucide-refresh-cw class="w-4 h-4 group-hover:rotate-180 transition-transform duration-700" />
        Try Again
    </button>
</div>
