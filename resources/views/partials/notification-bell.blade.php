@php
    $headerNotifications = $headerNotifications ?? collect();
    $unreadNotificationCount = (int) ($unreadNotificationCount ?? 0);
@endphp

<div class="relative z-[60]" id="notification-dropdown-root">
    <button
        type="button"
        onclick="toggleNotificationDropdown(event)"
        class="cursor-pointer active:scale-95 transition-all hover:scale-105 hover:text-pink-500 text-zinc-500 relative p-1 rounded-full hover:bg-pink-50"
        title="Notifications"
        aria-expanded="false"
        aria-haspopup="true"
        id="notification-bell-btn"
    >
        <span class="material-symbols-outlined">notifications</span>
        @if ($unreadNotificationCount > 0)
            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-primary ring-2 ring-white" aria-hidden="true"></span>
        @endif
    </button>

    <div
        id="notification-dropdown-panel"
        class="hidden absolute right-0 top-full mt-2 w-[min(100vw-2rem,22rem)] max-h-[min(24rem,70vh)] flex-col rounded-2xl border border-pink-100 bg-white shadow-[0_12px_40px_rgba(224,64,160,0.18)] overflow-hidden"
        role="menu"
    >
        <div class="px-4 py-3 border-b border-pink-100 bg-pink-50/40 flex items-center justify-between gap-2 shrink-0">
            <span class="text-sm font-black text-pink-700">Notifications</span>
            @if ($unreadNotificationCount > 0)
                <span class="text-xs font-bold text-pink-600 bg-pink-100 px-2 py-0.5 rounded-full">{{ $unreadNotificationCount }} new</span>
            @endif
        </div>

        <div class="overflow-y-auto flex-1 min-h-0 divide-y divide-pink-50">
            @forelse ($headerNotifications as $note)
                <div
                    class="px-4 py-3 text-left {{ $note->is_read ? 'bg-white' : 'bg-pink-50/50' }}"
                    role="menuitem"
                >
                    <p class="text-sm font-black text-on-surface leading-tight">{{ $note->title }}</p>
                    <p class="text-xs text-zinc-600 mt-1 leading-snug">{{ $note->message }}</p>
                    <p class="text-[10px] font-bold text-zinc-400 mt-1.5 uppercase tracking-wide">
                        {{ $note->created_at?->timezone('Asia/Manila')->format('M d, Y • g:i A') }}
                    </p>
                </div>
            @empty
                <div class="px-4 py-10 text-center text-sm text-zinc-400 font-medium">
                    No notifications yet.
                </div>
            @endforelse
        </div>

        @if ($headerNotifications->isNotEmpty())
            <div class="p-2 border-t border-pink-100 bg-pink-50/20 shrink-0">
                <form method="POST" action="{{ route('notifications.read-all') }}" class="w-full">
                    @csrf
                    <button
                        type="submit"
                        class="w-full py-2.5 rounded-xl text-sm font-black text-pink-600 hover:bg-pink-100 transition-colors"
                    >
                        Mark all as read
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleNotificationDropdown(event) {
        event.stopPropagation();
        const panel = document.getElementById('notification-dropdown-panel');
        const btn = document.getElementById('notification-bell-btn');
        if (!panel || !btn) return;
        panel.classList.toggle('hidden');
        panel.classList.toggle('flex');
        const isOpen = !panel.classList.contains('hidden');
        btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    function closeNotificationDropdown() {
        const panel = document.getElementById('notification-dropdown-panel');
        const btn = document.getElementById('notification-bell-btn');
        if (panel) {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
        }
        if (btn) btn.setAttribute('aria-expanded', 'false');
    }

    document.addEventListener('click', function () {
        closeNotificationDropdown();
    });

    document.getElementById('notification-dropdown-root')?.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeNotificationDropdown();
        }
    });
</script>
