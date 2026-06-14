<div>
  <header x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 20"
    :class="scrolled ? 'bg-background/95 shadow-[0_1px_0_rgba(var(--primary-rgb),0.08)]' : 'bg-background/80'"
    class="fixed top-0 left-0 w-full z-50 backdrop-blur-xl border-b border-border/30 transition-all duration-500"
    role="banner">

    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-center justify-between h-20">

        {{-- Mobile Menu Toggle --}}
        <div class="flex lg:hidden flex-1">
          <button type="button" class="nav-icon-btn hs-collapse-toggle" id="mobile-menu-toggle"
            data-hs-collapse="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false">
            <x-lucide-menu class="w-5 h-5 hs-collapse-open:hidden" />
            <x-lucide-x class="w-5 h-5 hidden hs-collapse-open:block" />
          </button>
        </div>

        {{-- Logo --}}
        <div class="flex justify-center lg:justify-start lg:flex-1 relative">
          <div
            class="absolute -inset-8 bg-secondary/5 dark:bg-secondary/[0.03] blur-3xl rounded-full pointer-events-none">
          </div>
          <a wire:navigate href="/" class="group flex items-center gap-2.5 relative z-10">
            {{-- Logo Icon with Glow Ring --}}
            <div class="relative flex items-center justify-center">
              <div
                class="absolute inset-0 bg-primary/20 blur-2xl rounded-full scale-150 opacity-0 group-hover:opacity-100 transition-all duration-700">
              </div>
              <div
                class="absolute inset-0 bg-secondary/15 blur-2xl rounded-full scale-125 opacity-50 group-hover:opacity-80 transition-all duration-700">
              </div>
              <div
                class="relative z-10 w-10 h-10 rounded-xl bg-gradient-to-br from-primary/15 via-secondary/5 to-primary/5 border border-primary/20 flex items-center justify-center overflow-hidden transition-all duration-500 group-hover:border-secondary/30 group-hover:shadow-lg group-hover:shadow-secondary/5">
                <img src="{{ $site->logo ? Storage::disk('public')->url($site->logo) : asset('favicon.ico') }}"
                  alt="{{ $site->site_name }} Logo"
                  class="w-6 h-6 object-contain transition-transform duration-500 group-hover:scale-110" />
              </div>
            </div>

            {{-- Brand Name --}}
            <div class="relative flex items-baseline">
              <x-lucide-sparkles
                class="absolute -top-4 -right-5 w-4 h-4 text-primary opacity-0 group-hover:opacity-100 scale-0 group-hover:scale-100 -rotate-45 group-hover:rotate-0 group-hover:animate-pulse transition-all duration-500 ease-spring drop-shadow-[0_0_6px_rgba(var(--primary-rgb),0.6)]" />
              <h1 class="text-2xl font-black tracking-tight uppercase leading-none flex items-baseline">
                <span class="text-foreground transition-colors duration-500">{{ $site->site_name }}</span>
                <span
                  class="text-primary text-[1.8rem] ml-0.5 leading-none drop-shadow-[0_0_4px_rgba(var(--primary-rgb),0.4)]">.</span>
              </h1>
            </div>
          </a>
        </div>

        {{-- Desktop Navigation --}}
        <nav class="hidden lg:flex items-center justify-center gap-1 flex-[2]" role="navigation">
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
              class="nav-link-desktop hover:bg-secondary/5 dark:hover:bg-secondary/[0.05] {{ $isActive ? 'active' : '' }}">
              <span>{{ $label }}</span>
            </a>
          @endforeach
        </nav>

        {{-- MOBILE ACTIONS --}}
        <div class="flex lg:hidden items-center justify-end gap-1 flex-1">
          <button type="button" onclick="window.toggleTheme()" class="nav-icon-btn">
            <x-lucide-sun class="w-5 h-5 stroke-[1.5]" id="mobile-sun" />
            <x-lucide-moon class="w-5 h-5 stroke-[1.5] hidden" id="mobile-moon" />
          </button>

          <a wire:navigate href="/cart" class="nav-icon-btn relative">
            <x-lucide-shopping-bag class="w-5 h-5 stroke-[1.5]" />
            @if ($total_count > 0)
              <span data-cart-badge-mobile class="count-badge">{{ $total_count }}</span>
            @endif
          </a>
        </div>

        {{-- DESKTOP ACTIONS --}}
        <div class="hidden lg:flex items-center justify-end gap-1 flex-1">
          @auth
            <a wire:navigate href="/account" class="nav-icon-btn {{ request()->is('account*') ? 'text-primary' : '' }}">
              <x-lucide-user-circle class="w-5 h-5 stroke-[1.5]" />
            </a>
          @endauth

          @guest
            <a wire:navigate href="/login" class="nav-icon-btn {{ request()->is('login*') ? 'text-primary' : '' }}">
              <x-lucide-user class="w-5 h-5 stroke-[1.5]" />
            </a>
          @endguest

          <a wire:navigate href="/wishlist" class="nav-icon-btn relative">
            <x-lucide-heart class="w-5 h-5 stroke-[1.5] {{ $wishlist_count > 0 ? 'fill-primary/20' : '' }}" />
            @if ($wishlist_count > 0)
              <span class="count-badge">{{ $wishlist_count > 9 ? '9+' : $wishlist_count }}</span>
            @endif
          </a>

          <div class="h-8 w-[1px] mx-2 bg-border/60 dark:bg-white/15 relative overflow-visible">
            <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[5px] h-[5px] rounded-full bg-primary shadow-[0_0_6px_rgba(var(--primary-rgb),0.6)] dark:shadow-[0_0_8px_rgba(var(--primary-rgb),0.5)]"></span>
          </div>

          <a wire:navigate href="/cart" class="nav-icon-btn relative">
            <x-lucide-shopping-bag class="w-5 h-5 stroke-[1.5]" />
            <span data-cart-badge
              class="count-badge animate-in zoom-in duration-300 {{ $total_count > 0 ? '' : 'hidden' }}">
              {{ $total_count > 0 ? ($total_count > 9 ? '9+' : $total_count) : '0' }}
            </span>
          </a>

          <button type="button" onclick="window.toggleTheme()" class="nav-icon-btn">
            <x-lucide-sun class="w-5 h-5 stroke-[1.5] desktop-sun" />
            <x-lucide-moon class="w-5 h-5 stroke-[1.5] hidden desktop-moon" />
          </button>
        </div>
      </div>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div id="mobile-menu"
      class="hs-collapse hidden overflow-hidden transition-all duration-500 bg-background/98 backdrop-blur-2xl border-t border-border/30"
      data-hs-collapse>
      <nav class="flex flex-col px-8 py-10 gap-6" role="navigation">
        @foreach ($navLinks as $label => $url)
          @php
            $isActive = $url === '/' ? request()->is('/') : request()->is(trim($url, '/') . '*');
          @endphp
          <a wire:navigate href="{{ $url }}"
            class="mobile-nav-link hover:border-b-secondary/20 {{ $isActive ? 'active' : '' }}">
            <span>{{ $label }}</span>
            @if ($isActive)
              <x-lucide-arrow-right class="w-5 h-5 text-primary" />
            @endif
          </a>
        @endforeach

        <div class="pt-6 mt-6 border-t border-border/30 flex flex-wrap items-center gap-6">
          <a wire:navigate href="/wishlist"
            class="mobile-nav-link-secondary hover:bg-secondary/5 dark:hover:bg-secondary/[0.05] {{ request()->is('wishlist*') ? 'active' : '' }}">
            <x-lucide-heart class="w-4 h-4" /> Wishlist
          </a>

          @auth
            <a wire:navigate href="/account"
              class="mobile-nav-link-secondary hover:bg-secondary/5 dark:hover:bg-secondary/[0.05] {{ request()->is('account*') ? 'active' : '' }}">
              <x-lucide-user class="w-4 h-4" /> Account
            </a>
            <a href="/logout"
              class="mobile-nav-link-secondary hover:bg-secondary/5 dark:hover:bg-secondary/[0.05] text-red-500/80 hover:text-red-500">
              <x-lucide-log-out class="w-4 h-4" /> Logout
            </a>
          @endauth
        </div>
      </nav>
    </div>
  </header>

  {{-- Announcements (floating bottom-left, driven by Navbar component data) --}}
  @if (count($announcements) > 0)
    <div x-data="{
        announcements: {{ json_encode($announcements) }},
        dismissed: {{ json_encode($dismissedAnnouncements) }}
    }">
      <template x-if="announcements.length > 0">
        <div class="fixed bottom-8 left-8 z-[100] space-y-3 max-w-sm">
          <template x-for="announcement in announcements.filter(a => !dismissed.includes(a.id))" :key="announcement.id">
            <div x-show="!dismissed.includes(announcement.id)" x-transition:enter="transition ease-out duration-500"
              x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
              x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0 opacity-100"
              x-transition:leave-end="translate-x-full opacity-0"
              class="relative backdrop-blur-xl bg-card/95 border shadow-2xl rounded-2xl p-4 pr-12"
              :class="{
                  'border-primary/30 bg-primary/5 shadow-primary/5': announcement.type === 'info' || !announcement
                      .type,
                  'border-secondary/20 dark:border-secondary/10 bg-secondary/5 dark:bg-secondary/[0.03] shadow-secondary/5': announcement
                      .type === 'secondary',
                  'border-amber-500/30 bg-amber-500/5 shadow-amber-500/5': announcement.type === 'warning',
                  'border-red-500/30 bg-red-500/5 shadow-red-500/5': announcement.type === 'danger',
                  'border-emerald-500/30 bg-emerald-500/5 shadow-emerald-500/5': announcement.type === 'success',
              }">

              <div class="flex items-start gap-3">
                <template x-if="announcement.type === 'warning'">
                  <x-lucide-alert-triangle class="w-5 h-5 text-amber-500 flex-shrink-0" />
                </template>
                <template x-if="announcement.type === 'danger'">
                  <x-lucide-alert-circle class="w-5 h-5 text-red-500 flex-shrink-0" />
                </template>
                <template x-if="announcement.type === 'success'">
                  <x-lucide-check-circle class="w-5 h-5 text-emerald-500 flex-shrink-0" />
                </template>
                <template x-if="announcement.type === 'info' || !announcement.type">
                  <x-lucide-info class="w-5 h-5 text-primary flex-shrink-0" />
                </template>

                <div class="flex-1 min-w-0 break-words">
                  <p class="text-[10px] font-black uppercase tracking-wider break-words" x-text="announcement.title">
                  </p>
                  <p class="text-[9px] text-muted-foreground mt-1 break-words leading-relaxed"
                    x-text="announcement.content"></p>
                  <a x-show="announcement.link" :href="announcement.link"
                    class="text-[9px] text-primary font-black uppercase tracking-wider mt-2 inline-block hover:underline">
                    Learn More
                  </a>
                </div>
              </div>

              <template x-if="announcement.dismissible">
                <button @click="dismissed.push(announcement.id); $wire.dismissAnnouncement(announcement.id)"
                  class="absolute top-2 right-2 p-1.5 text-muted-foreground hover:text-foreground hover:bg-muted/50 rounded-xl transition-all">
                  <x-lucide-x class="w-3.5 h-3.5" />
                </button>
              </template>
            </div>
          </template>
        </div>
      </template>
    </div>
  @endif
</div>
