<!DOCTYPE html>
<html class="light scroll-smooth" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Welcome | Akeira's Snack Inn</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'on-tertiary-container': '#00334d',
                        'on-secondary-fixed-variant': '#4a3068',
                        'on-background': '#2e1a28',
                        'inverse-surface': '#2e1a28',
                        'tertiary': '#0096cc',
                        'surface-container-high': '#f2e8f2',
                        'inverse-on-surface': '#fef7ff',
                        'surface-variant': '#f2e8f2',
                        'surface-bright': '#fef7ff',
                        'background': '#fef7ff',
                        'surface-container-highest': '#ece2ec',
                        'surface-container': '#f8eef8',
                        'surface': '#fef7ff',
                        'on-surface': '#2e1a28',
                        'on-tertiary': '#ffffff',
                        'on-primary': '#ffffff',
                        'on-error-container': '#9b1c1c',
                        'primary-fixed-dim': '#f0a0cc',
                        'secondary-container': '#eedcff',
                        'on-tertiary-fixed': '#001a33',
                        'on-secondary-fixed': '#1a1030',
                        'inverse-primary': '#f0a0cc',
                        'tertiary-container': '#40c0ee',
                        'secondary-fixed-dim': '#c8a8e8',
                        'secondary-fixed': '#eedcff',
                        'primary-fixed': '#ffd6ee',
                        'on-error': '#ffffff',
                        'surface-container-low': '#fbf2fb',
                        'on-tertiary-fixed-variant': '#005580',
                        'tertiary-fixed-dim': '#80d0f0',
                        'primary': '#e040a0',
                        'secondary': '#7c52aa',
                        'primary-container': '#f080c0',
                        'on-primary-fixed-variant': '#a02070',
                        'outline-variant': '#dcc8e0',
                        'on-secondary-container': '#2e2040',
                        'on-secondary': '#ffffff',
                        'on-primary-fixed': '#3d0028',
                        'outline': '#907898',
                        'surface-container-lowest': '#ffffff',
                        'error': '#e53e3e',
                        'surface-tint': '#e040a0',
                        'surface-dim': '#e0d6e0',
                        'on-surface-variant': '#604868',
                        'on-primary-container': '#2e1a28',
                        'tertiary-fixed': '#c8eaff',
                        'error-container': '#ffe8e8',
                    },
                    fontFamily: {
                        headline: ['DM Sans', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif'],
                        label: ['DM Sans', 'sans-serif'],
                    },
                    borderRadius: { DEFAULT: '1rem', lg: '2rem', xl: '3rem', full: '9999px' },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background selection:bg-primary-fixed selection:text-on-primary-fixed font-body min-h-screen">
{{-- Top nav --}}
<nav class="fixed top-0 w-full border-b-2 border-pink-100 bg-white/80 backdrop-blur-md z-50 shadow-[0_4px_16px_rgba(224,64,160,0.15)]">
    <div class="flex justify-between items-center w-full px-4 sm:px-5 py-4 gap-4">
        <div class="flex items-center gap-4 sm:gap-8 min-w-0">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2 sm:gap-3 shrink-0 group">
                @include('partials.brand-logo', ['class' => 'h-9 w-9 sm:h-10 sm:w-10 rounded-full object-cover border-2 border-pink-100 bg-white shadow-sm'])
                <span class="text-lg sm:text-2xl font-black text-pink-600 tracking-tight font-headline truncate">Akeira's Snack Inn</span>
            </a>
            <div class="hidden md:flex gap-6 items-center" id="landing-nav-desktop">
                <a data-landing-nav="features" href="#features" class="landing-nav-link border-b-4 border-pink-500 pb-1 font-bold tracking-tight text-pink-600 transition-colors duration-200 hover:text-pink-600">Features</a>
                <a data-landing-nav="modules" href="#modules" class="landing-nav-link border-b-4 border-transparent pb-1 font-bold tracking-tight text-slate-600 transition-colors duration-200 hover:text-pink-500">Modules</a>
                <a data-landing-nav="how-it-works" href="#how-it-works" class="landing-nav-link border-b-4 border-transparent pb-1 font-bold tracking-tight text-slate-600 transition-colors duration-200 hover:text-pink-500">How it works</a>
            </div>
        </div>
        <div class="flex items-center gap-2 sm:gap-4 shrink-0">
            <a href="{{ route('login') }}" class="hidden sm:inline px-5 sm:px-8 py-2.5 sm:py-3 text-primary font-bold rounded-full hover:bg-primary-fixed/30 transition-colors">
                Log in
            </a>
            <a href="{{ route('register') }}" class="px-5 sm:px-8 py-2.5 sm:py-3 bg-primary text-on-primary rounded-full font-bold shadow-[0_4px_16px_rgba(224,64,160,0.2)] hover:scale-105 hover:shadow-[0_8px_24px_rgba(224,64,160,0.3)] transition-all duration-300 ease-out active:scale-95 text-sm sm:text-base text-center">
                Get started
            </a>
        </div>
    </div>
</nav>

{{-- Hero (Features) --}}
<header id="features" class="scroll-mt-28 pt-28 sm:pt-32 pb-16 sm:pb-20 w-full px-4 sm:px-5 relative overflow-hidden">
    <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary-fixed/30 rounded-full blur-3xl -z-10"></div>
    <div class="absolute top-40 -left-20 w-72 h-72 bg-tertiary-fixed/30 rounded-full blur-3xl -z-10"></div>
    <div class="flex flex-col items-center text-center space-y-8">
        <div class="inline-flex items-center px-4 py-2 bg-secondary-container text-on-secondary-container rounded-full font-bold text-sm tracking-wide">
            <span class="material-symbols-outlined mr-2 text-lg">storefront</span>
            Snack shop ops, without the spreadsheet chaos
        </div>
        <h1 class="text-4xl sm:text-6xl md:text-8xl font-black text-on-background tracking-tighter leading-tight">
            Streamline your<br/>
            <span class="text-primary italic">Snack Inn</span> workflow
        </h1>
        <p class="max-w-2xl text-lg sm:text-xl text-on-surface-variant font-medium leading-relaxed">
            Akeira's Snack Inn is your in-house system for <strong class="text-on-background font-bold">inventory</strong>,
            <strong class="text-on-background font-bold">ordering</strong>, <strong class="text-on-background font-bold">order queue</strong>,
            <strong class="text-on-background font-bold">history</strong>, and <strong class="text-on-background font-bold">reports</strong>—so you can
            stock combos &amp; snacks, serve the line, and see what sold—all in one place.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 pt-4 w-full sm:w-auto">
            <a href="{{ route('register') }}" class="inline-flex justify-center px-10 py-5 bg-primary text-on-primary rounded-full font-bold text-lg shadow-[0_8px_24px_rgba(224,64,160,0.25)] hover:scale-105 hover:shadow-[0_12px_32px_rgba(224,64,160,0.35)] transition-all duration-300 ease-out active:scale-95">
                Create an account
            </a>
            <a href="{{ route('login') }}" class="inline-flex justify-center px-10 py-5 bg-white border-2 border-primary/20 text-primary rounded-full font-bold text-lg hover:bg-primary-fixed/20 transition-all duration-300 active:scale-95">
                I already have access
            </a>
        </div>
    </div>
</header>

{{-- Modules (bento) --}}
<section id="modules" class="py-16 sm:py-24 w-full px-4 sm:px-5 scroll-mt-28">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-12">
        <div>
            <h2 class="text-3xl sm:text-4xl font-black text-on-background tracking-tight">What’s inside the system</h2>
            <p class="text-on-surface-variant font-medium mt-2 max-w-xl">The same tools your team uses in the app—laid out so you know what you’re signing up for.</p>
        </div>
        <a href="{{ route('login') }}" class="text-primary font-bold flex items-center gap-2 hover:translate-x-2 transition-transform shrink-0">
            Open the app <span class="material-symbols-outlined">arrow_forward</span>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        {{-- Products & inventory --}}
        <div class="md:col-span-8 group relative overflow-hidden bg-white rounded-lg p-8 shadow-[0_4px_16px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_32px_rgba(224,64,160,0.15)] transition-all duration-300 hover:-translate-y-2 border border-pink-50">
            <div class="flex flex-col md:flex-row justify-between gap-8 h-full">
                <div class="space-y-4 max-w-md">
                    <span class="px-4 py-1 bg-primary-fixed text-on-primary-fixed-variant rounded-full font-bold text-xs uppercase tracking-widest">Inventory</span>
                    <h3 class="text-3xl font-black text-on-background">Products &amp; stock</h3>
                    <p class="text-on-surface-variant">Maintain your snack and combo catalog with prices, units, categories, images, and on-hand stock. Low-stock awareness on the dashboard helps you reorder before you run out.</p>
                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        <div class="flex items-center gap-2 text-sm font-bold text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary text-xl">inventory_2</span>
                            CRUD catalog
                        </div>
                        <div class="h-8 w-[2px] bg-slate-100 hidden sm:block"></div>
                        <div class="flex items-center gap-2 text-sm font-bold text-on-surface-variant">
                            <span class="material-symbols-outlined text-tertiary text-xl">category</span>
                            Categories &amp; search
                        </div>
                    </div>
                </div>
                <div class="flex-1 min-h-[200px] relative rounded-lg overflow-hidden bg-gradient-to-br from-pink-100 via-primary-fixed/40 to-secondary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-[120px] text-primary/30 group-hover:scale-110 transition-transform duration-500" style="font-variation-settings: 'FILL' 1;">lunch_dining</span>
                </div>
            </div>
        </div>
        {{-- Ordering --}}
        <div class="md:col-span-4 group relative overflow-hidden bg-white rounded-lg p-8 shadow-[0_4px_16px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_32px_rgba(124,82,170,0.15)] transition-all duration-300 hover:-translate-y-2 border border-purple-50">
            <div class="space-y-6">
                <div class="h-48 rounded-lg bg-secondary-container overflow-hidden flex items-center justify-center">
                    <span class="material-symbols-outlined text-[80px] text-secondary/40 group-hover:scale-110 transition-transform duration-500" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                </div>
                <div class="space-y-2">
                    <span class="px-4 py-1 bg-secondary-fixed text-on-secondary-fixed-variant rounded-full font-bold text-xs uppercase tracking-widest">Ordering</span>
                    <h3 class="text-2xl font-black text-on-background">Place an order</h3>
                    <p class="text-on-surface-variant text-sm">Browse the menu, build a cart, and place orders into the system—ready for the queue or counter workflow.</p>
                </div>
            </div>
        </div>
        {{-- Order queue --}}
        <div class="md:col-span-4 group relative overflow-hidden bg-white rounded-lg p-8 shadow-[0_4px_16px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_32px_rgba(0,150,204,0.15)] transition-all duration-300 hover:-translate-y-2 border border-sky-50">
            <div class="space-y-6">
                <div class="h-48 rounded-lg bg-tertiary-container/40 overflow-hidden flex items-center justify-center">
                    <span class="material-symbols-outlined text-[80px] text-tertiary/50 group-hover:scale-110 transition-transform duration-500" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
                </div>
                <div class="space-y-2">
                    <span class="px-4 py-1 bg-tertiary-fixed text-on-tertiary-fixed-variant rounded-full font-bold text-xs uppercase tracking-widest">Operations</span>
                    <h3 class="text-2xl font-black text-on-background">Order queue</h3>
                    <p class="text-on-surface-variant text-sm">See pending tickets, adjust line items, add another product, finish orders, or move them aside and restore later—without losing line detail.</p>
                </div>
            </div>
        </div>
        {{-- Reports CTA --}}
        <div class="md:col-span-8 bg-gradient-to-br from-primary to-secondary rounded-lg p-10 relative overflow-hidden shadow-[0_4px_24px_rgba(224,64,160,0.2)]">
            <div class="absolute top-0 right-0 p-8 opacity-10">
                <span class="material-symbols-outlined text-[160px] text-white" style="font-variation-settings: 'FILL' 1;">bar_chart</span>
            </div>
            <div class="relative z-10 space-y-6 max-w-lg">
                <h3 class="text-3xl sm:text-4xl font-black text-white leading-tight">History &amp; reports that match your sales</h3>
                <p class="text-primary-fixed font-medium text-lg">Review completed and removed orders, then dig into revenue, units sold, category mix, and top products—filtered by month when you need it.</p>
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-primary rounded-full font-bold text-lg hover:bg-primary-fixed transition-colors active:scale-95">
                    Start using Snack Inn
                </a>
            </div>
        </div>
    </div>
</section>

{{-- How it works --}}
<section id="how-it-works" class="py-16 sm:py-24 bg-surface-container-low rounded-[28px] sm:rounded-[40px] mx-3 sm:mx-4 scroll-mt-28">
    <div class="w-full px-4 sm:px-5 grid md:grid-cols-2 gap-12 md:gap-16 items-center">
        <div class="relative order-2 md:order-1">
            <div class="aspect-square bg-white rounded-lg p-4 shadow-xl rotate-3 hover:rotate-0 transition-transform duration-500 max-w-md mx-auto md:max-w-none">
                <div class="w-full h-full rounded-lg bg-gradient-to-br from-pink-100 via-surface-container to-tertiary-fixed/30 overflow-hidden relative flex items-center justify-center">
                    <div class="text-center p-8">
                        <span class="material-symbols-outlined text-7xl text-primary/40 mb-4" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                        <p class="font-black text-on-background text-lg">Dashboard, notifications, and quick signals for today’s work.</p>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/20 to-transparent pointer-events-none"></div>
                </div>
            </div>
            <div class="absolute -bottom-4 sm:-bottom-6 -left-2 sm:-left-6 bg-tertiary text-white p-4 sm:p-6 rounded-lg shadow-xl -rotate-2 max-w-[200px] sm:max-w-none">
                <span class="material-symbols-outlined text-3xl sm:text-4xl mb-2">verified_user</span>
                <div class="font-black text-lg sm:text-xl">Team sign-in</div>
                <div class="text-xs sm:text-sm opacity-90">Accounts for staff who run the inn.</div>
            </div>
        </div>
        <div class="space-y-8 order-1 md:order-2">
            <h2 class="text-4xl sm:text-5xl font-black text-on-background tracking-tight">How it works</h2>
            <div class="space-y-6">
                <div class="flex gap-6">
                    <div class="w-12 h-12 shrink-0 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-black text-xl">1</div>
                    <div>
                        <h4 class="text-xl font-bold text-on-background">Load your menu</h4>
                        <p class="text-on-surface-variant">Add products—combos, snacks, drinks—with prices, units, stock, and categories so the ordering page and queue always show what you actually sell.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-12 h-12 shrink-0 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary font-black text-xl">2</div>
                    <div>
                        <h4 class="text-xl font-bold text-on-background">Sell &amp; queue</h4>
                        <p class="text-on-surface-variant">Take orders from the catalog; they land in the <strong class="text-on-background">order queue</strong> as pending tickets you can edit, add to, finish, or park and restore.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-12 h-12 shrink-0 rounded-full bg-tertiary-fixed flex items-center justify-center text-tertiary font-black text-xl">3</div>
                    <div>
                        <h4 class="text-xl font-bold text-on-background">Learn from the day</h4>
                        <p class="text-on-surface-variant">Use <strong class="text-on-background">history</strong> for the paper trail and <strong class="text-on-background">reports</strong> for revenue, volume, and bestsellers—so the next restock and promo call is obvious.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="w-full rounded-t-[40px] mt-12 bg-pink-50">
    <div class="flex flex-col md:flex-row justify-between items-center w-full px-4 sm:px-5 py-12 gap-8">
        <div class="flex flex-col items-center md:items-start gap-2 text-center md:text-left">
            <span class="text-lg font-bold text-pink-600">Akeira's Snack Inn</span>
            <p class="text-sm font-medium text-slate-500">© {{ date('Y') }} Akeira's Snack Inn. Stock smart, serve fast.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-6 sm:gap-8">
            <a class="text-sm font-medium text-slate-500 hover:text-pink-500 transition-all duration-200" href="{{ route('login') }}">Log in</a>
            <a class="text-sm font-medium text-slate-500 hover:text-pink-500 transition-all duration-200" href="{{ route('register') }}">Register</a>
        </div>
        <div class="flex gap-4">
            <span class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-pink-600 shadow-sm material-symbols-outlined text-xl" title="Snack ready">fastfood</span>
            <span class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-pink-600 shadow-sm material-symbols-outlined text-xl" title="Orders">orders</span>
        </div>
    </div>
</footer>
<script>
(function () {
    var sectionIds = ['features', 'modules', 'how-it-works'];
    var links = document.querySelectorAll('[data-landing-nav]');
    if (!links.length) return;

    /** While smooth-scrolling to a nav target, scroll events still see the old position and would reset the underline. */
    var clickLockId = null;
    var clickLockUntil = 0;
    var CLICK_LOCK_MS = 1100;

    function setActive(id) {
        links.forEach(function (a) {
            var on = a.getAttribute('data-landing-nav') === id;
            a.classList.toggle('text-pink-600', on);
            a.classList.toggle('border-pink-500', on);
            a.classList.toggle('text-slate-600', !on);
            a.classList.toggle('border-transparent', !on);
        });
    }

    function currentSection() {
        var navOffset = 96;
        var y = window.scrollY + navOffset;
        var active = 'features';
        for (var i = 0; i < sectionIds.length; i++) {
            var el = document.getElementById(sectionIds[i]);
            if (el && y >= el.offsetTop - 8) {
                active = sectionIds[i];
            }
        }
        return active;
    }

    function sync() {
        if (clickLockId && Date.now() < clickLockUntil) {
            setActive(clickLockId);
            return;
        }
        clickLockId = null;
        setActive(currentSection());
    }

    function clearClickLock() {
        clickLockId = null;
        clickLockUntil = 0;
        setActive(currentSection());
    }

    window.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync, { passive: true });
    document.addEventListener('DOMContentLoaded', sync);
    if ('onscrollend' in window) {
        window.addEventListener('scrollend', clearClickLock, { passive: true });
    }

    links.forEach(function (a) {
        a.addEventListener('click', function () {
            var id = a.getAttribute('data-landing-nav');
            if (!id) return;
            clickLockId = id;
            clickLockUntil = Date.now() + CLICK_LOCK_MS;
            setActive(id);
        });
    });
})();
</script>
</body>
</html>
