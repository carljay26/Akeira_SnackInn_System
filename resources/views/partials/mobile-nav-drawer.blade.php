{{-- Mobile / tablet: slide-out sidebar; tap backdrop to close --}}
<div
    id="mobile-nav-backdrop"
    class="fixed inset-0 top-16 z-[48] bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300 ease-out"
    aria-hidden="true"
></div>

<div
    id="mobile-nav-drawer-panel"
    class="fixed left-0 top-16 bottom-0 z-[49] w-64 max-w-[min(16rem,85vw)] border-r border-pink-100 bg-white shadow-[4px_0_24px_rgba(0,0,0,0.08)] flex flex-col gap-2 overflow-y-auto transform -translate-x-full transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]"
    role="dialog"
    aria-modal="true"
    aria-labelledby="mobile-nav-heading"
    hidden
>
    <div class="px-4 pt-4 pb-2 border-b border-pink-100/80">
        <p id="mobile-nav-heading" class="text-xs font-black uppercase tracking-wider text-pink-600">Menu</p>
    </div>
    <div class="px-4 pt-2 pb-4">
        <div class="flex items-center gap-3 mb-4">
            @include('partials.brand-logo', ['class' => 'w-10 h-10 rounded-full object-cover border border-pink-100 bg-white shadow-sm shrink-0'])
            <div>
                <div class="text-sm font-black text-pink-600">Snack Admin</div>
                <div class="text-xs text-zinc-500">Inventory Manager</div>
            </div>
        </div>
        <nav class="flex flex-col gap-1">
            <a class="flex items-center gap-3 px-4 py-3 rounded-full text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]' : 'text-zinc-600 hover:bg-pink-100' }}" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined" @if(request()->routeIs('dashboard')) style="font-variation-settings:'FILL' 1" @endif>dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-full text-sm font-medium transition-colors {{ request()->routeIs('products.*') ? 'bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]' : 'text-zinc-600 hover:bg-pink-100' }}" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined" @if(request()->routeIs('products.*')) style="font-variation-settings:'FILL' 1" @endif>inventory_2</span>
                <span>Products</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-full text-sm font-medium transition-colors {{ request()->routeIs('ordering.*') ? 'bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]' : 'text-zinc-600 hover:bg-pink-100' }}" href="{{ route('ordering.index') }}">
                <span class="material-symbols-outlined" @if(request()->routeIs('ordering.*')) style="font-variation-settings:'FILL' 1" @endif>shopping_cart</span>
                <span>Ordering</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-full text-sm font-medium transition-colors {{ request()->routeIs('order-queue.*') ? 'bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]' : 'text-zinc-600 hover:bg-pink-100' }}" href="{{ route('order-queue.index') }}">
                <span class="material-symbols-outlined" @if(request()->routeIs('order-queue.*')) style="font-variation-settings:'FILL' 1" @endif>queue</span>
                <span>Order Queue</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-full text-sm font-medium transition-colors {{ request()->routeIs('history.*') ? 'bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]' : 'text-zinc-600 hover:bg-pink-100' }}" href="{{ route('history.index') }}">
                <span class="material-symbols-outlined" @if(request()->routeIs('history.*')) style="font-variation-settings:'FILL' 1" @endif>history</span>
                <span>History</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-full text-sm font-medium transition-colors {{ request()->routeIs('reports.*') ? 'bg-pink-600 text-white shadow-[0_4px_12px_rgba(224,64,160,0.3)]' : 'text-zinc-600 hover:bg-pink-100' }}" href="{{ route('reports.index') }}">
                <span class="material-symbols-outlined" @if(request()->routeIs('reports.*')) style="font-variation-settings:'FILL' 1" @endif>analytics</span>
                <span>Reports</span>
            </a>
        </nav>
    </div>
</div>

<script>
(function () {
    var openBtn = document.getElementById('mobile-nav-open');
    var backdrop = document.getElementById('mobile-nav-backdrop');
    var drawer = document.getElementById('mobile-nav-drawer-panel');
    if (!openBtn || !backdrop || !drawer) return;

    function setOpen(open) {
        openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open) {
            drawer.removeAttribute('hidden');
            requestAnimationFrame(function () {
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100');
                drawer.classList.remove('-translate-x-full');
            });
            document.body.classList.add('overflow-hidden');
        } else {
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            backdrop.classList.remove('opacity-100');
            drawer.classList.add('-translate-x-full');
            document.body.classList.remove('overflow-hidden');
            setTimeout(function () {
                if (drawer.classList.contains('-translate-x-full')) drawer.setAttribute('hidden', '');
            }, 320);
        }
    }

    openBtn.addEventListener('click', function () {
        var expanded = openBtn.getAttribute('aria-expanded') === 'true';
        setOpen(!expanded);
    });

    backdrop.addEventListener('click', function () {
        setOpen(false);
    });

    drawer.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () {
            setOpen(false);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && openBtn.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
        }
    });
})();
</script>
