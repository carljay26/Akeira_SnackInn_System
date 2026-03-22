<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>AKEIRA'S SNACK INN - Products</title>
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

        @keyframes low-stock-ring-pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
            40%, 60% { box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.65), 0 12px 28px rgba(224, 64, 160, 0.18); }
        }
        .low-stock-highlight-active {
            animation: low-stock-ring-pulse 1s ease-in-out;
            border-color: rgb(251 191 36 / 0.85) !important;
        }

        /* Modal backdrop */
        dialog::backdrop { background: rgba(46, 26, 40, 0.5); backdrop-filter: blur(4px); }
        dialog[open] { display: flex; align-items: center; justify-content: center; }
        dialog { border: none; border-radius: 1.5rem; padding: 0; background: transparent; width: 100%; max-width: 38rem; }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen">

{{-- ─── Top App Bar ─────────────────────────────────────────────── --}}
<header class="fixed top-0 w-full z-50 border-b border-pink-100 bg-white/80 backdrop-blur-md shadow-[0_4px_16px_rgba(224,64,160,0.15)] flex justify-between items-center gap-2 px-4 sm:px-6 h-16">
    <div class="grid grid-cols-[2.75rem_minmax(0,1fr)] xl:grid-cols-1 items-center gap-2 sm:gap-3 flex-1 min-w-0 pr-1">
        @include('partials.mobile-nav-menu-button')
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            @include('partials.brand-logo', ['class' => 'h-9 w-9 sm:h-10 sm:w-10 shrink-0 rounded-full object-cover border-2 border-pink-100 bg-white shadow-sm'])
            <div class="text-xl sm:text-2xl font-black tracking-tight text-pink-600 truncate min-w-0">AKEIRA'S SNACK INN</div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <form method="GET" action="{{ route('products.index') }}" class="hidden md:flex relative">
            <input
                name="search"
                value="{{ $search }}"
                class="pl-10 pr-4 py-2 rounded-full border-none bg-surface-container-high focus:ring-2 focus:ring-primary w-64 text-sm"
                placeholder="Search products..."
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

{{-- ─── Sidebar ──────────────────────────────────────────────────── --}}
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
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]" href="{{ route('products.index') }}">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">inventory_2</span>
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
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full text-zinc-600 hover:bg-pink-100 transition-colors" href="{{ route('reports.index') }}">
            <span class="material-symbols-outlined">analytics</span>
            <span class="font-medium text-sm">Reports</span>
        </a>
    </nav>
</aside>

{{-- ─── Main Content ─────────────────────────────────────────────── --}}
<main class="pt-20 min-h-screen pb-6 py-6 pl-5 pr-5 sm:pl-6 sm:pr-6 xl:pl-[calc(16rem+1.5rem)] xl:pr-8">
    <div class="w-full max-w-none">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-on-background tracking-tight">Product Management</h1>
                <p class="text-on-surface-variant font-medium">Keep your snack bins full and organized</p>
            </div>
            <button
                onclick="document.getElementById('addModal').showModal()"
                class="bg-primary text-white px-8 py-3 rounded-full font-bold shadow-[0_4px_16px_rgba(224,64,160,0.3)] flex items-center gap-2 hover:scale-105 active:scale-95 transition-all self-start"
            >
                <span class="material-symbols-outlined">add_circle</span>
                Add Product
            </button>
        </div>

        {{-- Status flash (auto-dismiss ~4.5s) --}}
        @include('partials.flash-status', [
            'wrapperClass' => 'mb-6 flex items-center gap-3 px-5 py-3 rounded-2xl bg-emerald-100 text-emerald-900 font-bold text-sm border border-emerald-200/90 shadow-sm',
        ])

        @php
            $totalProducts  = \App\Models\Product::count();
            $lowStockCount  = \App\Models\Product::where('stock', '<=', $lowStockThreshold)->count();
            $categoryCount  = \App\Models\Product::distinct('category')->count('category');
            $maxStock       = max($products->max('stock') ?: 1, 1);
        @endphp

        {{-- Stats Bar --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5 mb-5">
            <div class="bg-white p-4 sm:p-5 rounded-lg shadow-[0_4px_16px_rgba(224,64,160,0.08)] border border-pink-50 flex items-center gap-3 sm:gap-4">
                <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">inventory</span>
                </div>
                <div>
                    <div class="text-2xl font-black">{{ number_format($totalProducts) }}</div>
                    <div class="text-sm text-zinc-500 font-medium">Total Products</div>
                </div>
            </div>
            <div class="bg-white p-4 sm:p-5 rounded-lg shadow-[0_4px_16px_rgba(224,64,160,0.08)] border border-pink-50 flex items-center gap-3 sm:gap-4">
                <div class="w-12 h-12 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">warning</span>
                </div>
                <div>
                    <div class="text-2xl font-black">{{ number_format($lowStockCount) }}</div>
                    <div class="text-sm text-zinc-500 font-medium">Low Stock Alerts</div>
                </div>
            </div>
            <div class="bg-white p-4 sm:p-5 rounded-lg shadow-[0_4px_16px_rgba(224,64,160,0.08)] border border-pink-50 flex items-center gap-3 sm:gap-4">
                <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">category</span>
                </div>
                <div>
                    <div class="text-2xl font-black">{{ number_format($categoryCount) }}</div>
                    <div class="text-sm text-zinc-500 font-medium">Active Categories</div>
                </div>
            </div>
        </div>

        {{-- Product Table / Card Grid --}}
        <div class="bg-white rounded-lg shadow-[0_8px_32px_rgba(224,64,160,0.05)] border border-pink-50 overflow-hidden">

            {{-- Toolbar --}}
            <div class="p-6 border-b border-pink-50 flex flex-wrap items-center justify-between gap-4">
                <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-3">
                    <div class="relative flex md:hidden">
                        <input name="search" value="{{ $search }}" class="pl-10 pr-4 py-2 rounded-full border border-outline-variant/30 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm w-52" placeholder="Search..." type="text"/>
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                    </div>
                    @if($search)
                        <a href="{{ route('products.index') }}" class="bg-surface-container-low px-4 py-2 rounded-full text-sm font-bold text-on-surface-variant flex items-center gap-2 hover:bg-pink-100 transition-colors">
                            <span class="material-symbols-outlined text-sm">close</span> Clear
                        </a>
                    @endif
                </form>
                <div class="text-sm text-on-surface-variant font-medium">
                    Showing <span class="text-primary font-bold">{{ $products->count() }}</span> of {{ $products->total() }} products
                </div>
            </div>

            {{-- Product Cards --}}
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    @php
                        $stockPct  = min(100, (int) round(($product->stock / $maxStock) * 100));
                        $isLow     = $product->stock <= $lowStockThreshold;
                        $barColor  = $isLow ? 'bg-error' : 'bg-primary';
                        $badgeColors = [
                            'bg-secondary-fixed text-secondary',
                            'bg-tertiary-fixed text-tertiary',
                            'bg-primary-fixed text-primary',
                        ];
                        $badge = $badgeColors[$loop->index % 3];
                    @endphp
                    <div
                        id="product-card-{{ $product->id }}"
                        @if ($isLow) data-low-stock="1" @endif
                        class="bg-surface-container-lowest rounded-lg border border-pink-50 p-4 hover:shadow-[0_8px_24px_rgba(224,64,160,0.12)] hover:-translate-y-1 transition-all duration-300 group"
                    >
                        <div class="flex items-start justify-between mb-4">
                            {{-- Product image --}}
                            <div class="w-20 h-20 rounded-lg bg-primary-fixed/30 flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover"/>
                                @else
                                    <img src="{{ asset('images/logo.jpg') }}" alt="" class="w-full h-full object-cover"/>
                                @endif
                            </div>
                            {{-- Action buttons --}}
                            <div class="flex gap-1">
                                <button
                                    onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->category) }}', {{ $product->price }}, {{ $product->stock }}, '{{ addslashes($product->unit) }}', '{{ addslashes($product->description ?? '') }}')"
                                    class="p-2 rounded-full hover:bg-pink-100 text-zinc-400 hover:text-primary transition-colors"
                                    title="Edit product"
                                >
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <button
                                    onclick="openDeleteModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                    class="p-2 rounded-full hover:bg-red-50 text-zinc-400 hover:text-error transition-colors"
                                    title="Delete product"
                                >
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="text-[10px] uppercase tracking-widest font-black px-2 py-1 rounded-full {{ $badge }}">
                                {{ $product->category }}
                            </span>
                            <h3 class="font-black text-lg text-on-surface mt-1">{{ $product->name }}</h3>
                            @if($product->description)
                                <p class="text-xs text-zinc-400 mt-0.5 line-clamp-1">{{ $product->description }}</p>
                            @endif
                        </div>

                        <div class="flex items-end justify-between">
                            <div>
                                <div class="text-xs font-medium {{ $isLow ? 'text-error' : 'text-zinc-500' }}">
                                    {{ $isLow ? 'Low Stock!' : 'Stock Level' }}
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="w-24 h-2 bg-pink-100 rounded-full overflow-hidden">
                                        <div class="{{ $barColor }} h-full rounded-full" style="width: {{ $stockPct }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold {{ $isLow ? 'text-error' : '' }}">{{ number_format($product->stock) }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-zinc-500 font-medium">Price</div>
                                <div class="text-xl font-black text-primary">PHP {{ number_format((float) $product->price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 py-20 flex flex-col items-center gap-4 text-zinc-400">
                        <span class="material-symbols-outlined text-6xl">inventory_2</span>
                        <p class="text-lg font-bold">No products found</p>
                        @if($search)
                            <a href="{{ route('products.index') }}" class="text-primary font-bold text-sm hover:underline">Clear search</a>
                        @endif
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="p-6 border-t border-pink-50 flex items-center justify-center gap-2">
                    {{-- Prev --}}
                    @if ($products->onFirstPage())
                        <span class="w-10 h-10 rounded-full flex items-center justify-center text-zinc-300 cursor-not-allowed">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="w-10 h-10 rounded-full flex items-center justify-center text-zinc-400 hover:bg-pink-100 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </a>
                    @endif

                    {{-- Pages --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="w-10 h-10 rounded-full flex items-center justify-center bg-primary text-white font-bold shadow-[0_4px_12px_rgba(224,64,160,0.3)]">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-on-surface hover:bg-pink-100 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="w-10 h-10 rounded-full flex items-center justify-center text-zinc-400 hover:bg-pink-100 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </a>
                    @else
                        <span class="w-10 h-10 rounded-full flex items-center justify-center text-zinc-300 cursor-not-allowed">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</main>

{{-- ═══════════════════════════════════════════════════════════════
     ADD PRODUCT MODAL
════════════════════════════════════════════════════════════════ --}}
<dialog id="addModal">
    <div class="bg-white w-full rounded-2xl shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-pink-50">
            <h2 class="text-xl font-black text-on-background">Add New Product</h2>
            <button onclick="document.getElementById('addModal').close()" class="p-2 rounded-full hover:bg-pink-100 text-zinc-400 hover:text-primary transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Product Name *</label>
                    <input name="name" type="text" required placeholder="e.g. Burger Bites" class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Category *</label>
                    <input name="category" type="text" required placeholder="e.g. Snacks" class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Unit *</label>
                    <input name="unit" type="text" required placeholder="e.g. pcs, pack" class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Price (PHP) *</label>
                    <input name="price" type="number" step="0.01" min="0" required placeholder="0.00" class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Stock *</label>
                    <input name="stock" type="number" min="0" required placeholder="0" class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Description</label>
                    <textarea name="description" rows="2" placeholder="Short description..." class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm resize-none"></textarea>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Product Image *</label>
                    <input name="image" type="file" accept="image/*" required class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-bold file:bg-primary-fixed file:text-primary hover:file:bg-pink-200 transition-colors"/>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('addModal').close()" class="flex-1 py-3 rounded-full border border-outline-variant/50 font-bold text-sm text-on-surface-variant hover:bg-surface-container transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-3 rounded-full bg-primary text-white font-bold text-sm shadow-[0_4px_16px_rgba(224,64,160,0.3)] hover:scale-105 active:scale-95 transition-all">
                    Save Product
                </button>
            </div>
        </form>
    </div>
</dialog>

{{-- ═══════════════════════════════════════════════════════════════
     EDIT PRODUCT MODAL
════════════════════════════════════════════════════════════════ --}}
<dialog id="editModal">
    <div class="bg-white w-full rounded-2xl shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-pink-50">
            <h2 class="text-xl font-black text-on-background">Edit Product</h2>
            <button onclick="document.getElementById('editModal').close()" class="p-2 rounded-full hover:bg-pink-100 text-zinc-400 hover:text-primary transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Product Name *</label>
                    <input id="editName" name="name" type="text" required class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Category *</label>
                    <input id="editCategory" name="category" type="text" required class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Unit *</label>
                    <input id="editUnit" name="unit" type="text" required class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Price (PHP) *</label>
                    <input id="editPrice" name="price" type="number" step="0.01" min="0" required class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Stock *</label>
                    <input id="editStock" name="stock" type="number" min="0" required class="w-full px-4 py-3 rounded-full border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm"/>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Description</label>
                    <textarea id="editDescription" name="description" rows="2" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 bg-surface-container-low focus:ring-2 focus:ring-primary text-sm resize-none"></textarea>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-on-surface-variant mb-1">Replace Image <span class="font-normal text-zinc-400">(optional)</span></label>
                    <input name="image" type="file" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-bold file:bg-primary-fixed file:text-primary hover:file:bg-pink-200 transition-colors"/>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editModal').close()" class="flex-1 py-3 rounded-full border border-outline-variant/50 font-bold text-sm text-on-surface-variant hover:bg-surface-container transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-3 rounded-full bg-primary text-white font-bold text-sm shadow-[0_4px_16px_rgba(224,64,160,0.3)] hover:scale-105 active:scale-95 transition-all">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</dialog>

{{-- ═══════════════════════════════════════════════════════════════
     DELETE CONFIRM MODAL
════════════════════════════════════════════════════════════════ --}}
<dialog id="deleteModal">
    <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-8 text-center">
            <div class="w-16 h-16 rounded-full bg-error-container flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-error text-3xl" style="font-variation-settings:'FILL' 1;">delete_forever</span>
            </div>
            <h2 class="text-xl font-black text-on-background mb-2">Delete Product?</h2>
            <p class="text-sm text-on-surface-variant mb-6">
                You are about to delete <strong id="deleteProductName" class="text-on-background"></strong>. This action cannot be undone.
            </p>
            <form id="deleteForm" method="POST" action="" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="document.getElementById('deleteModal').close()" class="flex-1 py-3 rounded-full border border-outline-variant/50 font-bold text-sm text-on-surface-variant hover:bg-surface-container transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-3 rounded-full bg-error text-white font-bold text-sm shadow-[0_4px_16px_rgba(229,62,62,0.3)] hover:scale-105 active:scale-95 transition-all">
                    Delete
                </button>
            </form>
        </div>
    </div>
</dialog>

{{-- ─── Auto-open add modal on validation error ─────────────────── --}}
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('addModal').showModal();
    });
</script>
@endif

<script>
    function openEditModal(id, name, category, price, stock, unit, description) {
        const form = document.getElementById('editForm');
        form.action = `/products/${id}`;
        document.getElementById('editName').value        = name;
        document.getElementById('editCategory').value    = category;
        document.getElementById('editPrice').value       = price;
        document.getElementById('editStock').value       = stock;
        document.getElementById('editUnit').value        = unit;
        document.getElementById('editDescription').value = description;
        document.getElementById('editModal').showModal();
    }

    function openDeleteModal(id, name) {
        document.getElementById('deleteForm').action        = `/products/${id}`;
        document.getElementById('deleteProductName').textContent = name;
        document.getElementById('deleteModal').showModal();
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.location.hash !== '#low-stock') {
            return;
        }
        history.replaceState(null, '', window.location.pathname + window.location.search);

        const cards = document.querySelectorAll('[data-low-stock="1"]');
        if (!cards.length) {
            return;
        }
        const first = cards[0];
        first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        cards.forEach(function (el) {
            el.classList.add('low-stock-highlight-active');
        });
        setTimeout(function () {
            cards.forEach(function (el) {
                el.classList.remove('low-stock-highlight-active');
            });
        }, 1000);
    });
</script>

@include('partials.mobile-nav-drawer')
@include('partials.logout-modal')

</body>
</html>
