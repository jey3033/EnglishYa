@props([
    'id' => null,
    'title' => null,
    'data' => null
])
<div id="{{ $id ?? "detail-modal" }}" class="fixed inset-0 z-50 hidden items-center justify-center opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/50 overlay"></div>
    <div class="modal-content relative bg-primary text-white rounded-lg shadow-xl w-full max-w-lg p-6 scale-95 translate-y-4 opacity-0 transition-all duration-300">
        @if(isset($title))
            <h2 class="text-xl font-bold">
                {{ $title }}
            </h2>
        @endif
        <div class="mt-4">
            @foreach ($data as $key => $value)
                <div class="flex justify-between">
                    <span class="font-bold">
                        {{ $key }}
                    </span>
                    <span>@if($key == 'Detail')
                                <div class="grid grid-cols-3 font-semibold">
                                    <div>Course</div>
                                    <div>Package</div>
                                    <div>Subtotal</div>
                                </div>
                                @foreach ($value as $item)
                                    <div class="grid grid-cols-3">
                                        <div>{{ $item->course->name }}</div>
                                        <div>{{ $item->term->name }}</div>
                                        <div>{{ number_format($item->subtotal,0,',','.') }}</div>
                                    </div>
                                @endforeach
                            @else
                                {{ $value }}
                            @endif
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>