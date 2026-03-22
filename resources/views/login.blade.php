<!DOCTYPE html>
<html class="light min-h-[100svh] bg-background overflow-x-hidden" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login | AKEIRA'S SNACK INN</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-surface-variant":         "#604868",
                        "outline":                    "#907898",
                        "surface-container-lowest":   "#ffffff",
                        "error-container":            "#ffe8e8",
                        "surface-container-highest":  "#ece2ec",
                        "primary":                    "#e040a0",
                        "on-primary-fixed":           "#3d0028",
                        "surface-container":          "#f8eef8",
                        "tertiary-fixed-dim":         "#80d0f0",
                        "on-surface":                 "#2e1a28",
                        "tertiary-fixed":             "#c8eaff",
                        "on-secondary-fixed-variant": "#4a3068",
                        "background":                 "#fef7ff",
                        "secondary-container":        "#eedcff",
                        "secondary-fixed-dim":        "#c8a8e8",
                        "on-error-container":         "#9b1c1c",
                        "on-background":              "#2e1a28",
                        "inverse-on-surface":         "#fef7ff",
                        "surface-bright":             "#fef7ff",
                        "primary-container":          "#f080c0",
                        "on-error":                   "#ffffff",
                        "primary-fixed-dim":          "#f0a0cc",
                        "primary-fixed":              "#ffd6ee",
                        "on-tertiary-container":      "#00334d",
                        "surface-variant":            "#f2e8f2",
                        "on-tertiary-fixed-variant":  "#005580",
                        "on-secondary":               "#ffffff",
                        "secondary-fixed":            "#eedcff",
                        "surface-tint":               "#e040a0",
                        "outline-variant":            "#dcc8e0",
                        "surface-dim":                "#e0d6e0",
                        "secondary":                  "#7c52aa",
                        "on-primary-container":       "#2e1a28",
                        "inverse-surface":            "#2e1a28",
                        "tertiary-container":         "#40c0ee",
                        "surface":                    "#fef7ff",
                        "surface-container-low":      "#fbf2fb",
                        "error":                      "#e53e3e",
                        "on-secondary-container":     "#2e2040",
                        "tertiary":                   "#0096cc",
                        "on-secondary-fixed":         "#1a1030",
                        "on-tertiary-fixed":          "#001a33",
                        "surface-container-high":     "#f2e8f2",
                        "on-primary-fixed-variant":   "#a02070",
                        "on-tertiary":                "#ffffff",
                        "on-primary":                 "#ffffff",
                        "inverse-primary":            "#f0a0cc"
                    },
                    fontFamily: {
                        "headline": ["DM Sans", "sans-serif"],
                        "body":     ["DM Sans", "sans-serif"],
                        "label":    ["DM Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg":      "2rem",
                        "xl":      "3rem",
                        "full":    "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        /* Document scroll (default) — avoid overflow-y-auto + min-h-dvh on body, which adds “empty” scroll room */
        html { overflow-x: hidden; }
        body { font-family: 'DM Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .bouncy-hover:hover {
            transform: scale(1.03);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .bouncy-hover:active { transform: scale(0.95); }
    </style>
</head>

<body class="bg-background overflow-x-hidden relative">

    {{-- Decorative background blobs --}}
    <div class="absolute top-[-10%] left-[-5%] w-64 h-64 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-80 h-80 bg-tertiary/10 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Decorative corner logos --}}
    <div class="absolute top-20 right-10 opacity-20 transform rotate-12 hidden md:block pointer-events-none select-none">
        <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-40 w-40 rounded-full object-cover border-4 border-white/50 shadow-lg" width="160" height="160" decoding="async"/>
    </div>
    <div class="absolute bottom-20 left-10 opacity-25 transform -rotate-12 hidden md:block pointer-events-none select-none">
        <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-36 w-36 rounded-full object-cover border-4 border-white/50 shadow-lg" width="144" height="144" decoding="async"/>
    </div>

    {{-- Natural height (no min-h-dvh) so scroll length matches content; pb clears fixed snack icons --}}
    <div class="relative z-10 flex w-full flex-col items-center justify-start px-4 pt-8 pb-20 sm:pb-24">
    {{-- Login Container --}}
    <div class="w-full max-w-md">

        {{-- Brand Identity --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center p-3 bg-white rounded-full shadow-[0_8px_24px_rgba(224,64,160,0.15)] mb-6 bouncy-hover cursor-pointer ring-2 ring-pink-100/80">
                <img src="{{ asset('images/logo.jpg') }}" alt="Akeira's Snack Inn" class="h-24 w-24 sm:h-28 sm:w-28 rounded-full object-cover" width="112" height="112" decoding="async"/>
            </div>
            <h1 class="text-4xl font-black tracking-tight text-primary mb-2">AKEIRA'S SNACK INN</h1>
            <p class="text-on-surface-variant font-medium">Your favourite snacks, all in one place</p>
            <p class="mt-3">
                <a href="{{ route('welcome') }}" class="text-sm font-bold text-secondary hover:text-primary transition-colors">See what the system does →</a>
            </p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white rounded-lg p-8 shadow-[0_20px_50px_rgba(224,64,160,0.1)] border border-surface-container-highest">

            {{-- Error alert --}}
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 rounded-2xl bg-error-container text-on-error-container text-sm font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">error</span>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Session status (e.g. after password reset); auto-dismiss --}}
            @include('partials.flash-status', [
                'wrapperClass' => 'mb-6 px-4 py-3 rounded-2xl bg-emerald-50 text-emerald-900 text-sm font-medium border border-emerald-200/80',
                'showIcon' => false,
            ])

            <form action="{{ route('login.attempt') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Username --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface ml-1">Username</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-xl">person</span>
                        <input
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            placeholder="Enter your username"
                            autocomplete="username"
                            required
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-full focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline transition-all"
                        />
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface ml-1">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-xl">lock</span>
                        <input
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-full focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline transition-all"
                        />
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center px-1">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input
                                name="remember"
                                type="checkbox"
                                class="peer appearance-none w-5 h-5 border-2 border-outline rounded-md checked:bg-secondary checked:border-secondary transition-all"
                            />
                            <span class="material-symbols-outlined absolute text-white opacity-0 peer-checked:opacity-100 left-1/2 -translate-x-1/2" style="font-size:0.75rem;">check</span>
                        </div>
                        <span class="text-sm font-medium text-on-surface-variant group-hover:text-secondary transition-colors">Remember me</span>
                    </label>
                </div>

                {{-- Log In button --}}
                <button
                    type="submit"
                    class="w-full py-4 bg-primary text-white font-black text-lg rounded-full shadow-[0_6px_20px_rgba(224,64,160,0.3)] bouncy-hover transition-all flex items-center justify-center gap-2"
                >
                    Log In
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-on-surface-variant">
                New here?
                <a href="{{ route('register') }}" class="font-bold text-primary hover:text-secondary transition-colors">Create an account</a>
            </p>

            @php
                $motivationalQuotes = [
                    [
                        'text' => 'Small wins at the counter add up to a thriving shop—show up today with heart, and every snack you serve matters.',
                        'author' => '— Akeira\'s Snack Inn',
                    ],
                    [
                        'text' => 'The secret of getting ahead is getting started.',
                        'author' => '— Mark Twain',
                    ],
                    [
                        'text' => 'Success is the sum of small efforts, repeated day in and day out.',
                        'author' => '— Robert Collier',
                    ],
                ];
                $quote = $motivationalQuotes[array_rand($motivationalQuotes)];
            @endphp

            {{-- Motivational quote --}}
            <div class="mt-8">
                <div class="relative flex items-center py-4">
                    <div class="flex-grow border-t border-surface-container-highest"></div>
                    <span class="flex-shrink mx-4 text-outline text-xs font-bold uppercase tracking-widest">Daily inspiration</span>
                    <div class="flex-grow border-t border-surface-container-highest"></div>
                </div>

                <div class="mt-2 p-5 rounded-2xl bg-gradient-to-br from-secondary-container/40 via-surface-container-low to-primary-fixed/30 border border-pink-100/80 shadow-[0_4px_20px_rgba(124,82,170,0.08)]">
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-secondary shrink-0 text-2xl opacity-90" aria-hidden="true">format_quote</span>
                        <blockquote class="text-left space-y-3">
                            <p class="text-sm md:text-base text-on-surface font-medium italic leading-relaxed">
                                “{{ $quote['text'] }}”
                            </p>
                            <footer class="text-xs font-black text-primary not-italic tracking-wide">
                                {{ $quote['author'] }}
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>

        </div>{{-- /card --}}

        {{-- Developer credit (watermark) --}}
        <p class="mt-6 max-w-md mx-auto text-center text-[11px] sm:text-xs leading-relaxed text-outline/50 select-none pointer-events-none" title="Application developer">
            <span class="block uppercase tracking-[0.2em] text-[10px] text-outline/40 mb-1">Developed by</span>
            <span class="font-bold text-primary/65">Carl Jay A. Cocamas</span>
            <span class="text-outline/45"> · 2026</span>
        </p>

    </div>{{-- /max-w-md --}}
    </div>{{-- /scrollable centered column --}}

    {{-- Bottom brand strip --}}
    <div class="fixed bottom-0 left-0 w-full h-16 sm:h-20 pointer-events-none opacity-40">
        <div class="flex justify-around items-end h-full px-3 sm:px-6 gap-2 overflow-hidden max-w-2xl mx-auto">
            <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-11 w-11 sm:h-14 sm:w-14 translate-y-1/4 shrink-0 rounded-full object-cover border-2 border-pink-100/60 shadow-sm" width="56" height="56" decoding="async"/>
            <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-10 w-10 sm:h-12 sm:w-12 translate-y-1/4 shrink-0 hidden sm:block rounded-full object-cover border-2 border-pink-100/60 shadow-sm" width="48" height="48" decoding="async"/>
            <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-12 w-12 sm:h-16 sm:w-16 translate-y-1/4 shrink-0 rounded-full object-cover border-2 border-pink-200/80 shadow-md ring-2 ring-pink-100/50" width="64" height="64" decoding="async"/>
            <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-10 w-10 sm:h-12 sm:w-12 translate-y-1/4 shrink-0 hidden sm:block rounded-full object-cover border-2 border-pink-100/60 shadow-sm" width="48" height="48" decoding="async"/>
            <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-11 w-11 sm:h-14 sm:w-14 translate-y-1/4 shrink-0 hidden md:block rounded-full object-cover border-2 border-pink-100/60 shadow-sm" width="56" height="56" decoding="async"/>
        </div>
    </div>

</body>
</html>
