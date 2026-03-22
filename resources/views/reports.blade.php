<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>AKEIRA'S SNACK INN - Sales Reports</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet"/>
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
        body { font-family: 'DM Sans', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen">

@php
    $monthOptions = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
    ];

    /* ── Monthly chart ── */
    $maxMonthly = $monthlySales->max('amount') ?: 1;

    /* ── Donut chart: group revenue by category ── */
    $catRevenue = $topProducts->groupBy('category')->map(fn ($g) => $g->sum('revenue'));
    $catTotal   = max($catRevenue->sum(), 1);

    /* Assign a color to each category */
    $catPalette = ['#e040a0','#7c52aa','#0096cc','#f0a0cc','#40c0ee','#c8a8e8'];
    $catColors  = [];
    foreach ($catRevenue->keys() as $i => $cat) {
        $catColors[$cat] = $catPalette[$i % count($catPalette)];
    }

    /* Build SVG stroke-dasharray segments */
    $circumference = 100; // percentage basis
    $offset = 0;
    $donutSegments = [];
    foreach ($catRevenue as $cat => $rev) {
        $pct = round(($rev / $catTotal) * 100, 1);
        $donutSegments[] = [
            'cat'    => $cat,
            'pct'    => $pct,
            'color'  => $catColors[$cat],
            'dash'   => $pct . ' ' . (100 - $pct),
            'offset' => -$offset,
        ];
        $offset += $pct;
    }
    $topCat    = $catRevenue->sortDesc()->keys()->first() ?? '—';
    $topCatPct = $catRevenue->count() ? round(($catRevenue->max() / $catTotal) * 100) : 0;

    /* ── Top products: bar widths ── */
    $maxUnits = max($topProducts->max('units_sold'), 1);

    /* ── Modal: all sold products (same filter as table) ── */
    $maxUnitsAll = max($allSoldProducts->max('units_sold'), 1);
    $soldModalPeriod = $selectedMonth > 0
        ? ($monthOptions[$selectedMonth] ?? 'Selected month')
        : 'All months';
@endphp

<header class="fixed top-0 w-full z-50 border-b border-pink-100 bg-white/80 backdrop-blur-md shadow-[0_4px_16px_rgba(224,64,160,0.15)] flex justify-between items-center gap-2 px-4 sm:px-6 h-16">
    <div class="grid grid-cols-[2.75rem_minmax(0,1fr)] items-center gap-2 sm:gap-3 flex-1 min-w-0 pr-1">
        @include('partials.mobile-nav-menu-button')
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            @include('partials.brand-logo', ['class' => 'h-9 w-9 sm:h-10 sm:w-10 shrink-0 rounded-full object-cover border-2 border-pink-100 bg-white shadow-sm'])
            <div class="text-xl sm:text-2xl font-black tracking-tight text-pink-600 truncate min-w-0">AKEIRA'S SNACK INN</div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <form method="GET" action="{{ route('reports.index') }}" class="hidden md:flex relative">
            <input
                name="search"
                value="{{ request('search') }}"
                class="pl-10 pr-4 py-2 rounded-full border-none bg-surface-container-high focus:ring-2 focus:ring-primary w-64 text-sm"
                placeholder="Search reports..."
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
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('history.index') }}">
            <span class="material-symbols-outlined">history</span>
            <span class="font-medium text-sm">History</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]" href="{{ route('reports.index') }}">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">analytics</span>
            <span class="font-medium text-sm">Reports</span>
        </a>
    </nav>
</aside>

<main class="pt-20 min-h-screen pb-16 py-6 pl-5 pr-5 sm:pl-6 sm:pr-6 xl:pl-[calc(16rem+1.5rem)] xl:pr-8">
    <div class="w-full max-w-none space-y-8">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-on-background tracking-tight">Sales Reports</h1>
                <p class="text-zinc-500 mt-1 font-medium italic">Akeira's insights for your snack empire.</p>
            </div>
            <div class="flex gap-3">
                <form method="GET" action="{{ route('reports.index') }}" class="flex items-center">
                    <label class="flex items-center gap-2 bg-white border border-pink-100 px-4 py-3 rounded-full font-bold text-pink-600 shadow-[0_4px_12px_rgba(224,64,160,0.1)]">
                        <span class="material-symbols-outlined text-xl">calendar_today</span>
                        <select name="month" onchange="this.form.submit()" class="bg-transparent border-none focus:ring-0 pr-7 text-sm font-bold text-pink-600 cursor-pointer">
                            <option value="0" {{ (int) $selectedMonth === 0 ? 'selected' : '' }}>Monthly</option>
                            @foreach ($monthOptions as $monthNumber => $monthLabel)
                                <option value="{{ $monthNumber }}" {{ (int) $selectedMonth === $monthNumber ? 'selected' : '' }}>
                                    {{ $monthLabel }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </form>
            </div>
        </div>

        {{-- ── Bento Grid Stats ─────────────────────────────────── --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            {{-- Total Revenue --}}
            <div class="bg-white p-6 rounded-lg shadow-[0_8px_24px_rgba(224,64,160,0.08)] border border-pink-50 flex flex-col justify-between hover:scale-[1.02] transition-transform">
                <div class="flex justify-between items-start">
                    <span class="p-3 bg-pink-100 text-pink-600 rounded-2xl material-symbols-outlined" style="font-variation-settings:'FILL' 1;">payments</span>
                </div>
                <div class="mt-4">
                    <p class="text-zinc-500 text-sm font-bold uppercase tracking-wider">Total Revenue</p>
                    <p class="text-3xl font-black text-on-background">PHP {{ number_format((float) $totalRevenue, 2) }}</p>
                </div>
            </div>

            {{-- Total Units --}}
            <div class="bg-white p-6 rounded-lg shadow-[0_8px_24px_rgba(124,82,170,0.08)] border border-purple-50 flex flex-col justify-between hover:scale-[1.02] transition-transform">
                <div class="flex justify-between items-start">
                    <span class="p-3 bg-secondary-container text-secondary rounded-2xl material-symbols-outlined" style="font-variation-settings:'FILL' 1;">shopping_basket</span>
                </div>
                <div class="mt-4">
                    <p class="text-zinc-500 text-sm font-bold uppercase tracking-wider">Total Units</p>
                    <p class="text-3xl font-black text-on-background">{{ number_format((int) $totalUnits) }}</p>
                </div>
            </div>

            {{-- New Customers --}}
            <div class="bg-white p-6 rounded-lg shadow-[0_8px_24px_rgba(0,150,204,0.08)] border border-blue-50 flex flex-col justify-between hover:scale-[1.02] transition-transform">
                <div class="flex justify-between items-start">
                    <span class="p-3 bg-tertiary-fixed text-tertiary rounded-2xl material-symbols-outlined" style="font-variation-settings:'FILL' 1;">group</span>
                </div>
                <div class="mt-4">
                    <p class="text-zinc-500 text-sm font-bold uppercase tracking-wider">Customers</p>
                    <p class="text-3xl font-black text-on-background">{{ number_format((int) $newCustomers) }}</p>
                </div>
            </div>

            {{-- Avg Order Value --}}
            <div class="bg-white p-6 rounded-lg shadow-[0_8px_24px_rgba(224,64,160,0.08)] border border-pink-50 flex flex-col justify-between hover:scale-[1.02] transition-transform">
                <div class="flex justify-between items-start">
                    <span class="p-3 bg-pink-100 text-pink-600 rounded-2xl material-symbols-outlined" style="font-variation-settings:'FILL' 1;">trending_up</span>
                </div>
                <div class="mt-4">
                    <p class="text-zinc-500 text-sm font-bold uppercase tracking-wider">Avg Order Value</p>
                    <p class="text-3xl font-black text-on-background">PHP {{ number_format($avgOrderValue, 2) }}</p>
                </div>
            </div>
        </div>

        {{-- ── Charts Row ───────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Monthly Sales Bar Chart --}}
            <div class="lg:col-span-2 bg-white p-8 rounded-lg shadow-[0_12px_32px_rgba(0,0,0,0.04)] border border-pink-50">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-xl font-black text-on-background">Monthly Sales</h3>
                        <p class="text-zinc-400 text-sm font-medium italic">Tracking your snacks progress</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="w-3 h-3 rounded-full bg-primary"></span>
                        <span class="text-xs font-bold text-zinc-500">REVENUE</span>
                    </div>
                </div>

                @if ($monthlySales->isEmpty())
                    <div class="h-64 flex items-center justify-center text-zinc-400 text-sm font-medium">
                        No sales data yet.
                    </div>
                @else
                    <div class="h-64 flex items-end justify-between gap-2 relative">
                        {{-- Grid lines --}}
                        <div class="absolute inset-0 flex flex-col justify-between pointer-events-none opacity-20">
                            <div class="border-b border-zinc-200 w-full h-0"></div>
                            <div class="border-b border-zinc-200 w-full h-0"></div>
                            <div class="border-b border-zinc-200 w-full h-0"></div>
                            <div class="border-b border-zinc-200 w-full h-0"></div>
                        </div>

                        @foreach ($monthlySales as $row)
                            @php
                                $heightPct = max(5, round(($row->amount / $maxMonthly) * 100));
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                                <div
                                    class="w-full bg-pink-100 rounded-t-full relative flex items-end justify-center transition-all group-hover:bg-primary/20"
                                    style="height: {{ $heightPct }}%"
                                    title="PHP {{ number_format((float) $row->amount, 2) }}"
                                >
                                    <div class="w-2 h-2 rounded-full bg-primary absolute -top-1 ring-4 ring-white shadow-sm"></div>
                                    <span class="hidden group-hover:block absolute -top-7 text-[10px] font-black text-primary whitespace-nowrap bg-white px-2 py-0.5 rounded-full shadow-sm">
                                        {{ number_format((float) $row->amount, 0) }}
                                    </span>
                                </div>
                                <span class="text-[10px] font-bold text-zinc-400 uppercase">{{ strtoupper($row->month) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Revenue by Category Donut --}}
            <div class="bg-white p-8 rounded-lg shadow-[0_12px_32px_rgba(0,0,0,0.04)] border border-pink-50">
                <h3 class="text-xl font-black text-on-background mb-8">Revenue by Category</h3>

                @if ($catRevenue->isEmpty())
                    <p class="text-sm text-zinc-400 font-medium">No category data yet.</p>
                @else
                    <div class="flex flex-col items-center gap-8">
                        {{-- Donut SVG --}}
                        <div class="relative w-48 h-48 flex items-center justify-center">
                            <svg class="absolute w-full h-full -rotate-90" viewBox="0 0 36 36">
                                @foreach ($donutSegments as $seg)
                                    <circle
                                        cx="18" cy="18" r="15.9"
                                        fill="transparent"
                                        stroke="{{ $seg['color'] }}"
                                        stroke-width="4.2"
                                        stroke-dasharray="{{ $seg['dash'] }}"
                                        stroke-dashoffset="{{ $seg['offset'] }}"
                                    />
                                @endforeach
                            </svg>
                            <div class="text-center z-10">
                                <p class="text-2xl font-black text-pink-600">{{ $topCatPct }}%</p>
                                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-tighter">{{ $topCat }}</p>
                            </div>
                        </div>

                        {{-- Legend --}}
                        <div class="grid grid-cols-2 gap-3 w-full">
                            @foreach ($catRevenue as $cat => $rev)
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full shrink-0" style="background: {{ $catColors[$cat] }}"></span>
                                    <span class="text-xs font-bold text-zinc-600 truncate">{{ $cat }} ({{ round(($rev/$catTotal)*100) }}%)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Top Selling Products Table ───────────────────────── --}}
        <div class="bg-white rounded-lg shadow-[0_12px_40px_rgba(0,0,0,0.05)] overflow-hidden border border-pink-50">
            <div class="p-8 border-b border-pink-50 flex justify-between items-center bg-pink-50/20">
                <div>
                    <h3 class="text-xl font-black text-on-background">Top Selling Products</h3>
                    <p class="text-zinc-500 text-sm font-medium">Your most popular snacks overall</p>
                </div>
                <button
                    type="button"
                    onclick="openAllSoldProductsModal()"
                    class="text-pink-600 font-bold hover:underline flex items-center gap-1 text-sm"
                >
                    View All
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>

            <div class="overflow-x-auto">
                @if ($topProducts->isEmpty())
                    <div class="py-16 text-center text-zinc-400 text-sm font-medium">No sales data yet.</div>
                @else
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-zinc-400 text-xs font-black uppercase tracking-widest border-b border-pink-50">
                                <th class="px-8 py-4">Product Name</th>
                                <th class="px-8 py-4">Category</th>
                                <th class="px-8 py-4">Units Sold</th>
                                <th class="px-8 py-4">Revenue</th>
                                <th class="px-8 py-4">Sales Share</th>
                                <th class="px-8 py-4">Trend</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-pink-50/50">
                            @foreach ($topProducts as $i => $product)
                                @php
                                    $sharePct = max(3, round(($product->units_sold / $maxUnits) * 100));
                                    $isTop = $i === 0;
                                    $badgePalette = [
                                        'bg-pink-50 text-pink-600',
                                        'bg-secondary-container text-secondary',
                                        'bg-tertiary-fixed text-tertiary',
                                        'bg-primary-fixed text-primary',
                                    ];
                                    $badge = $badgePalette[$i % 4];
                                @endphp
                                <tr class="group hover:bg-pink-50/30 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-2xl overflow-hidden border border-pink-100 bg-white shrink-0 shadow-sm">
                                                <img src="{{ asset('images/logo.jpg') }}" alt="" class="w-full h-full object-cover"/>
                                            </div>
                                            <div>
                                                <p class="font-black text-on-background">{{ $product->name }}</p>
                                                <p class="text-xs text-zinc-400 font-medium">Rank #{{ $i + 1 }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badge }}">{{ $product->category }}</span>
                                    </td>
                                    <td class="px-8 py-6 font-bold text-zinc-700">{{ number_format((int) $product->units_sold) }} units</td>
                                    <td class="px-8 py-6 font-black text-on-background">PHP {{ number_format((float) $product->revenue, 2) }}</td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-2 bg-zinc-100 rounded-full overflow-hidden w-24">
                                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $sharePct }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-emerald-600">{{ $sharePct }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if ($isTop)
                                            <span class="flex items-center gap-1 text-emerald-600 font-bold text-xs uppercase italic">
                                                <span class="material-symbols-outlined text-sm">trending_up</span>
                                                Hot Pick
                                            </span>
                                        @elseif ($sharePct >= 50)
                                            <span class="flex items-center gap-1 text-emerald-600 font-bold text-xs uppercase italic">
                                                <span class="material-symbols-outlined text-sm">trending_up</span>
                                                Trending
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1 text-zinc-400 font-bold text-xs uppercase italic">
                                                <span class="material-symbols-outlined text-sm">video_stable</span>
                                                Stable
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</main>

{{-- All sold products (current report period) --}}
<div
    id="all-sold-products-modal"
    class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/40 px-4 py-8"
    role="dialog"
    aria-modal="true"
    aria-labelledby="all-sold-products-title"
>
    <div class="w-full max-w-3xl max-h-[min(90vh,720px)] flex flex-col rounded-3xl bg-white border border-pink-100 shadow-[0_12px_36px_rgba(0,0,0,0.15)] overflow-hidden">
        <div class="shrink-0 p-6 border-b border-pink-100 flex items-start justify-between gap-4 bg-pink-50/30">
            <div>
                <h3 id="all-sold-products-title" class="text-xl font-black text-on-background">All products sold</h3>
                <p class="text-sm text-zinc-500 font-medium mt-1">
                    <span class="font-bold text-pink-600">{{ $soldModalPeriod }}</span>
                    @if ($selectedMonth > 0)
                        <span> — units and revenue for completed line items in this month.</span>
                    @else
                        <span> — units and revenue across all order dates (same filters as this report).</span>
                    @endif
                </p>
            </div>
            <button
                type="button"
                onclick="closeAllSoldProductsModal()"
                class="shrink-0 w-10 h-10 rounded-full border border-pink-100 text-zinc-500 hover:bg-pink-50 flex items-center justify-center transition-colors"
                aria-label="Close"
            >
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-6">
            @if ($allSoldProducts->isEmpty())
                <p class="text-center text-zinc-400 text-sm font-medium py-12">No sales data for this period.</p>
            @else
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-zinc-400 text-xs font-black uppercase tracking-widest border-b border-pink-100">
                            <th class="py-3 pr-4">#</th>
                            <th class="py-3 pr-4">Product</th>
                            <th class="py-3 pr-4">Category</th>
                            <th class="py-3 pr-4 text-right">Units</th>
                            <th class="py-3 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-50/60">
                        @foreach ($allSoldProducts as $i => $row)
                            @php
                                $badgePalette = [
                                    'bg-pink-50 text-pink-600',
                                    'bg-secondary-container text-secondary',
                                    'bg-tertiary-fixed text-tertiary',
                                    'bg-primary-fixed text-primary',
                                ];
                                $badge = $badgePalette[$i % 4];
                                $sharePct = max(2, round(((int) $row->units_sold / $maxUnitsAll) * 100));
                            @endphp
                            <tr class="hover:bg-pink-50/20">
                                <td class="py-3 pr-4 text-zinc-400 font-bold">{{ $i + 1 }}</td>
                                <td class="py-3 pr-4">
                                    <p class="font-black text-on-background">{{ $row->name }}</p>
                                    <div class="mt-1 h-1.5 bg-zinc-100 rounded-full overflow-hidden max-w-[12rem]">
                                        <div class="h-full bg-primary rounded-full" style="width: {{ $sharePct }}%"></div>
                                    </div>
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $badge }}">{{ $row->category }}</span>
                                </td>
                                <td class="py-3 pr-4 text-right font-bold text-zinc-700">{{ number_format((int) $row->units_sold) }}</td>
                                <td class="py-3 text-right font-black text-pink-600">PHP {{ number_format((float) $row->revenue, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="shrink-0 p-4 border-t border-pink-100 flex justify-end bg-pink-50/20">
            <button
                type="button"
                onclick="closeAllSoldProductsModal()"
                class="px-6 py-2.5 rounded-full bg-primary text-on-primary font-black text-sm shadow-[0_4px_12px_rgba(224,64,160,0.3)] hover:opacity-95 transition-opacity"
            >
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function openAllSoldProductsModal() {
        const el = document.getElementById('all-sold-products-modal');
        if (!el) return;
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeAllSoldProductsModal() {
        const el = document.getElementById('all-sold-products-modal');
        if (!el) return;
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    document.getElementById('all-sold-products-modal')?.addEventListener('click', function (e) {
        if (e.target === this) {
            closeAllSoldProductsModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllSoldProductsModal();
        }
    });
</script>

@include('partials.mobile-nav-drawer')
@include('partials.logout-modal')

</body>
</html>
