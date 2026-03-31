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

<body class="antialiased bg-[#fcfcfc] dark:bg-[#080808] text-slate-900 dark:text-slate-100 font-body selection:bg-primary/20 selection:text-primary transition-colors duration-500 overflow-x-hidden">

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
    </script>
</body>
</html>