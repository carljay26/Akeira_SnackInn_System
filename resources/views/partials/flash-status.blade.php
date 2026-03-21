@php
    // Success flash uses green (theme primary-fixed is pink)
    $msg = session('status');
    $excludeWhen = $excludeWhen ?? null;
    $wrapperClass = $wrapperClass ?? 'mb-6 px-4 py-3 rounded-2xl bg-emerald-100 text-emerald-900 text-sm font-bold flex items-center gap-2 border border-emerald-200/90 shadow-sm';
    $showIcon = $showIcon ?? true;
    $dismissMs = isset($dismissMs) ? (int) $dismissMs : 4500;
@endphp
@if ($msg && ($excludeWhen === null || $msg !== $excludeWhen))
    <div
        data-flash-status-banner
        class="{{ $wrapperClass }} transition-opacity duration-300 ease-out will-change-[opacity]"
        style="opacity: 1"
    >
        @if ($showIcon)
            <span class="material-symbols-outlined text-base shrink-0">check_circle</span>
        @endif
        <span>{{ $msg }}</span>
    </div>
    <script>
        (function () {
            var el = document.currentScript.previousElementSibling;
            if (!el || !el.hasAttribute('data-flash-status-banner')) return;
            var ms = {{ $dismissMs }};
            setTimeout(function () {
                el.style.opacity = '0';
                function cleanup() {
                    el.removeEventListener('transitionend', cleanup);
                    if (el.parentNode) el.remove();
                }
                el.addEventListener('transitionend', cleanup);
                setTimeout(function () {
                    if (el.parentNode) el.remove();
                }, 400);
            }, ms);
        })();
    </script>
@endif
