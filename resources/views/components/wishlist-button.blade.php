<div>
    <button 
        wire:click="toggleWishlist"
        class="relative w-9 h-9 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 backdrop-blur-md border shadow-sm
            {{ $isInWishlist 
                ? 'bg-red-500/15 dark:bg-red-500/20 text-red-500 dark:text-red-400 border-red-500/20 dark:border-red-400/30 shadow-red-500/10' 
                : 'bg-background/80 dark:bg-background/60 text-muted-foreground dark:text-muted-foreground border-border/50 dark:border-border/40 hover:bg-red-500/10 dark:hover:bg-red-500/20 hover:text-red-500 dark:hover:text-red-400 hover:border-red-500/20 dark:hover:border-red-400/30' }}"
        title="{{ $isInWishlist ? 'Remove from favorites' : 'Add to favorites' }}">
        
        <svg class="w-4 h-4 transition-all duration-300 {{ $isInWishlist ? 'fill-red-500 dark:fill-red-400 scale-110 drop-shadow-[0_0_6px_rgba(239,68,68,0.5)] dark:drop-shadow-[0_0_6px_rgba(248,113,113,0.4)]' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
    </button>
</div>
