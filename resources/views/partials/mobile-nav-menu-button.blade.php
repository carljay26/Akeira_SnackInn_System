{{-- Hidden when persistent sidebar is shown (xl+). Below xl, drawer is the main nav. --}}
{{-- Fixed-size wrapper so flex layout cannot collapse the control to 0 width --}}
<div
    class="shrink-0 flex items-center justify-center xl:hidden"
    style="width: 2.75rem; height: 2.75rem; min-width: 2.75rem; min-height: 2.75rem; flex: 0 0 2.75rem;"
>
    <button
        type="button"
        id="mobile-nav-open"
        class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-pink-500 bg-white text-pink-600 shadow-md hover:bg-pink-50 active:bg-pink-100 transition-colors"
        style="display: flex;"
        aria-expanded="false"
        aria-controls="mobile-nav-drawer-panel"
        aria-label="Open menu"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" style="display: block;">
            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
        </svg>
    </button>
</div>
