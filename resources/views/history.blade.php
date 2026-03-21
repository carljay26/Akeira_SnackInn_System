<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>AKEIRA'S SNACK INN - Order History</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
                        "headline": ["DM Sans"],
                        "body": ["DM Sans"],
                        "label": ["DM Sans"]
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
        body { font-family: 'DM Sans', sans-serif; }

        .order-dropdown {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.28s ease;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen">

<header class="fixed top-0 w-full z-50 border-b border-pink-100 bg-white/80 backdrop-blur-md shadow-[0_4px_16px_rgba(224,64,160,0.15)] flex justify-between items-center px-6 h-16">
    <div class="text-2xl font-black tracking-tight text-pink-600">AKEIRA'S SNACK INN</div>
    <div class="flex items-center gap-4">
        <form method="GET" action="{{ route('history.index') }}" class="hidden md:flex relative">
            @if(request('date'))
                <input type="hidden" name="date" value="{{ request('date') }}"/>
            @endif
            <input
                name="search"
                value="{{ request('search') }}"
                class="pl-10 pr-4 py-2 rounded-full border-none bg-surface-container-high focus:ring-2 focus:ring-primary w-64 text-sm"
                placeholder="Search history..."
                type="text"
            />
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
        </form>
        <div class="flex items-center gap-3">
            @include('partials.notification-bell')
            @include('partials.logout-trigger')
        </div>
    </div>
</header>

<aside class="h-screen w-64 fixed left-0 top-0 pt-20 border-r border-pink-100 bg-pink-50/50 flex flex-col gap-2 z-40 hidden lg:flex">
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
            <span class="font-medium text-sm">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('products.index') }}">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-medium text-sm">Products</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('ordering.index') }}">
            <span class="material-symbols-outlined">shopping_cart</span>
            <span class="font-medium text-sm">Ordering</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('order-queue.index') }}">
            <span class="material-symbols-outlined">queue</span>
            <span class="font-medium text-sm">Order Queue</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]" href="{{ route('history.index') }}">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">history</span>
            <span class="font-medium text-sm">History</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('reports.index') }}">
            <span class="material-symbols-outlined">analytics</span>
            <span class="font-medium text-sm">Reports</span>
        </a>
    </nav>
</aside>

<main class="pt-20 min-h-screen pb-24 py-6 pl-5 pr-5 sm:pl-6 sm:pr-6 lg:pl-[calc(16rem+1.5rem)] lg:pr-8 xl:pr-[calc(20rem+1.5rem)]">
    <div class="w-full max-w-none">

        @include('partials.flash-status')

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-black text-on-surface tracking-tight mb-2">Order History</h1>
                <p class="text-on-surface-variant font-medium">Keep track of all your snack shipments and restocks.</p>
                @if (!empty($validDate) && $filterDate && isset($ordersOnSelectedDay))
                    <p class="text-primary font-black text-sm mt-2">
                        {{ number_format($ordersOnSelectedDay) }} {{ $ordersOnSelectedDay === 1 ? 'order' : 'orders' }} on {{ \Carbon\Carbon::parse($filterDate)->format('M d, Y') }}
                    </p>
                @endif
            </div>
            <form method="GET" action="{{ route('history.index') }}" class="flex flex-wrap items-center gap-3">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}"/>
                @endif
                <label class="flex items-center gap-2 bg-white border-2 border-pink-100 px-4 py-2 rounded-full font-bold text-pink-600 shadow-[0_4px_12px_rgba(224,64,160,0.1)] hover:scale-105 active:scale-95 transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-xl">calendar_today</span>
                    <input
                        type="date"
                        name="date"
                        value="{{ $filterDate ?? '' }}"
                        class="bg-transparent border-none focus:ring-0 text-sm font-bold text-on-surface max-w-[11rem]"
                        onchange="this.form.submit()"
                    />
                </label>
                @if(!empty($filterDate))
                    <a href="{{ route('history.index', array_filter(['search' => request('search')])) }}" class="text-sm font-bold text-tertiary hover:underline">Clear date</a>
                @endif
            </form>
        </div>

        {{-- Stats Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-primary-container p-6 rounded-lg shadow-[0_4px_20px_rgba(224,64,160,0.15)] flex flex-col justify-between h-40">
                <span class="material-symbols-outlined text-on-primary-container text-3xl">shopping_bag</span>
                <div>
                    <div class="text-on-primary-container font-bold text-3xl">{{ number_format($totalOrdersCount) }}</div>
                    <div class="text-on-primary-container/80 text-sm font-bold uppercase tracking-wider">Total Orders</div>
                </div>
            </div>
            <div class="bg-tertiary-container p-6 rounded-lg shadow-[0_4px_20px_rgba(0,150,204,0.15)] flex flex-col justify-between h-40">
                <span class="material-symbols-outlined text-on-tertiary-container text-3xl">payments</span>
                <div>
                    <div class="text-on-tertiary-container font-bold text-3xl">PHP {{ number_format((float) $totalSales, 0) }}</div>
                    <div class="text-on-tertiary-container/80 text-sm font-bold uppercase tracking-wider">Total Sales</div>
                </div>
            </div>
        </div>

        {{-- Orders List --}}
        <div class="grid gap-4">
            @forelse ($orders as $order)
                @php
                    $itemCount = $order->items->sum('quantity');
                    $iconBgs = ['bg-primary-fixed text-primary', 'bg-secondary-fixed text-secondary', 'bg-tertiary-fixed text-tertiary', 'bg-surface-container-high text-zinc-400'];
                    $icons   = ['receipt_long', 'local_shipping', 'package_2', 'receipt_long'];
                    $idx     = $loop->index % 4;

                    $statusStyle = match($order->status) {
                        'completed' => 'bg-emerald-100 text-emerald-700 dot-bg-emerald-500',
                        'pending'   => 'bg-amber-100 text-amber-700',
                        'cancelled' => 'bg-zinc-100 text-zinc-500',
                        default     => 'bg-zinc-100 text-zinc-500',
                    };
                    $dotColor = match($order->status) {
                        'completed' => 'bg-emerald-500',
                        'pending'   => 'bg-amber-500',
                        default     => 'bg-zinc-400',
                    };
                    $opacity = $order->status === 'cancelled' ? 'opacity-80' : '';
                @endphp

                <div class="bg-white rounded-lg border border-pink-50 shadow-[0_4px_20px_rgba(224,64,160,0.06)] hover:shadow-[0_8px_24px_rgba(224,64,160,0.12)] hover:scale-[1.01] transition-all {{ $opacity }}">
                    <div class="p-4 md:p-6 flex flex-col md:flex-row items-center justify-between gap-6">

                        {{-- Reference + date --}}
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <div class="w-14 h-14 {{ $iconBgs[$idx] }} rounded-full flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-2xl">{{ $icons[$idx] }}</span>
                            </div>
                            <div>
                                <div class="font-black text-lg text-on-surface">Order #{{ $order->id }}</div>
                                <div class="text-on-surface-variant text-sm font-medium">
                                    {{ optional($order->ordered_at ?? $order->created_at)->timezone('Asia/Manila')->format('M d, Y • g:i A') }}
                                </div>
                            </div>
                        </div>

                        {{-- Status / Items / Total --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 w-full md:w-auto flex-1 md:px-8">
                            <div>
                                <div class="text-zinc-400 text-xs font-bold uppercase tracking-widest mb-1">Status</div>
                                <span class="px-4 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-fit {{ $statusStyle }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <div class="text-zinc-400 text-xs font-bold uppercase tracking-widest mb-1">Items</div>
                                <div class="text-on-surface font-bold">{{ number_format($itemCount) }} {{ $itemCount === 1 ? 'Item' : 'Items' }}</div>
                            </div>
                            <div>
                                <div class="text-zinc-400 text-xs font-bold uppercase tracking-widest mb-1">Total</div>
                                <div class="text-pink-600 font-black text-lg {{ $order->status === 'cancelled' ? 'text-zinc-500' : '' }}">
                                    PHP {{ number_format((float) $order->total, 2) }}
                                </div>
                            </div>
                        </div>

                        {{-- View Details button --}}
                        <button
                            type="button"
                            onclick="toggleOrderDetails('order-details-{{ $order->id }}', this)"
                            class="w-full md:w-auto bg-pink-50 text-pink-600 px-6 py-3 rounded-full font-bold hover:bg-pink-100 active:scale-95 transition-all whitespace-nowrap"
                        >
                            View Details
                        </button>
                    </div>

                    <div id="order-details-{{ $order->id }}" class="order-dropdown border-t border-pink-50">
                        <div class="p-4 md:p-6 bg-pink-50/20">
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <span class="text-sm font-black text-on-surface">Reference: {{ $order->reference }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusStyle }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                @forelse ($order->items as $item)
                                    @php
                                        $unitLabel = trim((string) (optional($item->product)->unit ?? 'pcs'));
                                        $unitLabel = preg_replace('/^\d+\s*/', '', $unitLabel) ?: 'pcs';
                                    @endphp
                                    <div class="flex items-center gap-4 p-3 rounded-2xl bg-white border border-pink-50">
                                        @if ($item->product?->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded-lg object-cover shrink-0"/>
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1;">lunch_dining</span>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-on-surface">{{ optional($item->product)->name ?? 'Deleted Product' }}</p>
                                            <p class="text-xs text-zinc-400">{{ $item->quantity }} {{ $unitLabel }} × PHP {{ number_format((float) $item->unit_price, 2) }}</p>
                                        </div>
                                        <span class="text-sm font-black text-pink-600 shrink-0">PHP {{ number_format((float) $item->line_total, 2) }}</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-zinc-400 py-2">No items found.</p>
                                @endforelse
                            </div>

                            <div class="mt-4 pt-4 border-t border-pink-100 space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-zinc-500 font-medium">Subtotal</span>
                                    <span class="font-bold text-on-background">PHP {{ number_format((float) $order->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-zinc-500 font-medium">Total</span>
                                    <span class="font-black text-pink-600">PHP {{ number_format((float) $order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-20 flex flex-col items-center gap-4 text-zinc-400">
                    <span class="material-symbols-outlined text-6xl">receipt_long</span>
                    <p class="text-lg font-bold">No orders yet</p>
                    <a href="{{ route('ordering.index') }}" class="text-primary font-bold hover:underline text-sm">Place your first order</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($orders->hasPages())
            <div class="mt-12 flex items-center justify-center gap-2">
                @if ($orders->onFirstPage())
                    <span class="w-10 h-10 rounded-full border-2 border-pink-100 flex items-center justify-center text-pink-300 cursor-not-allowed">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" class="w-10 h-10 rounded-full border-2 border-pink-100 flex items-center justify-center text-pink-600 hover:bg-pink-50 transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>
                @endif

                @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                    @if ($page == $orders->currentPage())
                        <span class="w-10 h-10 rounded-full bg-primary text-on-primary font-bold shadow-[0_4px_12px_rgba(224,64,160,0.3)] flex items-center justify-center">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-10 h-10 rounded-full text-zinc-500 font-bold hover:bg-pink-50 transition-colors flex items-center justify-center">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" class="w-10 h-10 rounded-full border-2 border-pink-100 flex items-center justify-center text-pink-600 hover:bg-pink-50 transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                @else
                    <span class="w-10 h-10 rounded-full border-2 border-pink-100 flex items-center justify-center text-pink-300 cursor-not-allowed">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </span>
                @endif
            </div>
        @endif

    </div>
</main>

<aside class="hidden xl:flex fixed right-0 top-16 w-80 h-[calc(100vh-4rem)] bg-white border-l border-pink-100 rounded-l-2xl p-6 flex-col shadow-[-4px_0_16px_rgba(224,64,160,0.05)]">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-pink-600">sell</span>
        <h3 class="text-sm font-black text-pink-700 uppercase tracking-wider">Items Sold</h3>
    </div>

    <div class="space-y-2 overflow-y-auto pr-1">
        @forelse ($soldItemsSummary as $soldItem)
            <div class="rounded-2xl border border-pink-100 bg-pink-50/30 px-3 py-2 flex items-center justify-between gap-2">
                <div class="flex items-center gap-2 min-w-0">
                    @if (!empty($soldItem->image_path))
                        <img
                            src="{{ asset('storage/' . $soldItem->image_path) }}"
                            alt="{{ $soldItem->name }}"
                            class="w-9 h-9 rounded-lg object-cover shrink-0"
                        />
                    @else
                        <div class="w-9 h-9 rounded-lg bg-primary-fixed flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary text-base" style="font-variation-settings:'FILL' 1;">lunch_dining</span>
                        </div>
                    @endif
                    <p class="text-sm font-bold text-on-surface truncate">{{ $soldItem->name }}</p>
                </div>
                <p class="text-xs font-black text-pink-700 whitespace-nowrap">{{ number_format((int) $soldItem->total_sold) }} pcs</p>
            </div>
        @empty
            <p class="text-xs text-zinc-500">No sold items for this filter yet.</p>
        @endforelse
    </div>
</aside>

{{-- ─── Mobile Bottom Nav ────────────────────────────────────────── --}}
<nav class="md:hidden fixed bottom-0 w-full bg-white/90 backdrop-blur-lg border-t border-pink-100 px-6 py-3 flex justify-around items-center z-50">
    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-zinc-400">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-[10px] font-bold">Home</span>
    </a>
    <a href="{{ route('products.index') }}" class="flex flex-col items-center gap-1 text-zinc-400">
        <span class="material-symbols-outlined">inventory_2</span>
        <span class="text-[10px] font-bold">Products</span>
    </a>
    <a href="{{ route('history.index') }}" class="flex flex-col items-center gap-1 text-pink-600">
        <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">history</span>
        <span class="text-[10px] font-bold">History</span>
    </a>
    <a href="{{ route('reports.index') }}" class="flex flex-col items-center gap-1 text-zinc-400">
        <span class="material-symbols-outlined">analytics</span>
        <span class="text-[10px] font-bold">Reports</span>
    </a>
</nav>

<script>
    function toggleOrderDetails(id, button) {
        const panel = document.getElementById(id);
        const isOpen = panel.style.maxHeight && panel.style.maxHeight !== '0px';

        document.querySelectorAll('.order-dropdown').forEach(el => {
            if (el.id !== id) {
                el.style.maxHeight = '0px';
            }
        });

        if (isOpen) {
            panel.style.maxHeight = '0px';
            button.textContent = 'View Details';
        } else {
            panel.style.maxHeight = panel.scrollHeight + 'px';
            button.textContent = 'Hide Details';
        }
    }
</script>

@include('partials.logout-modal')

</body>
</html>
