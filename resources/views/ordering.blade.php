<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
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

<header class="fixed top-0 w-full z-50 border-b border-pink-100 bg-white/80 backdrop-blur-md shadow-[0_4px_16px_rgba(224,64,160,0.15)] flex justify-between items-center px-6 h-16">
    <div class="text-2xl font-black tracking-tight text-pink-600">AKEIRA'S SNACK INN</div>
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

<aside class="h-screen w-64 fixed left-0 top-0 pt-20 border-r border-pink-100 bg-pink-50/50 hidden lg:flex flex-col gap-2 z-40">
    <div class="px-6 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">lunch_dining</span>
            </div>
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

<main class="pt-20 min-h-screen pb-24 py-6 pl-5 pr-5 sm:pl-6 sm:pr-6 lg:pl-[calc(16rem+1.5rem)] lg:pr-8 xl:pr-[calc(20rem+1.5rem)]">
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
                        <div class="w-full h-full bg-primary-fixed flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-6xl" style="font-variation-settings:'FILL' 1;">lunch_dining</span>
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
                    <form method="POST" action="{{ route('ordering.cart.add') }}">
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

<aside class="hidden xl:flex fixed right-0 top-16 w-80 h-[calc(100vh-4rem)] bg-white border-l border-pink-100 rounded-l-2xl p-6 flex-col shadow-[-4px_0_16px_rgba(224,64,160,0.05)]">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-xl font-black text-pink-600 flex items-center gap-2">
            <span class="material-symbols-outlined">shopping_basket</span>
            My Cart
        </h2>
        <span class="bg-pink-100 text-pink-600 text-xs font-bold px-2 py-1 rounded-full">{{ $itemCount }} Items</span>
    </div>

    <div class="flex-1 overflow-y-auto space-y-4 pr-2">
        @forelse ($cartItems as $item)
            @php
                $unitLabel = trim((string) ($item['unit'] ?? 'pcs'));
                $unitLabel = preg_replace('/^\d+\s*/', '', $unitLabel) ?: 'pcs';
            @endphp
            <div class="flex gap-3 items-center p-2 rounded-lg hover:bg-pink-50 transition-colors">
                @if (!empty($item['image_path']))
                    <img class="w-12 h-12 rounded-lg object-cover" src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}"/>
                @else
                    <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1;">lunch_dining</span>
                    </div>
                @endif
                <div class="flex-1">
                    <h4 class="text-sm font-bold">{{ $item['name'] }}</h4>
                    <p class="text-xs text-zinc-500">{{ $item['quantity'] }} {{ $unitLabel }} x PHP {{ number_format((float) $item['price'], 2) }}</p>
                </div>
                <div class="text-right">
                    <span class="text-sm font-black text-pink-600 block">PHP {{ number_format($item['quantity'] * $item['price'], 2) }}</span>
                    <div class="mt-1 inline-flex items-center gap-2 rounded-full border border-pink-100 bg-pink-50 px-2 py-1">
                        <form method="POST" action="{{ route('ordering.cart.decrement', $item['id']) }}">
                            @csrf
                            @method('PATCH')
                            <button class="w-5 h-5 flex items-center justify-center rounded-full text-pink-600 hover:bg-pink-100 font-black leading-none" type="submit" aria-label="Decrease quantity">-</button>
                        </form>
                        <span class="text-xs font-black text-zinc-600 min-w-4 text-center">{{ $item['quantity'] }}</span>
                        <form method="POST" action="{{ route('ordering.cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <input type="hidden" name="quantity" value="1">
                            <button class="w-5 h-5 flex items-center justify-center rounded-full text-pink-600 hover:bg-pink-100 font-black leading-none" type="submit" aria-label="Increase quantity">+</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-zinc-500 font-medium">Your cart is empty.</p>
        @endforelse
    </div>

    <div class="border-t border-pink-100 pt-6 mt-6">
        <div class="flex justify-between mb-2">
            <span class="text-zinc-500">Subtotal</span>
            <span class="font-bold">PHP {{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="flex justify-between mb-6">
            <span class="text-lg font-black">Total</span>
            <span class="text-lg font-black text-pink-600">PHP {{ number_format($total, 2) }}</span>
        </div>
        <form method="POST" action="{{ route('ordering.place-order') }}">
            @csrf
            <button class="w-full bg-primary text-white py-4 rounded-full font-black shadow-[0_4px_16px_rgba(224,64,160,0.3)] bouncy-hover active:scale-95 flex items-center justify-center gap-2 {{ $itemCount === 0 ? 'opacity-60 cursor-not-allowed' : '' }}" type="submit" {{ $itemCount === 0 ? 'disabled' : '' }}>
                Place Order
                <span class="material-symbols-outlined">send</span>
            </button>
        </form>
    </div>
</aside>

@include('partials.logout-modal')

</body>
</html>
