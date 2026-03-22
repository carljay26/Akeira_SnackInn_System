{{-- Brand mark: public/images/logo.jpg --}}
@php
    $class = $class ?? 'w-10 h-10 rounded-full object-cover border border-pink-100/80 bg-white shadow-sm';
@endphp
<img
    src="{{ asset('images/logo.jpg') }}"
    alt="Akeira's Snack Inn"
    class="{{ $class }}"
    loading="lazy"
    decoding="async"
/>
