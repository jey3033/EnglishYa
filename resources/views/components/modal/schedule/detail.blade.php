@props([
    'title' => null,
    'data' => null
])
<div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/50 overlay"></div>
    <div class="modal-content relative bg-primary text-white rounded-lg shadow-xl w-full max-w-lg p-6 scale-95 translate-y-4 opacity-0 transition-all duration-300">
        @if(isset($title))
            <h2 class="text-xl font-bold">
                {{ $title }}
            </h2>
        @endif
        <div class="mt-4">
            {{ $slot }}
        </div>
    </div>
</div>