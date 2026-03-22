<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>AKEIRA'S SNACK INN - Dashboard</title>
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
                    borderRadius: {"DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px"},
                },
            },
        };
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .bouncy-hover { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .bouncy-hover:hover { transform: scale(1.03); }
    </style>
</head>
<body class="bg-background text-on-background selection:bg-primary-fixed selection:text-on-primary-fixed">
@php
    $maxQty = (int) ($popularProducts->max('total_qty') ?? 0);
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
        <form method="GET" action="{{ route('dashboard') }}" class="hidden md:flex relative">
            <input
                name="search"
                value="{{ request('search') }}"
                class="pl-10 pr-4 py-2 rounded-full border-none bg-surface-container-high focus:ring-2 focus:ring-primary w-64 text-sm"
                placeholder="Search dashboard..."
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

<aside class="h-screen w-64 fixed left-0 top-0 pt-20 border-r border-pink-100 bg-pink-50/50 flex flex-col gap-2 z-40 hidden xl:flex">
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
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <span class="text-sm font-medium">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('products.index') }}">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="text-sm font-medium">Products</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('ordering.index') }}">
            <span class="material-symbols-outlined">shopping_cart</span>
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

<main class="pt-20 min-h-screen pb-6 py-6 pl-5 pr-5 sm:pl-6 sm:pr-6 xl:pr-8 xl:pl-[calc(16rem+1.5rem)]">
    <div class="w-full max-w-none">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-on-background tracking-tight">Akeira's Overview</h1>
                <p class="text-zinc-500 font-medium">Welcome back!</p>
            </div>
            <a href="{{ route('ordering.index') }}" class="px-6 py-3 bg-primary text-white font-bold flex items-center gap-2 rounded-full shadow-[0_4px_16px_rgba(224,64,160,0.3)] bouncy-hover active:scale-95 transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                New Order
            </a>
        </div>

        @if (! empty($shop))
            <div class="mb-8 rounded-2xl border border-pink-100 bg-gradient-to-r from-pink-50/90 to-secondary-container/30 px-4 py-4 sm:px-5 sm:py-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs font-black uppercase tracking-wider text-pink-600">Shared workspace</p>
                    <p class="text-base font-black text-on-background mt-0.5 truncate">{{ $shop->name }}</p>
                    <p class="text-sm text-on-surface-variant mt-1">New staff accounts can enter this team code when they register to use the same menu, order queue, and reports.</p>
                </div>
                <div class="shrink-0 flex flex-col items-stretch sm:items-end gap-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Team code</span>
                    <code class="font-mono text-xl sm:text-2xl font-black tracking-[0.2em] bg-white px-4 py-2 rounded-xl border-2 border-pink-200 text-pink-600 shadow-sm select-all">{{ $shop->invite_code }}</code>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-[0_4px_16px_rgba(224,64,160,0.08)] border border-pink-50 bouncy-hover">
                <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">payments</span>
                </div>
                <p class="text-zinc-500 text-sm font-bold uppercase tracking-wider">Total Revenue</p>
                <h3 class="text-2xl font-black text-on-background mt-1">PHP {{ number_format((float) $todayRevenue, 2) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-[0_4px_16px_rgba(124,82,170,0.08)] border border-pink-50 bouncy-hover">
                <div class="w-12 h-12 rounded-full bg-secondary-fixed flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">shopping_bag</span>
                </div>
                <p class="text-zinc-500 text-sm font-bold uppercase tracking-wider">Active Orders</p>
                <h3 class="text-2xl font-black text-on-background mt-1">{{ number_format((int) $activeOrders) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-[0_4px_16px_rgba(0,150,204,0.08)] border border-pink-50 bouncy-hover">
                <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">bar_chart</span>
                </div>
                <p class="text-zinc-500 text-sm font-bold uppercase tracking-wider">Total Sales</p>
                <h3 class="text-2xl font-black text-on-background mt-1">{{ number_format((int) $totalSales) }}</h3>
            </div>

            <a
                href="{{ route('products.index') }}#low-stock"
                class="block rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-error focus-visible:ring-offset-2 focus-visible:ring-offset-background"
            >
                <div class="bg-error-container p-6 rounded-lg shadow-[0_4px_16px_rgba(229,62,62,0.1)] border border-error/10 bouncy-hover cursor-pointer h-full">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mb-4 shadow-sm">
                        <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">warning</span>
                    </div>
                    <p class="text-on-error-container text-sm font-bold uppercase tracking-wider">Low Stock Items</p>
                    <h3 class="text-2xl font-black text-on-error-container mt-1">{{ number_format((int) $lowStockItems) }}</h3>
                    <p class="text-on-error-container/80 text-xs font-bold mt-2">Tap to view on Products</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-lg p-6 shadow-[0_4px_16px_rgba(224,64,160,0.08)] border border-pink-50">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-black text-on-background">Popular Products</h3>
                </div>

                <div class="space-y-6">
                    @forelse ($popularProducts as $index => $product)
                        @php
                            $qty = (int) $product->total_qty;
                            $percent = $maxQty > 0 ? max(5, (int) round(($qty / $maxQty) * 100)) : 0;
                            $barClass = match ($index % 4) {
                                0 => 'bg-primary text-primary',
                                1 => 'bg-secondary text-secondary',
                                2 => 'bg-tertiary text-tertiary',
                                default => 'bg-pink-300 text-pink-400',
                            };
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm font-bold">
                                <span>{{ $product->name }}</span>
                                <span class="{{ explode(' ', $barClass)[1] }}">{{ $qty }}</span>
                            </div>
                            <div class="h-4 w-full bg-surface-container rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ explode(' ', $barClass)[0] }}" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-500 font-medium">No sales data yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-[0_4px_16px_rgba(224,64,160,0.08)] border border-pink-50 flex flex-col">
                <h3 class="text-xl font-black text-on-background mb-6">Recent Activity</h3>
                <div class="space-y-6 flex-grow">
                    @forelse ($recentActivity as $row)
                        @if ($row['kind'] === 'order')
                            @php $activity = $row['order']; @endphp
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-lg">receipt_long</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-on-background leading-tight">Order {{ $activity->reference }} - {{ ucfirst($activity->status) }}</p>
                                    <p class="text-xs text-zinc-500 mt-1">
                                        {{ optional($activity->user)->name ?? 'Guest' }} placed an order worth PHP {{ number_format((float) $activity->total, 2) }}.
                                    </p>
                                    <p class="text-[10px] text-primary font-black mt-1 uppercase">{{ optional($activity->ordered_at ?? $activity->created_at)->timezone('Asia/Manila')->diffForHumans() }}</p>
                                </div>
                            </div>
                        @else
                            @php $log = $row['log']; @endphp
                            @php
                                $icon = match ($log->action) {
                                    \App\Models\ActivityLog::ACTION_PRODUCT_CREATED => 'add_box',
                                    \App\Models\ActivityLog::ACTION_PRODUCT_UPDATED => 'edit_square',
                                    \App\Models\ActivityLog::ACTION_PRODUCT_DELETED => 'delete',
                                    default => 'inventory_2',
                                };
                                $title = match ($log->action) {
                                    \App\Models\ActivityLog::ACTION_PRODUCT_CREATED => 'Product added',
                                    \App\Models\ActivityLog::ACTION_PRODUCT_UPDATED => 'Product updated',
                                    \App\Models\ActivityLog::ACTION_PRODUCT_DELETED => 'Product deleted',
                                    default => 'Product activity',
                                };
                            @endphp
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-lg">{{ $icon }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-on-background leading-tight">{{ $title }}: {{ $log->subject_label ?? '—' }}</p>
                                    <p class="text-xs text-zinc-500 mt-1">
                                        {{ optional($log->user)->name ?? 'Admin' }}
                                        @if ($log->action === \App\Models\ActivityLog::ACTION_PRODUCT_CREATED)
                                            added this product to the catalog.
                                        @elseif ($log->action === \App\Models\ActivityLog::ACTION_PRODUCT_UPDATED)
                                            changed product details.
                                        @else
                                            removed this product from the catalog.
                                        @endif
                                    </p>
                                    <p class="text-[10px] text-primary font-black mt-1 uppercase">{{ $log->created_at->timezone('Asia/Manila')->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-sm text-zinc-500 font-medium">No recent activity yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

@include('partials.mobile-nav-drawer')
@include('partials.logout-modal')

</body>
</html>
