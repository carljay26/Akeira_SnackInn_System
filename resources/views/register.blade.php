<!DOCTYPE html>
<html class="light min-h-[100svh] bg-background overflow-x-hidden" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register | AKEIRA'S SNACK INN</title>
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

    <div class="absolute top-[-10%] left-[-5%] w-64 h-64 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-80 h-80 bg-tertiary/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="absolute top-20 right-10 opacity-20 transform rotate-12 hidden md:block pointer-events-none select-none">
        <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-40 w-40 rounded-full object-cover border-4 border-white/50 shadow-lg" width="160" height="160" decoding="async"/>
    </div>
    <div class="absolute bottom-20 left-10 opacity-25 transform -rotate-12 hidden md:block pointer-events-none select-none">
        <img src="{{ asset('images/logo.jpg') }}" alt="" class="h-36 w-36 rounded-full object-cover border-4 border-white/50 shadow-lg" width="144" height="144" decoding="async"/>
    </div>

    <div class="relative z-10 flex w-full flex-col items-center justify-start px-4 pt-8 pb-20 sm:pb-24">
    <div class="w-full max-w-md">

        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center p-3 bg-white rounded-full shadow-[0_8px_24px_rgba(224,64,160,0.15)] mb-6 bouncy-hover cursor-pointer ring-2 ring-pink-100/80">
                <img src="{{ asset('images/logo.jpg') }}" alt="Akeira's Snack Inn" class="h-24 w-24 sm:h-28 sm:w-28 rounded-full object-cover" width="112" height="112" decoding="async"/>
            </div>
            <h1 class="text-4xl font-black tracking-tight text-primary mb-2">AKEIRA'S SNACK INN</h1>
            <p class="text-on-surface-variant font-medium">Create your staff account</p>
        </div>

        <div class="bg-white rounded-lg p-8 shadow-[0_20px_50px_rgba(224,64,160,0.1)] border border-surface-container-highest">

            @if ($errors->any())
                <div class="mb-6 px-4 py-3 rounded-2xl bg-error-container text-on-error-container text-sm font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">error</span>
                    {{ $errors->first() }}
                </div>
            @endif

            @include('partials.flash-status', [
                'wrapperClass' => 'mb-6 px-4 py-3 rounded-2xl bg-emerald-50 text-emerald-900 text-sm font-medium border border-emerald-200/80',
                'showIcon' => false,
            ])

            <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface ml-1">Username</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-xl">person</span>
                        <input
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            placeholder="Choose a username (used to sign in)"
                            autocomplete="username"
                            required
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-full focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline transition-all"
                        />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface ml-1">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-xl">mail</span>
                        <input
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            autocomplete="email"
                            required
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-full focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline transition-all"
                        />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface ml-1">Team code <span class="text-on-surface-variant font-medium">(optional)</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-xl">groups</span>
                        <input
                            name="team_code"
                            type="text"
                            value="{{ old('team_code') }}"
                            placeholder="Same Snack Inn as your manager"
                            autocomplete="off"
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-full focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline transition-all uppercase tracking-wider font-mono"
                        />
                    </div>
                    <p class="text-xs text-on-surface-variant ml-1 leading-relaxed">
                        Enter the code from the <strong class="text-on-surface">Dashboard</strong> so this account shares the same products, queue, and history.
                        Leave empty if your site uses a default shop.
                    </p>
                    @error('team_code')
                        <p class="text-sm font-bold text-error ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface ml-1">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-xl">lock</span>
                        <input
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            required
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-full focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline transition-all"
                        />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface ml-1">Confirm password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-xl">verified_user</span>
                        <input
                            name="password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            required
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-full focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline transition-all"
                        />
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full py-4 bg-secondary text-white font-black text-lg rounded-full shadow-[0_6px_20px_rgba(124,82,170,0.3)] bouncy-hover transition-all flex items-center justify-center gap-2 mt-2"
                >
                    Create account
                    <span class="material-symbols-outlined">person_add</span>
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-on-surface-variant">
                Already have an account?
                <a href="{{ route('login') }}" class="font-bold text-primary hover:text-secondary transition-colors">Log in</a>
            </p>

        </div>

        <p class="mt-6 max-w-md mx-auto text-center text-[11px] sm:text-xs leading-relaxed text-outline/50 select-none pointer-events-none" title="Application developer">
            <span class="block uppercase tracking-[0.2em] text-[10px] text-outline/40 mb-1">Developed by</span>
            <span class="font-bold text-primary/65">Carl Jay A. Cocamas</span>
            <span class="text-outline/45"> · 2026</span>
        </p>

    </div>
    </div>

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
