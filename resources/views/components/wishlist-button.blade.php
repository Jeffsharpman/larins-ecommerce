<div>
    <button 
        wire:click="toggleWishlist"
        class="relative w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 {{ $isInWishlist ? 'bg-primary/10 text-primary' : 'bg-muted/50 text-muted-foreground hover:bg-destructive/10 hover:text-destructive' }}"
        title="{{ $isInWishlist ? 'Remove from favorites' : 'Add to favorites' }}">
        
        <svg class="w-5 h-5 transition-transform duration-300 {{ $isInWishlist ? 'fill-primary' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
    </button>
</div>
