<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance | {{ $site->site_name }}</title>
    <link rel="icon" href="{{ $site->favicon ? Storage::disk('public')->url($site->favicon) : asset('favicon.ico') }}" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $site->primary_color ?? "#cca050" }}',
                    },
                    fontFamily: {
                        heading: ['Montserrat', 'sans-serif'],
                        body: ['Roboto', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 12s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0.5deg)' },
                            '50%': { transform: 'translateY(-15px) rotate(-0.5deg)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --color-primary: {{ $site->primary_color ?? '#cca050' }};
            --color-secondary: {{ $site->secondary_color ?? '#1e293b' }};
            --primary-rgb: {{ implode(',', sscanf($site->primary_color ?? '#cca050', "#%02x%02x%02x")) }};
            --secondary-hue: {{ $site->getSecondaryHue() }};
            --primary-hue: {{ $site->getPrimaryHue() }};
        }

        .bg-surface { background-color: color-mix(in srgb, var(--color-secondary) 5%, white); }
        .bg-surface-dark { background-color: color-mix(in srgb, var(--color-secondary) 92%, black); }
        .text-foreground { color: color-mix(in srgb, var(--color-secondary) 85%, black); }
        .text-foreground-dark { color: color-mix(in srgb, var(--color-secondary) 12%, white); }
        .text-muted { color: color-mix(in srgb, var(--color-secondary) 55%, black); }
        .text-muted-dark { color: color-mix(in srgb, var(--color-secondary) 45%, white); }
        .border-subtle { border-color: color-mix(in srgb, var(--color-secondary) 15%, white); }
        .border-subtle-dark { border-color: color-mix(in srgb, var(--color-secondary) 75%, black); }

        .font-outline-2 {
            -webkit-text-stroke: 1px currentColor;
        }
        .hero-mask {
            background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.02) 100%);
        }
    </style>

    <script>
        // Apply dark mode from localStorage
        (function() {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

<body class="h-full transition-colors duration-700 bg-surface dark:bg-surface-dark text-foreground dark:text-foreground-dark font-body antialiased selection:bg-primary selection:text-white">

    <div class="relative min-h-screen flex items-center justify-center overflow-hidden hero-mask">

        {{-- Dynamic Decorative Orbs --}}
        <div class="absolute top-[-10%] left-[-10%] w-[60%] h-[60%] bg-primary/5 dark:bg-primary/10 rounded-full blur-[140px] animate-pulse-slow"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-primary/10 dark:bg-surface-dark/40 rounded-full blur-[120px] animate-pulse-slow"></div>

        <div class="relative z-10 w-full max-w-4xl px-6 py-12 text-center">

            {{-- Brand Identity with Ambient Glow --}}
            <div class="mb-16 animate-float">
                @if ($site->logo)
                    <div class="relative inline-block">
                        <img src="{{ Storage::disk('public')->url($site->logo) }}" alt="{{ $site->site_name }}"
                            class="h-24 mx-auto object-contain drop-shadow-2xl brightness-100 dark:brightness-125 relative z-10">
                        <div class="absolute inset-0 bg-primary/20 blur-2xl rounded-full scale-110 opacity-50"></div>
                    </div>
                @else
                    <h1 class="text-4xl font-black tracking-[0.3em] uppercase italic text-foreground dark:text-foreground-dark">
                        {{ $site->site_name }}<span class="text-primary">.</span>
                    </h1>
                @endif
            </div>

            {{-- Editorial Content --}}
            <div class="space-y-10">
                <div class="inline-flex items-center gap-4 px-5 py-2 rounded-full bg-white/40 dark:bg-white/5 border border-subtle dark:border-subtle-dark backdrop-blur-md shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    <span class="text-[10px] font-black tracking-[0.4em] uppercase text-muted dark:text-muted-dark">Digital Refresh</span>
                </div>

                <h2 class="font-heading text-6xl md:text-9xl font-black tracking-tighter leading-[0.8] text-foreground dark:text-foreground-dark uppercase">
                    Polishing <br>
                    <span class="text-transparent font-outline-2 opacity-20 dark:opacity-30 italic">Perfection</span>
                </h2>

                <p class="max-w-xl mx-auto text-muted dark:text-muted-dark text-lg md:text-xl font-light leading-relaxed opacity-80">
                    {{ $site->site_name }} is undergoing a curated update. We are refining our catalog to ensure your next
                    discovery is nothing short of exceptional.
                </p>
            </div>

            {{-- The "Concierge" Card --}}
            <div class="mt-20 bg-white/30 dark:bg-white/5 backdrop-blur-2xl border border-subtle dark:border-subtle-dark p-10 rounded-[3rem] shadow-2xl max-w-2xl mx-auto group hover:border-primary/30 transition-colors duration-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                    <div class="text-left space-y-3 border-b md:border-b-0 md:border-r border-subtle dark:border-subtle-dark pb-8 md:pb-0">
                        <h4 class="font-black text-primary uppercase text-[10px] tracking-[0.3em]">Direct Concierge</h4>
                        <a href="mailto:{{ $site->contact_email }}"
                            class="text-xl font-bold text-foreground dark:text-foreground-dark hover:text-primary transition-colors duration-500">
                            {{ $site->contact_email }}
                        </a>
                    </div>
                    
                    {{-- Social Link Logos --}}
                    <div class="flex justify-center md:justify-end gap-5">
                        @foreach ($site->social_links as $social)
                            <a href="{{ $social['url'] }}"
                                class="w-14 h-14 flex items-center justify-center rounded-2xl bg-white/80 dark:bg-surface-dark border border-subtle dark:border-subtle-dark hover:border-primary text-muted dark:text-muted-dark hover:text-primary transition-all duration-700 group/icon">
                                <span class="text-[10px] font-black tracking-tighter group-hover/icon:scale-110 transition-transform">
                                    {{ strtoupper(substr($social['platform'], 0, 2)) }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Footer Legal --}}
            <div class="mt-20 opacity-30">
                <p class="text-[9px] uppercase tracking-[0.5em] font-black text-muted dark:text-muted-dark">
                    &copy; {{ date('Y') }} {{ $site->site_name }} &mdash; 
                    {{ $site->tagline ?? 'The Modern Connoisseur' }}
                </p>
            </div>
        </div>
    </div>

</body>
</html>
