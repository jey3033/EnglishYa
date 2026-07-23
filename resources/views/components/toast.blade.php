@props([
    'id' => 'toast',
    'variant' => 'success',
])

@php
    $colors = [
        'success' => 'bg-success text-white',
        'failed' => 'bg-danger text-white',
    ];
@endphp

<div
    id="{{ $id }}"
    class="fixed top-5 right-5 z-[999] hidden opacity-0 translate-x-8 transition-all duration-300"
>
    <div class="rounded-lg shadow-lg px-5 py-4 flex items-center gap-3 {{ $colors[$variant] }}">
        <div id="{{ $id }}-icon">
            @if($variant == 'success')
                ✅
            @else
                ❌
            @endif
        </div>

        <div id="{{ $id }}-message">
            {{ $slot }}
        </div>
    </div>
</div>