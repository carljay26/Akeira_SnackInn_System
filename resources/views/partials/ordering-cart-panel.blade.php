{{-- Shared cart UI; $cartScrollClass tailors scroll area for sidebar vs stacked mobile card --}}
@php
    $cartScrollClass = $cartScrollClass ?? 'flex-1 min-h-0 overflow-y-auto';
@endphp
<div class="flex shrink-0 items-center justify-between {{ !empty($compactHeader) ? 'mb-4' : 'mb-6' }} xl:mb-8">
    <h2 class="text-xl font-black text-pink-600 flex items-center gap-2">
        <span class="material-symbols-outlined">shopping_basket</span>
        My Cart
    </h2>
    <span class="bg-pink-100 text-pink-600 text-xs font-bold px-2 py-1 rounded-full">{{ $itemCount }} Items</span>
</div>

<div class="{{ $cartScrollClass }} space-y-4 pr-2">
    @forelse ($cartItems as $item)
        @php
            $unitLabel = trim((string) ($item['unit'] ?? 'pcs'));
            $unitLabel = preg_replace('/^\d+\s*/', '', $unitLabel) ?: 'pcs';
        @endphp
        <div class="flex gap-3 items-center p-2 rounded-lg hover:bg-pink-50 transition-colors">
            @if (!empty($item['image_path']))
                <img class="w-12 h-12 rounded-lg object-cover" src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}"/>
            @else
                <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1;">lunch_dining</span>
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-bold truncate">{{ $item['name'] }}</h4>
                <p class="text-xs text-zinc-500">{{ $item['quantity'] }} {{ $unitLabel }} x PHP {{ number_format((float) $item['price'], 2) }}</p>
            </div>
            <div class="text-right shrink-0">
                <span class="text-sm font-black text-pink-600 block">PHP {{ number_format($item['quantity'] * $item['price'], 2) }}</span>
                <div class="mt-1 inline-flex items-center gap-2 rounded-full border border-pink-100 bg-pink-50 px-2 py-1">
                    <form method="POST" action="{{ route('ordering.cart.decrement', $item['id']) }}" data-ordering-cart-async>
                        @csrf
                        @method('PATCH')
                        <button class="w-5 h-5 flex items-center justify-center rounded-full text-pink-600 hover:bg-pink-100 font-black leading-none" type="submit" aria-label="Decrease quantity">-</button>
                    </form>
                    <span class="text-xs font-black text-zinc-600 min-w-4 text-center">{{ $item['quantity'] }}</span>
                    <form method="POST" action="{{ route('ordering.cart.add') }}" data-ordering-cart-async>
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                        <input type="hidden" name="quantity" value="1">
                        <button class="w-5 h-5 flex items-center justify-center rounded-full text-pink-600 hover:bg-pink-100 font-black leading-none" type="submit" aria-label="Increase quantity">+</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-sm text-zinc-500 font-medium">Your cart is empty.</p>
    @endforelse
</div>

<div class="border-t border-pink-100 pt-6 mt-6 shrink-0">
    <div class="flex justify-between mb-2">
        <span class="text-zinc-500">Subtotal</span>
        <span class="font-bold">PHP {{ number_format($subtotal, 2) }}</span>
    </div>
    <div class="flex justify-between mb-6">
        <span class="text-lg font-black">Total</span>
        <span class="text-lg font-black text-pink-600">PHP {{ number_format($total, 2) }}</span>
    </div>
    <form method="POST" action="{{ route('ordering.place-order') }}">
        @csrf
        <button class="w-full bg-primary text-white py-4 rounded-full font-black shadow-[0_4px_16px_rgba(224,64,160,0.3)] bouncy-hover active:scale-95 flex items-center justify-center gap-2 {{ $itemCount === 0 ? 'opacity-60 cursor-not-allowed' : '' }}" type="submit" {{ $itemCount === 0 ? 'disabled' : '' }}>
            Place Order
            <span class="material-symbols-outlined">send</span>
        </button>
    </form>
</div>
