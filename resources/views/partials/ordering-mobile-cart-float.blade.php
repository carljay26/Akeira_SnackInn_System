{{-- Floating mobile cart panel (child of #ordering-mobile-cart-host) --}}
<div
    id="mobile-floating-cart-panel"
    class="pointer-events-auto mx-auto w-full max-w-lg rounded-t-2xl border border-b-0 border-pink-100 bg-white shadow-[0_-8px_32px_rgba(224,64,160,0.2)] flex flex-col overflow-hidden transition-[max-height] duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] max-h-[min(55vh,28rem)]"
>
    <div class="flex justify-center pt-2 pb-1 shrink-0 border-b border-transparent">
        <button
            type="button"
            id="mobile-cart-floating-toggle"
            class="flex items-center justify-center w-14 h-9 rounded-full text-pink-600 hover:bg-pink-50 active:bg-pink-100 transition-colors duration-200"
            aria-expanded="true"
            aria-controls="mobile-cart-expandable"
        >
            <span class="material-symbols-outlined text-3xl leading-none transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]" id="mobile-cart-floating-toggle-icon">expand_more</span>
        </button>
    </div>
    {{-- Expandable main cart (grid rows animate open/closed) --}}
    <div
        id="mobile-cart-expandable"
        class="grid transition-[grid-template-rows] duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] grid-rows-[1fr]"
        aria-hidden="false"
    >
        <div class="min-h-0 overflow-hidden">
            <div id="mobile-cart-floating-body" class="px-5 pt-1 pb-3 flex flex-col min-h-0">
                @include('partials.ordering-cart-panel', ['cartScrollClass' => 'max-h-[min(38vh,15rem)] overflow-y-auto', 'compactHeader' => true])
            </div>
        </div>
    </div>
    {{-- Collapsed summary strip (slides in when main cart is hidden) --}}
    <div
        id="mobile-cart-floating-collapsed"
        class="grid transition-[grid-template-rows] duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] grid-rows-[0fr]"
        aria-hidden="true"
    >
        <div class="min-h-0 overflow-hidden">
            <div class="px-5 py-3 flex items-center justify-between gap-3 border-t border-pink-100">
                @include('partials.ordering-cart-mobile-collapsed')
            </div>
        </div>
    </div>
</div>
