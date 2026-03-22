<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>AKEIRA'S SNACK INN - Order Queue</title>
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

        /* Match Ordering: reserve cart-width + gutter when side panel visible (xl+) */
        @media (min-width: 1280px) {
            #queue-main.with-side {
                padding-right: calc(20rem + 1.5rem);
            }
        }

        #queue-side-toggle-icon {
            transition: color 0.2s ease;
        }

        #queue-side-floating-toggle:hover #queue-side-toggle-icon {
            animation: queue-arrow-bounce 0.6s ease;
        }

        @keyframes queue-arrow-bounce {
            0% { transform: translateX(0); }
            35% { transform: translateX(2px); }
            70% { transform: translateX(-1px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen">

<header class="fixed top-0 w-full z-50 border-b border-pink-100 bg-white/80 backdrop-blur-md shadow-[0_4px_16px_rgba(224,64,160,0.15)] flex justify-between items-center gap-2 px-4 sm:px-6 h-16">
    <div class="grid grid-cols-[2.75rem_minmax(0,1fr)] items-center gap-2 sm:gap-3 flex-1 min-w-0 pr-1">
        @include('partials.mobile-nav-menu-button')
        <div class="flex items-center gap-2 sm:gap-3 min-w-0">
            @include('partials.brand-logo', ['class' => 'h-9 w-9 sm:h-10 sm:w-10 shrink-0 rounded-full object-cover border-2 border-pink-100 bg-white shadow-sm'])
            <div class="text-xl sm:text-2xl font-black tracking-tight text-pink-600 truncate min-w-0">AKEIRA'S SNACK INN</div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <form method="GET" action="{{ route('order-queue.index') }}" class="hidden md:flex relative">
            <input
                name="search"
                value="{{ request('search') }}"
                class="pl-10 pr-4 py-2 rounded-full border-none bg-surface-container-high focus:ring-2 focus:ring-primary w-64 text-sm"
                placeholder="Search queue..."
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
        <a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-full bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]" href="{{ route('order-queue.index') }}">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;">queue</span>
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

<main id="queue-main" class="with-side pt-20 min-h-screen pb-6 py-6 pl-5 pr-5 sm:pl-6 sm:pr-6 xl:pl-[calc(16rem+1.5rem)] xl:pr-8">
    <div class="w-full max-w-none">

        @include('partials.flash-status')

        @if ($errors->has('stock'))
            <div class="mb-6 px-4 py-3 rounded-2xl bg-error-container text-on-error-container text-sm font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-base">error</span>
                {{ $errors->first('stock') }}
            </div>
        @endif

        @if ($errors->has('restore'))
            <div class="mb-6 px-4 py-3 rounded-2xl bg-error-container text-on-error-container text-sm font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-base">error</span>
                {{ $errors->first('restore') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-black text-on-surface tracking-tight mb-2">Order Queue</h1>
                <p class="text-on-surface-variant font-medium">Recent pending orders. Finish an order to remove it from the queue.</p>
            </div>
            <a href="{{ route('ordering.index') }}" class="bg-primary px-6 py-3 rounded-full font-bold text-on-primary shadow-[0_4px_16px_rgba(224,64,160,0.3)] hover:scale-105 active:scale-95 transition-all flex items-center gap-2 self-start">
                <span class="material-symbols-outlined">add_shopping_cart</span>
                New Order
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-secondary p-6 rounded-lg shadow-[0_4px_20px_rgba(124,82,170,0.15)] text-white flex flex-col justify-between h-40">
                <span class="material-symbols-outlined text-3xl">pending_actions</span>
                <div>
                    <div class="font-bold text-3xl">{{ number_format($pendingInQueue) }}</div>
                    <div class="text-white/80 text-sm font-bold uppercase tracking-wider">In Queue</div>
                </div>
            </div>
            <div class="bg-primary-container p-6 rounded-lg shadow-[0_4px_20px_rgba(224,64,160,0.15)] flex flex-col justify-between h-40">
                <span class="material-symbols-outlined text-on-primary-container text-3xl">payments</span>
                <div>
                    <div class="text-on-primary-container font-bold text-3xl">PHP {{ number_format((float) $pendingValue, 0) }}</div>
                    <div class="text-on-primary-container/80 text-sm font-bold uppercase tracking-wider">Queue Total</div>
                </div>
            </div>
        </div>

        <div class="grid gap-4">
            @forelse ($orders as $order)
                @php
                    $itemCount = $order->items->sum('quantity');
                    $iconBgs = ['bg-primary-fixed text-primary', 'bg-secondary-fixed text-secondary', 'bg-tertiary-fixed text-tertiary', 'bg-surface-container-high text-zinc-400'];
                    $icons   = ['receipt_long', 'local_shipping', 'package_2', 'receipt_long'];
                    $idx     = $loop->index % 4;
                    $statusStyle = 'bg-amber-100 text-amber-700';
                    $dotColor = 'bg-amber-500';
                @endphp
                <div class="bg-white rounded-lg border border-pink-50 shadow-[0_4px_20px_rgba(224,64,160,0.06)] hover:shadow-[0_8px_24px_rgba(224,64,160,0.12)] hover:scale-[1.01] transition-all">
                    <div class="p-4 md:p-6 flex flex-col md:flex-row items-center justify-between gap-6">
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

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 w-full md:w-auto flex-1 md:px-8">
                            <div>
                                <div class="text-zinc-400 text-xs font-bold uppercase tracking-widest mb-1">Status</div>
                                <span class="px-4 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-fit {{ $statusStyle }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    Pending
                                </span>
                            </div>
                            <div>
                                <div class="text-zinc-400 text-xs font-bold uppercase tracking-widest mb-1">Items</div>
                                <div class="text-on-surface font-bold">{{ number_format($itemCount) }} {{ $itemCount === 1 ? 'Item' : 'Items' }}</div>
                            </div>
                            <div>
                                <div class="text-zinc-400 text-xs font-bold uppercase tracking-widest mb-1">Total</div>
                                <div class="text-pink-600 font-black text-lg">PHP {{ number_format((float) $order->total, 2) }}</div>
                            </div>
                        </div>

                        <button
                            type="button"
                            onclick="toggleOrderDetails('queue-details-{{ $order->id }}', this)"
                            class="w-full md:w-auto bg-pink-50 text-pink-600 px-6 py-3 rounded-full font-bold hover:bg-pink-100 active:scale-95 transition-all whitespace-nowrap"
                        >
                            View Details
                        </button>
                    </div>

                    <div id="queue-details-{{ $order->id }}" class="order-dropdown border-t border-pink-50">
                        <div class="p-4 md:p-6 bg-pink-50/20">
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <span class="text-sm font-black text-on-surface">Reference: {{ $order->reference }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusStyle }}">Pending</span>
                            </div>

                            <div class="space-y-3">
                                @forelse ($order->items as $item)
                                    @php
                                        $lineUnitLabel = trim((string) (optional($item->product)->unit ?? 'pcs'));
                                        $lineUnitLabel = preg_replace('/^\d+\s*/', '', $lineUnitLabel) ?: 'pcs';
                                    @endphp
                                    <div class="flex items-center gap-4 p-3 rounded-2xl bg-white border border-pink-50">
                                        @if ($item->product?->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded-lg object-cover shrink-0"/>
                                        @else
                                            <div class="w-12 h-12 rounded-lg overflow-hidden border border-pink-100 bg-white shrink-0 shadow-sm">
                                                <img src="{{ asset('images/logo.jpg') }}" alt="" class="w-full h-full object-cover"/>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-on-surface">{{ optional($item->product)->name ?? 'Deleted Product' }}</p>
                                            <p class="text-xs text-zinc-400">{{ (int) $item->quantity }} {{ $lineUnitLabel }} × PHP {{ number_format((float) $item->unit_price, 2) }}</p>
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
                                <div class="pt-3 flex justify-end gap-2">
                                    <form method="POST" action="{{ route('order-queue.remove', $order) }}" class="remove-order-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="openRemoveModal(this)" class="px-5 py-2 rounded-full bg-zinc-100 text-zinc-700 text-xs font-black border border-zinc-200 hover:bg-zinc-200 active:scale-95 transition-all">
                                            Remove
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('order-queue.finish', $order) }}">
                                        @csrf
                                        <button type="submit" class="px-5 py-2 rounded-full bg-primary text-white text-xs font-black shadow-[0_4px_12px_rgba(224,64,160,0.25)] hover:scale-105 active:scale-95 transition-all">
                                            Finish Order
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-20 flex flex-col items-center gap-4 text-zinc-400">
                    <span class="material-symbols-outlined text-6xl">receipt_long</span>
                    <p class="text-lg font-bold">Queue is empty</p>
                    <a href="{{ route('ordering.index') }}" class="text-primary font-bold hover:underline text-sm">Place an order</a>
                </div>
            @endforelse
        </div>

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

<button
    id="queue-side-floating-toggle"
    type="button"
    onclick="toggleQueueSidePanel()"
    class="hidden xl:flex fixed top-1/2 -translate-y-1/2 right-[19rem] z-50 w-8 h-8 rounded-full bg-white border border-pink-100 text-pink-600 shadow-[0_4px_12px_rgba(224,64,160,0.2)] hover:bg-pink-50 transition-colors items-center justify-center"
    aria-label="Hide side panel"
>
    <span id="queue-side-toggle-icon" class="material-symbols-outlined text-lg">chevron_right</span>
</button>

<aside id="queue-side-panel" class="hidden xl:flex fixed right-0 top-16 w-80 h-[calc(100vh-4rem)] bg-white border-l border-pink-100 rounded-l-2xl p-3 flex-col gap-2 shadow-[-4px_0_16px_rgba(224,64,160,0.05)] transition-transform duration-300">
    <div class="rounded-3xl p-2 flex-1 min-h-0 flex flex-col">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-emerald-600">task_alt</span>
            <h3 class="text-sm font-black text-emerald-700 uppercase tracking-wider">Recent Completed</h3>
        </div>
        <div class="space-y-2 overflow-y-auto pr-1">
            @forelse ($recentCompletedOrders as $completedOrder)
                <div class="rounded-2xl bg-white border border-emerald-100 px-3 py-2">
                    <button type="button" onclick="toggleMiniDetails('completed-mini-{{ $completedOrder->id }}', this)" class="w-full text-left cursor-pointer">
                        <p class="text-sm font-bold text-on-surface">Order #{{ $completedOrder->id }}</p>
                        <p class="text-xs text-zinc-500">{{ optional($completedOrder->completed_at ?? $completedOrder->updated_at)->timezone('Asia/Manila')->format('M d, Y • g:i A') }}</p>
                        <p class="text-xs font-black text-emerald-700 mt-1">PHP {{ number_format((float) $completedOrder->total, 2) }}</p>
                    </button>
                    <div id="completed-mini-{{ $completedOrder->id }}" class="hidden mt-2 pl-6 text-xs text-zinc-600 space-y-1">
                        <p><span class="font-bold">Reference:</span> {{ $completedOrder->reference }}</p>
                        <div>
                            <p class="font-bold">Items:</p>
                            <div class="mt-1 space-y-0.5">
                                @forelse ($completedOrder->items as $detailItem)
                                    <p>{{ optional($detailItem->product)->name ?? 'Deleted Product' }} x{{ (int) $detailItem->quantity }}</p>
                                @empty
                                    <p class="text-zinc-400">No item details.</p>
                                @endforelse
                            </div>
                        </div>
                        <p><span class="font-bold">Subtotal:</span> PHP {{ number_format((float) $completedOrder->subtotal, 2) }}</p>
                        <p><span class="font-bold">Total:</span> PHP {{ number_format((float) $completedOrder->total, 2) }}</p>
                    </div>
                </div>
            @empty
                <p class="text-xs text-zinc-500">No completed orders yet.</p>
            @endforelse
        </div>
    </div>

    <div class="mx-2 border-t border-zinc-200"></div>

    <div class="rounded-3xl p-2 flex-1 min-h-0 flex flex-col">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-rose-600">delete</span>
            <h3 class="text-sm font-black text-rose-700 uppercase tracking-wider">Recent Removed</h3>
        </div>
        <div class="space-y-2 overflow-y-auto pr-1">
            @forelse ($recentRemovedOrders as $removedOrder)
                <div class="rounded-2xl bg-white border border-rose-100 px-3 py-2">
                    <button type="button" onclick="toggleMiniDetails('removed-mini-{{ $removedOrder->id }}', this)" class="w-full text-left cursor-pointer">
                        <p class="text-sm font-bold text-on-surface">Order #{{ $removedOrder->id }}</p>
                        <p class="text-xs text-zinc-500">{{ optional($removedOrder->removed_at ?? $removedOrder->updated_at)->timezone('Asia/Manila')->format('M d, Y • g:i A') }}</p>
                        <p class="text-xs font-black text-rose-700 mt-1">PHP {{ number_format((float) $removedOrder->total, 2) }}</p>
                    </button>
                    <div id="removed-mini-{{ $removedOrder->id }}" class="hidden mt-2 pl-6 text-xs text-zinc-600 space-y-1">
                        <p><span class="font-bold">Reference:</span> {{ $removedOrder->reference }}</p>
                        <div>
                            <p class="font-bold">Items:</p>
                            <div class="mt-1 space-y-0.5">
                                @forelse ($removedOrder->items as $detailItem)
                                    <p>{{ optional($detailItem->product)->name ?? 'Deleted Product' }} x{{ (int) $detailItem->quantity }}</p>
                                @empty
                                    <p class="text-zinc-400">No line items on file (this order was removed before items were kept).</p>
                                @endforelse
                            </div>
                        </div>
                        <p><span class="font-bold">Subtotal:</span> PHP {{ number_format((float) $removedOrder->subtotal, 2) }}</p>
                        <p><span class="font-bold">Total:</span> PHP {{ number_format((float) $removedOrder->total, 2) }}</p>
                        <form method="POST" action="{{ route('order-queue.restore', $removedOrder) }}" class="pt-2">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 rounded-full bg-pink-100 text-pink-700 text-[11px] font-black hover:bg-pink-200 transition-colors">
                                Back to Queue
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-xs text-zinc-500">No removed orders yet.</p>
            @endforelse
        </div>
    </div>
</aside>

<div id="remove-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-md rounded-3xl bg-white border border-pink-100 shadow-[0_12px_36px_rgba(0,0,0,0.15)] p-6">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">delete</span>
            </div>
            <div>
                <h3 class="text-lg font-black text-on-surface">Remove Order</h3>
                <p class="text-sm text-on-surface-variant mt-1">Are you sure you want to remove this order from the queue? Line items stay saved—you can use <span class="font-bold">Back to Queue</span> in Recent Removed.</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-2">
            <button type="button" onclick="closeRemoveModal()" class="px-4 py-2 rounded-full border border-pink-100 text-zinc-600 font-bold text-sm hover:bg-pink-50 transition-colors">
                Cancel
            </button>
            <button type="button" onclick="confirmRemoveOrder()" class="px-4 py-2 rounded-full bg-rose-500 text-white font-black text-sm shadow-[0_4px_12px_rgba(244,63,94,0.25)] hover:bg-rose-600 transition-colors">
                Yes, Remove
            </button>
        </div>
    </div>
</div>

<script>
    let pendingRemoveForm = null;
    let isQueueSidePanelHidden = false;

    function openRemoveModal(button) {
        pendingRemoveForm = button.closest('form');
        const modal = document.getElementById('remove-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRemoveModal() {
        pendingRemoveForm = null;
        const modal = document.getElementById('remove-modal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function confirmRemoveOrder() {
        if (pendingRemoveForm) {
            pendingRemoveForm.submit();
            return;
        }
        closeRemoveModal();
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeRemoveModal();
        }
    });

    document.getElementById('remove-modal').addEventListener('click', function (event) {
        if (event.target.id === 'remove-modal') {
            closeRemoveModal();
        }
    });

    function toggleMiniDetails(id, button) {
        const panel = document.getElementById(id);
        if (!panel) return;
        panel.classList.toggle('hidden');
    }

    function toggleQueueSidePanel() {
        const sidePanel = document.getElementById('queue-side-panel');
        const mainContent = document.getElementById('queue-main');
        const icon = document.getElementById('queue-side-toggle-icon');
        const floatingToggle = document.getElementById('queue-side-floating-toggle');
        if (!sidePanel || !mainContent || !icon || !floatingToggle) return;

        isQueueSidePanelHidden = !isQueueSidePanelHidden;

        sidePanel.style.transform = isQueueSidePanelHidden ? 'translateX(100%)' : 'translateX(0)';
        mainContent.classList.toggle('with-side', !isQueueSidePanelHidden);
        icon.textContent = isQueueSidePanelHidden ? 'chevron_left' : 'chevron_right';
        floatingToggle.style.right = isQueueSidePanelHidden ? '0.5rem' : '19rem';
        floatingToggle.setAttribute('aria-label', isQueueSidePanelHidden ? 'Show side panel' : 'Hide side panel');
    }

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

@include('partials.mobile-nav-drawer')
@include('partials.logout-modal')

</body>
</html>
