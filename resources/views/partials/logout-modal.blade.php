{{-- Must be included at end of <body> (not inside header): backdrop-blur creates a fixed-position containing block. --}}
<div
    id="logout-confirm-modal"
    class="fixed inset-0 z-[100] hidden overflow-y-auto bg-black/40 px-4 py-8"
    role="dialog"
    aria-modal="true"
    aria-labelledby="logout-confirm-title"
    aria-describedby="logout-confirm-desc"
>
    <div
        class="flex min-h-[100dvh] min-h-screen w-full items-center justify-center"
        onclick="if (event.target === event.currentTarget) closeLogoutConfirmModal()"
    >
        <div class="w-full max-w-md rounded-3xl bg-white border border-pink-100 shadow-[0_12px_36px_rgba(0,0,0,0.15)] p-6 my-auto" onclick="event.stopPropagation()">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">logout</span>
                </div>
                <div>
                    <h3 id="logout-confirm-title" class="text-lg font-black text-on-surface">Log out?</h3>
                    <p id="logout-confirm-desc" class="text-sm text-on-surface-variant mt-1 font-medium">
                        You’ll need to sign in again to access Akeira’s Snack Inn.
                    </p>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button
                    type="button"
                    onclick="closeLogoutConfirmModal()"
                    class="px-4 py-2 rounded-full border border-pink-100 text-zinc-600 font-bold text-sm hover:bg-pink-50 transition-colors"
                >
                    Cancel
                </button>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button
                        type="submit"
                        class="px-4 py-2 rounded-full bg-primary text-on-primary font-black text-sm shadow-[0_4px_12px_rgba(224,64,160,0.3)] hover:opacity-95 transition-opacity"
                    >
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openLogoutConfirmModal() {
        const el = document.getElementById('logout-confirm-modal');
        const btn = document.getElementById('logout-open-btn');
        if (!el) return;
        el.classList.remove('hidden');
        el.classList.add('block');
        document.body.classList.add('overflow-hidden');
        if (btn) btn.setAttribute('aria-expanded', 'true');
    }

    function closeLogoutConfirmModal() {
        const el = document.getElementById('logout-confirm-modal');
        const btn = document.getElementById('logout-open-btn');
        if (!el) return;
        el.classList.add('hidden');
        el.classList.remove('block');
        document.body.classList.remove('overflow-hidden');
        if (btn) btn.setAttribute('aria-expanded', 'false');
    }

    document.getElementById('logout-confirm-modal')?.addEventListener('click', function (e) {
        if (e.target === this) {
            closeLogoutConfirmModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('logout-confirm-modal');
            if (modal && !modal.classList.contains('hidden')) {
                closeLogoutConfirmModal();
            }
        }
    });
</script>
