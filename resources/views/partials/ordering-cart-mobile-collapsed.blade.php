{{-- Collapsed summary row (mobile floating cart) --}}
<div class="flex items-center gap-2 min-w-0">
    <span class="material-symbols-outlined text-pink-600 shrink-0">shopping_basket</span>
    <span class="font-black text-pink-600 text-sm truncate">My Cart</span>
    <span class="bg-pink-100 text-pink-600 text-xs font-bold px-2 py-0.5 rounded-full shrink-0">{{ $itemCount }} Items</span>
</div>
<span class="text-base font-black text-pink-600 shrink-0">PHP {{ number_format((float) $total, 2) }}</span>
