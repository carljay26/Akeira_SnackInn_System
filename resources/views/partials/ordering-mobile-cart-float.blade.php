{{-- Floating mobile cart panel (child of #ordering-mobile-cart-host) --}}
<div
    id="mobile-floating-cart-panel"
    class="pointer-events-auto mx-auto w-full max-w-lg rounded-t-2xl border border-b-0 border-pink-100 bg-white shadow-[0_-8px_32px_rgba(224,64,160,0.2)] flex flex-col max-h-[min(55vh,28rem)] overflow-hidden transition-[max-height] duration-200 ease-out"
>
    <div class="flex justify-center pt-2 pb-1 shrink-0 border-b border-transparent">
        <button
            type="button"
            id="mobile-cart-floating-toggle"
            class="flex items-center justify-center w-14 h-9 rounded-full text-pink-600 hover:bg-pink-50 active:bg-pink-100 transition-colors"
            aria-expanded="true"
            aria-controls="mobile-cart-floating-body"
        >
            <span class="material-symbols-outlined text-3xl leading-none transition-transform duration-200" id="mobile-cart-floating-toggle-icon">expand_more</span>
        </button>
    </div>
    <div id="mobile-cart-floating-body" class="px-5 pt-1 pb-3 flex flex-col min-h-0">
        @include('partials.ordering-cart-panel', ['cartScrollClass' => 'max-h-[min(38vh,15rem)] overflow-y-auto', 'compactHeader' => true])
    </div>
    <div id="mobile-cart-floating-collapsed" class="hidden px-5 py-3 flex items-center justify-between gap-3 border-t border-pink-100 shrink-0">
        @include('partials.ordering-cart-mobile-collapsed')
    </div>
</div>
