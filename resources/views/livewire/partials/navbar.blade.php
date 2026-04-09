<header
  class="fixed top-0 left-0 w-full z-50 backdrop-blur-xl bg-background/80 border-b border-border/40 transition-all duration-500"
  role="banner">

  <div class="max-w-7xl mx-auto px-6 pt-4">
    <div class="flex items-center justify-between h-20">

      {{-- Mobile Menu Toggle --}}
      <div class="flex lg:hidden flex-1">
        <button type="button" class="hs-collapse-toggle p-2 -ml-2 text-foreground hover:text-primary transition-colors"
          id="mobile-menu-toggle" data-hs-collapse="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false">
          <x-lucide-menu class="w-5 h-5 hs-collapse-open:hidden" />
          <x-lucide-x class="w-5 h-5 hidden hs-collapse-open:block" />
        </button>
      </div>

      {{-- Logo: Dynamic Source & Primary Accents --}}
      <div class="flex justify-center lg:justify-start lg:flex-1">
        <a wire:navigate href="/" class="group flex items-center gap-3">
          <div class="relative flex items-center justify-center">
            <img src="{{ $site->logo ? Storage::disk('public')->url($site->logo) : asset('favicon.ico') }}" 
                 alt="{{ $site->site_name }} Logo" 
                 class="w-9 h-9 object-contain relative z-10 transition-transform duration-500 group-hover:scale-110" />
            {{-- Logo Ambient Glow --}}
            <div class="absolute inset-0 bg-primary/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          </div>
          <div class="relative">
            <x-lucide-sparkles
              class="w-4 h-4 text-primary absolute -top-3 -right-3 opacity-0 group-hover:opacity-100 group-hover:animate-pulse transition-opacity" />
            <h1
              class="text-2xl font-black tracking-[0.2em] uppercase italic group-hover:text-primary transition-colors duration-500">
              {{ $site->site_name }}<span class="text-primary">.</span>
            </h1>
          </div>
        </a>
      </div>

      {{-- Desktop Navigation --}}
      <nav class="hidden lg:flex items-center justify-center gap-10 flex-[2]" role="navigation">
        @php
          $navLinks = [
              'Home' => '/',
              'Shop' => '/products',
              'Brands' => '/brands',
              'Categories' => '/categories',
          ];
          if (auth()->check()) {
              $navLinks['Orders'] = '/my-orders';
          }
        @endphp

        @foreach ($navLinks as $label => $url)
          @php
            $isActive = $url === '/' ? request()->is('/') : request()->is(trim($url, '/') . '*');
          @endphp

          <a wire:navigate href="{{ $url }}"
            class="relative text-[10px] font-black uppercase tracking-[0.3em] transition-all group {{ $isActive ? 'text-primary' : 'text-muted-foreground hover:text-foreground' }}">
            {{ $label }}
            <span
              class="absolute -bottom-1 left-0 h-[1.5px] bg-primary transition-all duration-500 ease-expo group-hover:w-full {{ $isActive ? 'w-full' : 'w-0' }}"></span>
          </a>
        @endforeach
      </nav>

      {{-- 1. MOBILE ACTIONS --}}
      <div class="flex lg:hidden items-center justify-end gap-2 flex-1">
        <button type="button" onclick="window.toggleTheme()" class="p-2 text-muted-foreground hover:text-primary transition-all">
          <x-lucide-sun class="w-5 h-5 stroke-[1.5] transition-transform" id="mobile-sun" />
          <x-lucide-moon class="w-5 h-5 stroke-[1.5] transition-transform hidden" id="mobile-moon" />
        </button>

        <a wire:navigate href="/cart" class="relative p-2 text-muted-foreground hover:text-primary transition-all">
          <x-lucide-shopping-bag class="w-5 h-5 stroke-[1.5]" />
          @if ($total_count > 0)
            <span data-cart-badge-mobile
              class="absolute top-1 right-1 h-3.5 w-3.5 bg-primary text-primary-foreground text-[8px] font-black flex items-center justify-center rounded-full shadow-lg ring-2 ring-background">
              {{ $total_count }}
            </span>
          @endif
        </a>
      </div>

      {{-- 2. DESKTOP ACTIONS --}}
      <div class="hidden lg:flex items-center justify-end gap-3 flex-1">
        @auth
          <a wire:navigate href="/account"
            class="p-2 transition-all flex items-center gap-2 group {{ request()->is('account*') ? 'text-primary' : 'text-muted-foreground hover:text-primary' }}">
            <x-lucide-user-circle class="w-5 h-5 stroke-[1.5]" />
            <span class="text-[9px] uppercase font-black tracking-widest hidden xl:inline">Profile</span>
          </a>
        @endauth

        @guest
          <a wire:navigate href="/login"
            class="p-2 transition-all flex items-center gap-2 group {{ request()->is('login*') ? 'text-primary' : 'text-muted-foreground hover:text-primary' }}">
            <x-lucide-user class="w-5 h-5 stroke-[1.5]" />
            <span class="text-[9px] uppercase font-black tracking-widest hidden xl:inline">Sign In</span>
          </a>
        @endguest

        <a wire:navigate href="/wishlist" class="relative p-2 text-muted-foreground hover:text-primary transition-all group">
          <x-lucide-heart class="w-5 h-5 stroke-[1.5] {{ $wishlist_count > 0 ? 'fill-primary/20' : '' }}" />
          @if ($wishlist_count > 0)
            <span
              class="absolute top-1 right-1 h-3.5 w-3.5 bg-primary text-primary-foreground text-[8px] font-black flex items-center justify-center rounded-full shadow-lg ring-2 ring-background">
              {{ $wishlist_count > 9 ? '9+' : $wishlist_count }}
            </span>
          @endif
        </a>

        <div class="h-4 w-[1px] bg-border/40 mx-1"></div>

        <a wire:navigate href="/cart" class="relative p-2 text-muted-foreground hover:text-primary transition-all group">
          <x-lucide-shopping-bag class="w-5 h-5 stroke-[1.5]" />
          <span data-cart-badge
            class="absolute top-1 right-1 h-3.5 w-3.5 bg-primary text-primary-foreground text-[8px] font-black flex items-center justify-center rounded-full shadow-lg ring-2 ring-background animate-in zoom-in duration-300 {{ $total_count > 0 ? '' : 'hidden' }}">
            {{ $total_count > 0 ? ($total_count > 9 ? '9+' : $total_count) : '0' }}
          </span>
        </a>

        <button type="button" onclick="window.toggleTheme()" class="p-2 text-muted-foreground hover:text-primary transition-all group">
          <x-lucide-sun class="w-5 h-5 stroke-[1.5] group-hover:rotate-90 transition-transform duration-700 desktop-sun" />
          <x-lucide-moon class="w-5 h-5 stroke-[1.5] group-hover:-rotate-12 transition-transform duration-700 desktop-moon hidden" />
        </button>
      </div>
    </div>
  </div>

  {{-- Mobile Menu Overlay --}}
  <div id="mobile-menu"
    class="hs-collapse hidden overflow-hidden transition-[height] duration-500 bg-background/98 backdrop-blur-2xl border-t border-border/40"
    data-hs-collapse>
    <nav class="flex flex-col px-8 py-12 gap-8" role="navigation">
      @foreach ($navLinks as $label => $url)
        @php
          $isActive = $url === '/' ? request()->is('/') : request()->is(trim($url, '/') . '*');
        @endphp
        <a wire:navigate href="{{ $url }}"
          class="text-3xl font-black uppercase tracking-tighter italic transition-all duration-300 flex items-center gap-4 {{ $isActive ? 'text-primary' : 'text-foreground hover:translate-x-2' }}">
          @if($isActive) <span class="h-1 w-8 bg-primary rounded-full"></span> @endif
          {{ $label }}
        </a>
      @endforeach

      <div class="pt-8 border-t border-border/40 flex flex-wrap items-center gap-8">
        <a wire:navigate href="/wishlist"
          class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest transition-colors {{ request()->is('wishlist*') ? 'text-primary' : 'text-muted-foreground hover:text-primary' }}">
          <x-lucide-heart class="w-4 h-4" /> Wishlist
        </a>

        @auth
          <a wire:navigate href="/account"
            class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest transition-colors {{ request()->is('account*') ? 'text-primary' : 'text-muted-foreground hover:text-primary' }}">
            <x-lucide-user class="w-4 h-4" /> Account
          </a>
          <a href="/logout"
            class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-red-500/80 hover:text-red-500 transition-colors">
            <x-lucide-log-out class="w-4 h-4" /> Logout
          </a>
        @endauth
      </div>
    </nav>
  </div>
</header>
