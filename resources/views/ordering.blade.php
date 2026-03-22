<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>AKEIRA'S SNACK INN - Order Products</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "error": "#e53e3e",
                        "on-secondary-container": "#2e2040",
                        "tertiary": "#0096cc",
                        "on-secondary-fixed": "#1a1030",
                        "on-tertiary-fixed": "#001a33",
                        "surface-container-high": "#f2e8f2",
                        "on-primary-fixed-variant": "#a02070",
                        "on-tertiary": "#ffffff",
                        "on-primary": "#ffffff",
                        "inverse-primary": "#f0a0cc",
                        "secondary-fixed": "#eedcff",
                        "surface-tint": "#e040a0",
                        "outline-variant": "#dcc8e0",
                        "surface-dim": "#e0d6e0",
                        "secondary": "#7c52aa",
                        "on-primary-container": "#2e1a28",
                        "inverse-surface": "#2e1a28",
                        "tertiary-container": "#40c0ee",
                        "surface": "#fef7ff",
                        "surface-container-low": "#fbf2fb",
                        "tertiary-fixed": "#c8eaff",
                        "on-secondary-fixed-variant": "#4a3068",
                        "background": "#fef7ff",
                        "secondary-container": "#eedcff",
                        "secondary-fixed-dim": "#c8a8e8",
                        "on-error-container": "#9b1c1c",
                        "on-background": "#2e1a28",
                        "inverse-on-surface": "#fef7ff",
                        "surface-bright": "#fef7ff",
                        "primary-container": "#f080c0",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#f0a0cc",
                        "primary-fixed": "#ffd6ee",
                        "on-tertiary-container": "#00334d",
                        "surface-variant": "#f2e8f2",
                        "on-tertiary-fixed-variant": "#005580",
                        "on-secondary": "#ffffff",
                        "on-surface-variant": "#604868",
                        "outline": "#907898",
                        "surface-container-lowest": "#ffffff",
                        "error-container": "#ffe8e8",
                        "surface-container-highest": "#ece2ec",
                        "primary": "#e040a0",
                        "on-primary-fixed": "#3d0028",
                        "surface-container": "#f8eef8",
                        "tertiary-fixed-dim": "#80d0f0",
                        "on-surface": "#2e1a28"
                    },
                    fontFamily: {
                        "headline": ["DM Sans", "sans-serif"],
                        "body": ["DM Sans", "sans-serif"],
                        "label": ["DM Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px"},
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .bouncy-hover:hover {
            transform: scale(1.03);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
    </style>
</head>
<body class="bg-background font-body text-on-background min-h-screen">
@php
    $cartItems = collect($cart);
    $itemCount = $cartItems->sum('quantity');
    $subtotal = $cartItems->sum(fn ($item) => $item['price'] * $item['quantity']);
    $total = round($subtotal, 2);
@endphp

<header class="fixed top-0 w-full z-50 border-b border-pink-100 bg-white/80 backdrop-blur-md shadow-[0_4px_16px_rgba(224,64,160,0.15)] flex justify-between items-center gap-2 px-4 sm:px-6 h-16">
    <div class="grid grid-cols-[2.75rem_minmax(0,1fr)] xl:grid-cols-1 items-center gap-2 sm:gap-3 flex-1 min-w-0 pr-1">
        @include('partials.mobile-nav-menu-button')
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            @include('partials.brand-logo', ['class' => 'h-9 w-9 sm:h-10 sm:w-10 shrink-0 rounded-full object-cover border-2 border-pink-100 bg-white shadow-sm'])
            <div class="text-xl sm:text-2xl font-black tracking-tight text-pink-600 truncate min-w-0">AKEIRA'S SNACK INN</div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <form method="GET" action="{{ route('ordering.index') }}" class="hidden md:flex relative">
            @if ($category)
                <input type="hidden" name="category" value="{{ $category }}">
            @endif
            <input name="search" value="{{ $search }}" class="pl-10 pr-4 py-2 rounded-full border-none bg-surface-container-high focus:ring-2 focus:ring-primary w-64 text-sm" placeholder="Search snacks..." type="text"/>
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
        </form>
        <div class="flex items-center gap-3">
            @include('partials.notification-bell')
            @include('partials.logout-trigger')
        </div>
    </div>
</header>

<aside class="h-screen w-64 fixed left-0 top-0 pt-20 border-r border-pink-100 bg-pink-50/50 hidden xl:flex flex-col gap-2 z-40">
    <div class="px-6 mb-6">
        <div class="flex items-center gap-3">
            @include('partials.brand-logo', ['class' => 'w-10 h-10 rounded-full object-cover border border-pink-100 bg-white shadow-sm shrink-0'])
            <div>
                <div class="text-sm font-black text-pink-600">Snack Admin</div>
                <div class="text-xs text-zinc-500">Inventory Manager</div>
            </div>
        </div>
    </div>
    <nav class="flex flex-col gap-2">
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm font-medium">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('products.index') }}">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="text-sm font-medium">Products</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]" href="{{ route('ordering.index') }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
            <span class="text-sm font-medium">Ordering</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('order-queue.index') }}">
            <span class="material-symbols-outlined">queue</span>
            <span class="text-sm font-medium">Order Queue</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('history.index') }}">
            <span class="material-symbols-outlined">history</span>
            <span class="text-sm font-medium">History</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('reports.index') }}">
            <span class="material-symbols-outlined">analytics</span>
            <span class="text-sm font-medium">Reports</span>
        </a>
    </nav>
</aside>

<main id="ordering-main" class="pt-20 min-h-screen pl-5 pr-5 sm:pl-6 sm:pr-6 xl:pl-[calc(16rem+1.5rem)] xl:pr-8 xl:pr-[calc(20rem+1.5rem)] {{ $itemCount > 0 ? 'pb-44 xl:pb-6' : 'pb-6' }}">
    <div class="w-full max-w-none">
    @include('partials.flash-status', ['excludeWhen' => 'Added to cart.'])
    @if ($errors->has('cart'))
        <div class="mb-6 px-4 py-3 rounded-2xl bg-error-container text-on-error-container text-sm font-bold flex items-center gap-2">
            <span class="material-symbols-outlined text-base">error</span>
            {{ $errors->first('cart') }}
        </div>
    @endif

    <header class="mb-8">
        <h1 class="text-3xl font-black text-on-background mb-2">Place an Order</h1>
        <p class="text-on-surface-variant">Browse our vibrant collection of treats for your shop.</p>
    </header>

    <div class="flex gap-3 mb-8 overflow-x-auto pb-2">
        <a href="{{ route('ordering.index', ['search' => $search]) }}" class="px-6 py-2 rounded-full font-bold shadow-[0_4px_12px_rgba(224,64,160,0.3)] whitespace-nowrap {{ !$category || $category === 'all' ? 'bg-primary text-white' : 'bg-white text-zinc-500 border border-zinc-200 hover:bg-zinc-100' }}">All Snacks</a>
        @foreach ($categories as $cat)
            @php
                $active = $category === $cat;
                $palette = match ($loop->index % 4) {
                    0 => 'text-secondary border-secondary/20 hover:bg-secondary-container',
                    1 => 'text-tertiary border-tertiary/20 hover:bg-tertiary-fixed',
                    2 => 'text-pink-700 border-pink-200 hover:bg-pink-100',
                    default => 'text-zinc-500 border-zinc-200 hover:bg-zinc-100',
                };
            @endphp
            <a href="{{ route('ordering.index', ['category' => $cat, 'search' => $search]) }}" class="px-6 py-2 font-bold rounded-full border transition-colors whitespace-nowrap {{ $active ? 'bg-primary text-white border-primary shadow-[0_4px_12px_rgba(224,64,160,0.3)]' : 'bg-white ' . $palette }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-lg p-4 shadow-[0_4px_16px_rgba(224,64,160,0.1)] bouncy-hover flex flex-col group">
                <div class="relative h-48 rounded-lg overflow-hidden mb-4">
                    @if ($product->image_path)
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"/>
                    @else
                        <div class="w-full h-full bg-pink-50 flex items-center justify-center p-6">
                            <img src="{{ asset('images/logo.jpg') }}" alt="" class="max-h-full max-w-full object-contain rounded-xl shadow-sm"/>
                        </div>
                    @endif
                    @if ($loop->first)
                        <span class="absolute top-2 right-2 bg-tertiary text-white text-xs font-bold px-3 py-1 rounded-full">New</span>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold mb-1">{{ $product->name }}</h3>
                    <p class="text-sm text-on-surface-variant mb-4">{{ $product->description ?: 'Fresh snack selection available now.' }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xl font-black text-pink-600">PHP {{ number_format((float) $product->price, 2) }}<span class="text-xs text-zinc-400 font-normal"> /{{ $product->unit }}</span></span>
                    <form method="POST" action="{{ route('ordering.cart.add') }}" data-ordering-cart-async>
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button class="bg-primary text-white p-2 rounded-full shadow-[0_4px_12px_rgba(224,64,160,0.3)] flex items-center justify-center active:scale-90 transition-transform" type="submit">
                            <span class="material-symbols-outlined">add_shopping_cart</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center">
                <p class="text-lg font-bold text-on-surface-variant">No products found for this filter.</p>
            </div>
        @endforelse
    </div>
    </div>
</main>

{{-- Mobile / tablet: floating cart (updated via fetch; host always in DOM for AJAX) --}}
<div id="ordering-cart-toast" class="fixed top-20 left-1/2 z-[55] -translate-x-1/2 rounded-full bg-zinc-900/90 text-white px-4 py-2 text-sm font-bold shadow-lg opacity-0 pointer-events-none scale-95 transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] max-w-[90vw] text-center" role="status" aria-live="polite"></div>

<div
    id="ordering-mobile-cart-host"
    class="xl:hidden fixed bottom-0 left-0 right-0 z-[45] pointer-events-none px-3 sm:px-4 transform transition-transform transition-opacity duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] will-change-transform {{ $itemCount > 0 ? '' : 'hidden' }}"
    style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom, 0px));"
    aria-label="Shopping cart"
    @if ($itemCount === 0) aria-hidden="true" @endif
>
    @if ($itemCount > 0)
        @include('partials.ordering-mobile-cart-float')
    @endif
</div>

<aside class="hidden xl:flex xl:flex-col fixed right-0 top-16 w-80 h-[calc(100vh-4rem)] bg-white border-l border-pink-100 rounded-l-2xl p-6 shadow-[-4px_0_16px_rgba(224,64,160,0.05)]">
    <div id="ordering-desktop-cart-inner" class="flex flex-col min-h-0 flex-1 h-full overflow-hidden">
        @include('partials.ordering-cart-panel', ['cartScrollClass' => 'flex-1 min-h-0 overflow-y-auto'])
    </div>
</aside>

{{-- Ensure Tailwind generates grid-row / motion classes used from JS --}}
<span class="hidden grid-rows-[0fr] grid-rows-[1fr] translate-y-full" aria-hidden="true"></span>

<script>
(function () {
    window.initOrderingMobileCartToggle = function () {
        var btn = document.getElementById('mobile-cart-floating-toggle');
        var icon = document.getElementById('mobile-cart-floating-toggle-icon');
        var panel = document.getElementById('mobile-floating-cart-panel');
        if (!btn || !icon || !panel) return;

        if (btn.dataset.cartToggleBound === '1') return;
        btn.dataset.cartToggleBound = '1';

        var expandable = document.getElementById('mobile-cart-expandable');
        var collapsedWrap = document.getElementById('mobile-cart-floating-collapsed');

        function setExpanded(expanded) {
            btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            btn.setAttribute('aria-label', expanded ? 'Collapse cart' : 'Expand cart');
            icon.style.transform = expanded ? 'rotate(0deg)' : 'rotate(180deg)';

            if (expandable) {
                expandable.setAttribute('aria-hidden', expanded ? 'false' : 'true');
                expandable.classList.toggle('grid-rows-[1fr]', expanded);
                expandable.classList.toggle('grid-rows-[0fr]', !expanded);
            }
            if (collapsedWrap) {
                collapsedWrap.setAttribute('aria-hidden', expanded ? 'true' : 'false');
                collapsedWrap.classList.toggle('grid-rows-[1fr]', !expanded);
                collapsedWrap.classList.toggle('grid-rows-[0fr]', expanded);
            }
            if (panel) {
                if (expanded) {
                    panel.classList.add('max-h-[min(55vh,28rem)]');
                } else {
                    panel.classList.remove('max-h-[min(55vh,28rem)]');
                }
            }
        }

        setExpanded(true);

        btn.addEventListener('click', function () {
            var isOpen = btn.getAttribute('aria-expanded') === 'true';
            setExpanded(!isOpen);
        });
    };

    window.initOrderingMobileCartToggle();

    function showOrderingToast(msg) {
        var el = document.getElementById('ordering-cart-toast');
        if (!el || !msg) return;
        el.textContent = msg;
        el.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
        el.classList.add('scale-100');
        clearTimeout(el._toastT);
        el._toastT = setTimeout(function () {
            el.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            el.classList.remove('scale-100');
        }, 2000);
    }

    function applyOrderingCartPayload(data) {
        if (!data || !data.ok) return;
        var ic = data.itemCount;
        var main = document.getElementById('ordering-main');
        var mobileHost = document.getElementById('ordering-mobile-cart-host');
        var desktopInner = document.getElementById('ordering-desktop-cart-inner');

        if (desktopInner && data.fragments && typeof data.fragments.desktop === 'string') {
            desktopInner.innerHTML = data.fragments.desktop;
        }
        if (mobileHost) {
            if (ic > 0 && data.fragments && data.fragments.mobile) {
                mobileHost.innerHTML = data.fragments.mobile;
                mobileHost.classList.remove('hidden');
                mobileHost.removeAttribute('aria-hidden');
                mobileHost.classList.add('translate-y-full', 'opacity-0');
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        mobileHost.classList.remove('translate-y-full', 'opacity-0');
                    });
                });
            } else {
                mobileHost.classList.add('translate-y-full', 'opacity-0');
                setTimeout(function () {
                    mobileHost.innerHTML = '';
                    mobileHost.classList.add('hidden');
                    mobileHost.classList.remove('translate-y-full', 'opacity-0');
                    mobileHost.setAttribute('aria-hidden', 'true');
                }, 280);
            }
        }
        if (main) {
            if (ic > 0) {
                main.classList.remove('pb-6');
                main.classList.add('pb-44', 'xl:pb-6');
            } else {
                main.classList.remove('pb-44', 'xl:pb-6');
                main.classList.add('pb-6');
            }
        }
        window.initOrderingMobileCartToggle();
        if (data.message) {
            showOrderingToast(data.message);
        }
    }

    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var csrf = csrfMeta ? csrfMeta.getAttribute('content') : '';

    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!(form instanceof HTMLFormElement)) return;
        if (!form.hasAttribute('data-ordering-cart-async')) return;
        e.preventDefault();
        if (!csrf) return;

        var fd = new FormData(form);
        var method = (form.getAttribute('method') || 'POST').toUpperCase();
        fetch(form.action, {
            method: method === 'GET' ? 'GET' : 'POST',
            body: method === 'GET' ? undefined : fd,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf,
            },
            credentials: 'same-origin',
        })
            .then(function (r) {
                return r.json().then(function (j) {
                    return { ok: r.ok, status: r.status, data: j };
                });
            })
            .then(function (res) {
                if (res.status === 422) {
                    var msg =
                        (res.data && res.data.message) ||
                        (res.data &&
                            res.data.errors &&
                            Object.values(res.data.errors)
                                .flat()
                                .join(' ')) ||
                        'Could not update cart.';
                    showOrderingToast(msg);
                    return;
                }
                if (!res.ok) {
                    showOrderingToast('Could not update cart.');
                    return;
                }
                if (res.data && res.data.ok === false) {
                    showOrderingToast(res.data.message || 'Error');
                    return;
                }
                applyOrderingCartPayload(res.data);
            })
            .catch(function () {
                showOrderingToast('Network error.');
            });
    });
})();
</script>

@include('partials.mobile-nav-drawer')
@include('partials.logout-modal')

</body>
</html>
