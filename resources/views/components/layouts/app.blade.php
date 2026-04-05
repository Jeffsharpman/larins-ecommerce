<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 1. SEO & Identity --}}
    <meta name="description" content="{{ $seo_description ?? ($site->seo_description ?? $site->site_description) }}">
    <meta name="keywords" content="{{ $site->seo_keywords }}">
    <meta name="author" content="{{ $site->site_name }}">
    <title>{{ $title ?? config('app.name') }} | Maison {{ $site->site_name }}</title>

    {{-- 2. Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seo_title ?? $site->site_name }}">
    <meta property="og:description" content="{{ $seo_description ?? $site->site_description }}">
    <meta property="og:image" content="{{ $site->logo ? Storage::disk('public')->url($site->logo) : asset('images/og-default.jpg') }}">

    {{-- 3. Visuals & Branding --}}
    @php
        $faviconUrl = $site->favicon ? Storage::disk('public')->url($site->favicon) : asset('favicon.ico');
        $faviconExt = strtolower(pathinfo($site->favicon ?? 'favicon.ico', PATHINFO_EXTENSION));
        $faviconMime = match ($faviconExt) {
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'svg' => 'image/svg+xml',
            default => 'image/x-icon',
        };
    @endphp
    <link rel="icon" type="{{ $faviconMime }}" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" type="{{ $faviconMime }}" href="{{ $faviconUrl }}">

    {{-- 4. Style Injection --}}
    <style>
        :root {
            /* Primary Dynamic Color from Settings */
            --color-primary: {{ $site->primary_color ?? '#cca050' }};
            --color-secondary: {{ $site->secondary_color ?? '#1e293b' }};
            
            /* Helper for Tailwind v4/v3 opacity support with Hex */
            --primary-rgb: {{ implode(',', sscanf($site->primary_color ?? '#cca050', "#%02x%02x%02x")) }};
        }

        /* Smooth UI Transitions */
        .ease-expo { transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1); }
        
        /* Custom Scrollbar for Luxury Feel */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { 
            background: var(--color-primary); 
            border-radius: 10px;
            opacity: 0.5;
        }
    </style>

    {{-- 5. Analytics & Head Scripts --}}
    @if ($site->google_analytics_id && !config('app.debug'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $site->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ $site->google_analytics_id }}');
        </script>
    @endif

    {!! $site->custom_head_scripts !!}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="antialiased bg-background dark:bg-background text-foreground font-body selection:bg-primary/20 selection:text-primary transition-colors duration-500 overflow-x-hidden">

    {{-- High-End Grain Overlay --}}
    <div class="fixed inset-0 pointer-events-none opacity-[0.02] dark:opacity-[0.04] z-[9999] bg-[url('/images/noise.svg')]"></div>

    {{-- Header --}}
    <livewire:partials.navbar />

    {{-- Main Content --}}
    <main class="min-h-screen relative">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <livewire:partials.footer />

    {{-- Floating Announcements (Bottom Left) --}}
    <div x-data="{ 
        announcements: {{ json_encode($announcements ?? []) }},
        dismissed: {{ json_encode($dismissedAnnouncements ?? []) }}
    }">
        <template x-if="announcements.length > 0">
            <div class="fixed bottom-8 left-8 z-[100] space-y-3 max-w-sm">
                <template x-for="announcement in announcements.filter(a => !dismissed.includes(a.id))" :key="announcement.id">
                    <div x-show="!dismissed.includes(announcement.id)"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="translate-x-full opacity-0"
                        x-transition:enter-end="translate-x-0 opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="translate-x-0 opacity-100"
                        x-transition:leave-end="translate-x-full opacity-0"
                        class="relative backdrop-blur-xl bg-card/90 border border-border shadow-2xl rounded-2xl p-4 pr-12"
                        :class="{
                            'border-primary/30 bg-primary/5': announcement.type === 'info',
                            'border-amber-500/30 bg-amber-500/5': announcement.type === 'warning',
                            'border-red-500/30 bg-red-500/5': announcement.type === 'danger',
                            'border-green-500/30 bg-green-500/5': announcement.type === 'success',
                        }">
                        
                        <div class="flex items-start gap-3">
                            <template x-if="announcement.type === 'warning'">
                                <x-lucide-alert-triangle class="w-5 h-5 text-amber-500 flex-shrink-0" />
                            </template>
                            <template x-if="announcement.type === 'danger'">
                                <x-lucide-alert-circle class="w-5 h-5 text-red-500 flex-shrink-0" />
                            </template>
                            <template x-if="announcement.type === 'success'">
                                <x-lucide-check-circle class="w-5 h-5 text-green-500 flex-shrink-0" />
                            </template>
                            <template x-if="announcement.type === 'info' || !announcement.type">
                                <x-lucide-info class="w-5 h-5 text-primary flex-shrink-0" />
                            </template>
                            
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-wider" x-text="announcement.title"></p>
                                <p class="text-[9px] text-muted-foreground mt-1" x-text="announcement.content"></p>
                                <a x-show="announcement.link" :href="announcement.link" 
                                    class="text-[9px] text-primary font-black uppercase tracking-wider mt-2 inline-block hover:underline">
                                    Learn More
                                </a>
                            </div>
                        </div>
                        
                        <button @click="dismissed.push(announcement.id); $wire.dismissAnnouncement(announcement.id)"
                            class="absolute top-2 right-2 p-1 text-muted-foreground hover:text-foreground transition-colors">
                            <x-lucide-x class="w-4 h-4" />
                        </button>
                    </div>
                </template>
            </div>
        </template>
    </div>

    @livewireScripts

    {{-- Premium Notification System --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal:alert', event => {
            const isDark = document.documentElement.classList.contains('dark');
            const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim();

            Swal.fire({
                icon: event.detail.icon,
                title: event.detail.title || '',
                text: event.detail.text || '',
                position: event.detail.position || 'center',
                timer: event.detail.timer || 4000,
                toast: event.detail.toast || false,
                timerProgressBar: true,
                showConfirmButton: !event.detail.toast,
                background: isDark ? '#121212' : '#ffffff',
                color: isDark ? '#f8fafc' : '#0f172a',
                confirmButtonColor: primaryColor,
                customClass: {
                    popup: 'rounded-[2.5rem] border border-slate-200 dark:border-white/5 shadow-2xl backdrop-blur-xl',
                    title: 'font-heading font-black uppercase tracking-tighter italic text-2xl',
                    htmlContainer: 'text-[11px] uppercase tracking-widest font-bold opacity-70',
                    confirmButton: 'rounded-full uppercase text-[10px] px-10 py-4 tracking-[0.3em] font-black'
                }
            });
        });

        // Cart count badge update handler
        window.addEventListener('cart-count-updated', event => {
            const count = event.detail.count;
            
            // Update desktop badge
            const badge = document.querySelector('[data-cart-badge]');
            if (badge) {
                badge.textContent = count > 9 ? '9+' : count;
                if (count > 0) {
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
            
            // Update mobile badge
            const mobileBadge = document.querySelector('[data-cart-badge-mobile]');
            if (mobileBadge) {
                mobileBadge.textContent = count;
                if (count > 0) {
                    mobileBadge.classList.remove('hidden');
                } else {
                    mobileBadge.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>